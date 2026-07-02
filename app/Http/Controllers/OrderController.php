<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Save the selected laundry store.
     */
    public function selectStore(Request $request)
    {
        session([
            'vendor_id' => $request->vendor_id,
            'vendor_name' => $request->vendor_name,
            'price_per_kg' => $request->price
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * STEP 1
     * Create a new order after selecting a laundry.
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required',
            'laundry_package_id' => 'required'
        ]);

        $order = Order::create([
            'customer_id' => auth()->id(),
            'vendor_id' => $request->vendor_id,
            'laundry_package_id' => $request->laundry_package_id,

            // These will be updated later
            'service_type' => '',
            'weight_quantity' => 0,
            'collection_address' => '',
            'scheduled_pickup_at' => null,
            'estimated_turnaround' => '',
            'total_price' => 0,

            'status' => Order::STATUS_PENDING,
        ]);

        return redirect()->route(
            'customer.service-selection',
            $order->id
        );
    }

    /**
     * Cancel Order
     */
    public function cancel()
    {
        session()->forget([
            'vendor_id',
            'vendor_name',
            'price_per_kg',
            'order_id'
        ]);

        return redirect()->route('customer.dashboard');
    }

    /**
     * STEP 2 PAGE
     */
    public function serviceSelection($id)
    {
        $order = Order::findOrFail($id);

        return view('customer.service-selection', compact('order'));
    }

    /**
     * Save Step 2
     */
    public function saveService(Request $request, Order $order)
    {
        $request->validate([
            'service_type' => 'required',
            'weight_quantity' => 'required|numeric|min:1',
            'total_price' => 'required|numeric',
            'special_instructions' => 'nullable|string'
        ]);

        $order->update([

            'service_type' => $request->service_type,

            'weight_quantity' => $request->weight_quantity,

            'total_price' => $request->total_price,

            // Temporary storage
            'estimated_turnaround' => $request->special_instructions

        ]);

        return redirect()->route(
            'customer.pickup-details',
            $order->id
        );
    }

    /**
     * STEP 3 PAGE
     */
    public function pickupDetails($id)
    {
        $order = Order::with('vendor')->findOrFail($id);

        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        return view('customer.pickup-details', compact('order'));
    }

    /**
     * Save Step 3
     */
    public function savePickupDetails(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'pickup_date' => 'required|date',
            'pickup_time' => 'required',
            'return_date' => 'nullable|date|after_or_equal:pickup_date',
            'collection_address' => 'required|string',
            'return_address' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'delivery_option' => 'nullable|string|max:100',
        ]);

        $order->update([
            'scheduled_pickup_at' => $request->pickup_date . ' ' . $request->pickup_time,
            'return_date' => $request->return_date,
            'collection_address' => $request->collection_address,
            'return_address' => $request->return_address,
            'delivery_option' => $request->delivery_option,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()
            ->route('customer.pickup-details', $order->id)
            ->with('success', 'Schedule and logistics saved successfully.');
    }
}