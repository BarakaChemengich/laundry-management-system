<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Rating;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'PENDING')->count(),
            'completed_orders' => Order::where('status', 'DELIVERED')->count(),
            'total_customers' => User::where('role_id', 2)->count(),
            'total_vendors' => User::where('role_id', 3)->count(),
            'total_riders' => User::where('role_id', 4)->count(),
            'pending_vendors' => User::where('role_id', 3)->where('status', 'pending')->count(),
            'pending_riders' => User::where('role_id', 4)->where('status', 'pending')->count(),
            'total_revenue' => Payment::where('status', 'COMPLETED')->sum('amount'),
            'avg_rating' => Rating::avg('rating') ?? 0,
        ];

        $recentOrders = Order::with(['customer', 'vendor'])->latest()->limit(10)->get();
        $recentPayments = Payment::with('order')->latest()->limit(10)->get();
        $pendingUsers = User::whereIn('role_id', [3, 4])->where('status', 'pending')->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentPayments', 'pendingUsers'));
    }

    public function users()
    {
        $users = User::with('role')
            ->whereIn('role_id', [2, 3, 4])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function approveUser(User $user)
    {
        if (!in_array($user->role_id, [3, 4])) {
            return back()->with('error', 'Only vendors and riders require approval.');
        }

        $user->status = 'approved';
        $user->save();

        return back()->with('success', 'User approved successfully!');
    }

    public function rejectUser(User $user)
    {
        $user->status = 'rejected';
        $user->save();

        return back()->with('success', 'User rejected.');
    }

    public function orders()
    {
        $orders = Order::with(['customer', 'vendor', 'rider'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.orders', compact('orders'));
    }

    public function payments()
    {
        $payments = Payment::with('order.customer')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.payments', compact('payments'));
    }
}