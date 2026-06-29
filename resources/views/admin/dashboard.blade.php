<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-xs font-bold uppercase text-gray-400">Total Orders</p>
                    <p class="text-2xl font-bold">{{ $stats['total_orders'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-xs font-bold uppercase text-gray-400">Revenue</p>
                    <p class="text-2xl font-bold text-green-600">KES {{ number_format($stats['total_revenue'], 2) }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-xs font-bold uppercase text-gray-400">Avg Rating</p>
                    <p class="text-2xl font-bold text-blue-600">⭐ {{ number_format($stats['avg_rating'], 1) }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-xs font-bold uppercase text-gray-400">Pending Vendors</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending_vendors'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-4">Recent Orders</h3>
                        @forelse($recentOrders as $order)
                            <div class="border-b border-gray-100 py-2 text-sm">
                                <p class="font-bold">Order #00{{ $order->id }}</p>
                                <p class="text-gray-500">{{ $order->customer->name }} - {{ $order->status }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500">No recent orders.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-4">Recent Payments</h3>
                        @forelse($recentPayments as $payment)
                            <div class="border-b border-gray-100 py-2 text-sm">
                                <p class="font-bold">Payment #{{ $payment->id }}</p>
                                <p class="text-gray-500">KES {{ number_format($payment->amount, 2) }} - {{ $payment->status }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500">No recent payments.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            @if($pendingUsers->count() > 0)
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-4 text-yellow-600">Pending Approvals</h3>
                        @foreach($pendingUsers as $user)
                            <div class="border-b border-gray-100 py-2 flex justify-between items-center">
                                <div>
                                    <p class="font-bold">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $user->email }} - {{ $user->role->display_name }}</p>
                                </div>
                                <div>
                                    <form action="{{ route('admin.users.approve', $user) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-4 py-1 rounded text-sm">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.users.reject', $user) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded text-sm">Reject</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>