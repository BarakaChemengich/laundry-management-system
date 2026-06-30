<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\LaundryPackage;
use App\Models\Message;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $packages = LaundryPackage::where('is_active', true)->get();
        $orders = Order::where('customer_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentOrders = Order::where('customer_id', auth()->id())
            ->whereIn('status', ['PENDING', 'ACCEPTED', 'PICKED_UP', 'WASHING', 'READY', 'EN_ROUTE'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        $stats = [
            'total_orders' => Order::where('customer_id', auth()->id())->count(),
            'active_orders' => Order::where('customer_id', auth()->id())
                ->whereIn('status', ['PENDING', 'ACCEPTED', 'PICKED_UP', 'WASHING', 'READY', 'EN_ROUTE'])
                ->count(),
            'completed_orders' => Order::where('customer_id', auth()->id())
                ->where('status', 'DELIVERED')
                ->count(),
        ];

        return view('customer.dashboard', compact('packages', 'orders', 'recentOrders', 'stats'));
    }
      
    public function newOrder($id)
{
    $package = LaundryPackage::findOrFail($id);

    return view('customer.new-order', compact('package'));
}
    public function storeOrder(Request $request)
    {
        $request->validate([
            'laundry_package_id' => 'required|exists:laundry_packages,id',
            'weight_quantity' => 'required|numeric|min:0.5',
            'collection_address' => 'required|string|max:500',
            'scheduled_pickup_at' => 'required|date|after:now',
        ]);

        $package = LaundryPackage::findOrFail($request->laundry_package_id);
        $totalPrice = $package->price_per_unit * $request->weight_quantity;

        DB::transaction(function () use ($request, $package, $totalPrice) {
            $order = Order::create([
    'customer_id' => auth()->id(),
    'laundry_package_id' => $package->id,
    'service_type' => $package->name,
    'weight_quantity' => $request->weight_quantity,
    'total_price' => $totalPrice,
    'collection_address' => $request->collection_address,
    'scheduled_pickup_at' => $request->scheduled_pickup_at,
    'status' => 'PENDING',
    'estimated_turnaround' => $package->estimated_hours . ' hours',
]);

            \App\Models\Payment::create([
                'order_id' => $order->id,
                'amount' => $totalPrice,
                'status' => 'PENDING',
                'payment_method' => 'M-Pesa',
            ]);
        });

        return redirect()->route('customer.dashboard')
            ->with('success', 'Order placed successfully! Please complete payment.');
    }

    public function trackOrder($orderId)
    {
        $order = Order::with(['vendor', 'rider', 'statusLogs'])
            ->where('customer_id', auth()->id())
            ->findOrFail($orderId);

        return response()->json([
            'status' => $order->status,
            'vendor' => $order->vendor ? $order->vendor->name : null,
            'rider' => $order->rider ? $order->rider->name : null,
            'collection_address' => $order->collection_address,
            'estimated_turnaround' => $order->estimated_turnaround,
            'status_logs' => $order->statusLogs,
        ]);
    }

    public function rateVendor(Request $request, $orderId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $order = Order::where('customer_id', auth()->id())->findOrFail($orderId);

        if ($order->status !== 'DELIVERED') {
            return back()->with('error', 'You can only rate after order is delivered.');
        }

        if (!$order->vendor_id) {
            return back()->with('error', 'No vendor assigned to this order.');
        }

        Rating::create([
            'order_id' => $order->id,
            'customer_id' => auth()->id(),
            'vendor_id' => $order->vendor_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Rating submitted successfully!');
    }

    public function sendMessage(Request $request, $orderId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $order = Order::where('customer_id', auth()->id())->findOrFail($orderId);
        $recipientId = $order->vendor_id ?? $order->rider_id;

        if (!$recipientId) {
            return back()->with('error', 'No active service provider assigned.');
        }

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $recipientId,
            'order_id' => $order->id,
            'content' => $request->message,
        ]);

        return back()->with('success', 'Message sent successfully.');
    }

    public function reorder($orderId)
    {
        $order = Order::where('customer_id', auth()->id())->findOrFail($orderId);

        $newOrder = Order::create([
            'customer_id' => auth()->id(),
            'laundry_package_id' => $order->laundry_package_id,
            'service_type' => $order->service_type,
            'weight_quantity' => $order->weight_quantity,
            'total_price' => $order->total_price,
            'collection_address' => $order->collection_address,
            'status' => 'PENDING',
            'estimated_turnaround' => $order->estimated_turnaround,
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Order reordered successfully!');
    }
}