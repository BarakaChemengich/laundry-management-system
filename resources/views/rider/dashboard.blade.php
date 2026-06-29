<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rider Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-xs font-bold uppercase text-gray-400">Total Earnings</p>
                    <p class="text-2xl font-bold text-green-600">KES {{ number_format($totalEarnings, 2) }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-xs font-bold uppercase text-gray-400">Completed Deliveries</p>
                    <p class="text-2xl font-bold">{{ $completedCount }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-xs font-bold uppercase text-gray-400">Status</p>
                    <p class="text-2xl font-bold {{ $isOnline ? 'text-green-600' : 'text-red-600' }}">
                        {{ $isOnline ? '🟢 Online' : '🔴 Offline' }}
                    </p>
                    <form action="{{ route('rider.toggle-availability') }}" method="POST">
                        @csrf
                        <button type="submit" class="mt-2 text-sm {{ $isOnline ? 'bg-red-500' : 'bg-green-500' }} text-white px-4 py-1 rounded">
                            {{ $isOnline ? 'Go Offline' : 'Go Online' }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Active Deliveries</h3>
                    @forelse($jobs as $job)
                        <div class="border-b border-gray-100 py-4 flex justify-between items-center">
                            <div>
                                <p class="font-bold">Order #00{{ $job->id }}</p>
                                <p class="text-sm text-gray-500">{{ $job->collection_address }}</p>
                                <span class="text-xs px-2 py-1 rounded bg-yellow-100 text-yellow-800">{{ $job->status }}</span>
                            </div>
                            <div>
                                @if($job->status === 'PENDING_ASSIGNMENT')
                                    <form action="{{ route('rider.order.handshake', $job) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="action" value="ACCEPT">
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded text-sm">Accept</button>
                                    </form>
                                    <form action="{{ route('rider.order.handshake', $job) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="action" value="REJECT">
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded text-sm">Reject</button>
                                    </form>
                                @elseif($job->status !== 'DELIVERED')
                                    <form action="{{ route('rider.order.transition', $job) }}" method="POST" class="inline">
                                        @csrf
                                        <select name="status" class="border rounded px-2 py-1 text-sm">
                                            @if($job->status === 'ACCEPTED')
                                                <option value="PICKED_UP">Mark Picked Up</option>
                                            @endif
                                            @if($job->status === 'PICKED_UP')
                                                <option value="EN_ROUTE">Mark En Route</option>
                                            @endif
                                            @if($job->status === 'EN_ROUTE')
                                                <option value="DELIVERED">Mark Delivered</option>
                                            @endif
                                        </select>
                                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded text-sm">Update</button>
                                    </form>
                                @else
                                    <span class="text-green-600 font-bold">✅ Delivered</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No active deliveries.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>