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
     * Place the order (Step 1).
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

            // Temporary values (will be updated in Step 2)
            'service_type' => '',
            'weight_quantity' => 0,
            'collection_address' => '',
            'total_price' => 0,

            'status' => Order::STATUS_PENDING,
        ]);

        return redirect()->route(
            'customer.service-selection',
            $order->id
        );
    }

    /**
     * Cancel order.
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
     * Step 2 page.
     */
    public function serviceSelection($id)
    {
        $order = Order::findOrFail($id);

        return view('customer.service-selection', compact('order'));
    }
    public function saveService(Request $request, Order $order)
{
    $request->validate([
        'service_type' => 'required',
        'weight_quantity' => 'required|numeric|min:1',
        'special_instructions' => 'nullable|string'
    ]);

    $order->update([

        'service_type' => $request->service_type,

        'weight_quantity' => $request->weight_quantity,

        'total_price' => $request->total_price,

        'estimated_turnaround' => $request->special_instructions

    ]);

    return redirect()->route(
        'customer.pickup-details',
        $order->id
    );
}
}