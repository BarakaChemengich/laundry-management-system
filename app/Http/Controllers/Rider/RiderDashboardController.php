<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class RiderDashboardController extends Controller
{
    public function index()
    {
        $jobs = Order::where('rider_id', auth()->id())
            ->orWhere(function ($query) {
                $query->whereNull('rider_id')
                    ->where('status', 'ACCEPTED');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $totalEarnings = Order::where('rider_id', auth()->id())
            ->where('status', 'DELIVERED')
            ->sum('total_price') * 0.20;

        $completedCount = Order::where('rider_id', auth()->id())
            ->where('status', 'DELIVERED')
            ->count();

        $isOnline = auth()->user()->is_available ?? false;

        return view('rider.dashboard', compact('jobs', 'totalEarnings', 'completedCount', 'isOnline'));
    }

    public function toggleAvailability(Request $request)
    {
        $user = auth()->user();
        $user->is_available = !$user->is_available;
        $user->save();

        return back()->with('success', 'Availability toggled to ' . ($user->is_available ? 'Online' : 'Offline'));
    }

    public function handshake(Request $request, Order $order)
    {
        $request->validate([
            'action' => 'required|in:ACCEPT,REJECT'
        ]);

        if ($order->status !== 'PENDING_ASSIGNMENT' && $order->status !== 'ACCEPTED') {
            return back()->with('error', 'This order is no longer available for assignment.');
        }

        if ($request->action === 'ACCEPT') {
            $order->rider_id = auth()->id();
            $order->transitionTo('ACCEPTED');
            return back()->with('success', 'Assignment accepted! Please proceed to pickup.');
        } else {
            $order->transitionTo('REJECTED');
            return back()->with('success', 'Assignment rejected.');
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        if ($order->rider_id !== auth()->id()) {
            abort(403, 'You are not assigned to this order.');
        }

        $newStatus = $request->status;

        if (!$order->canTransitionTo($newStatus)) {
            return back()->with('error', 'Invalid status transition from ' . $order->status . ' to ' . $newStatus);
        }

        $order->transitionTo($newStatus);

        return back()->with('success', 'Delivery status updated to ' . str_replace('_', ' ', $newStatus));
    }
}