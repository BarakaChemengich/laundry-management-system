<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $tasks = Order::where('vendor_id', auth()->id())
            ->whereIn('status', ['PENDING', 'ACCEPTED', 'PICKED_UP', 'WASHING', 'READY'])
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_orders' => Order::where('vendor_id', auth()->id())->count(),
            'completed_orders' => Order::where('vendor_id', auth()->id())
                ->where('status', 'DELIVERED')
                ->count(),
            'pending_orders' => Order::where('vendor_id', auth()->id())
                ->where('status', 'PENDING')
                ->count(),
            'total_earnings' => Order::where('vendor_id', auth()->id())
                ->where('status', 'DELIVERED')
                ->sum('total_price'),
            'average_rating' => Rating::where('vendor_id', auth()->id())->avg('rating') ?? 0,
        ];

        return view('vendor.dashboard', compact('tasks', 'stats'));
    }

    public function acceptOrder(Order $order)
    {
        if ($order->vendor_id !== null && $order->vendor_id !== auth()->id()) {
            return back()->with('error', 'This order is already assigned to another vendor.');
        }

        DB::transaction(function () use ($order) {
            $order->vendor_id = auth()->id();
            $order->transitionTo('ACCEPTED');
        });

        return back()->with('success', 'Order accepted successfully!');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        if ($order->vendor_id !== auth()->id()) {
            abort(403, 'You are not authorized to update this order.');
        }

        $newStatus = $request->status;

        if (!$order->canTransitionTo($newStatus)) {
            return back()->with('error', 'Invalid status transition from ' . $order->status . ' to ' . $newStatus);
        }

        $order->transitionTo($newStatus);

        return back()->with('success', 'Status updated to ' . str_replace('_', ' ', $newStatus));
    }

    public function earnings()
    {
        $stats = [
            'total_earnings' => Order::where('vendor_id', auth()->id())
                ->where('status', 'DELIVERED')
                ->sum('total_price'),
            'completed_orders' => Order::where('vendor_id', auth()->id())
                ->where('status', 'DELIVERED')
                ->count(),
            'average_rating' => Rating::where('vendor_id', auth()->id())->avg('rating') ?? 0,
            'total_ratings' => Rating::where('vendor_id', auth()->id())->count(),
            'weekly_earnings' => Order::where('vendor_id', auth()->id())
                ->where('status', 'DELIVERED')
                ->where('completed_at', '>=', now()->subDays(7))
                ->sum('total_price'),
        ];

        return view('vendor.earnings', compact('stats'));
    }
}