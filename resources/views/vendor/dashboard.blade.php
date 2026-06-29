<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vendor Dashboard') }}
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
                    <p class="text-xs font-bold uppercase text-gray-400">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending_orders'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-xs font-bold uppercase text-gray-400">Completed</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['completed_orders'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-xs font-bold uppercase text-gray-400">Rating</p>
                    <p class="text-2xl font-bold text-blue-600">⭐ {{ number_format($stats['average_rating'], 1) }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Active Orders</h3>
                    @forelse($tasks as $task)
                        <div class="border-b border-gray-100 py-4 flex justify-between items-center">
                            <div>
                                <p class="font-bold">Order #00{{ $task->id }}</p>
                                <p class="text-sm text-gray-500">{{ $task->customer->name }} - {{ $task->collection_address }}</p>
                                <span class="text-xs px-2 py-1 rounded bg-yellow-100 text-yellow-800">{{ $task->status }}</span>
                            </div>
                            <div>
                                @if($task->status === 'PENDING')
                                    <form action="{{ route('vendor.orders.accept', $task) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded text-sm">Accept</button>
                                    </form>
                                @else
                                    <form action="{{ route('vendor.orders.status', $task) }}" method="POST" class="inline">
                                        @csrf
                                        <select name="status" class="border rounded px-2 py-1 text-sm">
                                            @if($task->status === 'ACCEPTED')
                                                <option value="PICKED_UP">Mark Picked Up</option>
                                            @endif
                                            @if($task->status === 'PICKED_UP')
                                                <option value="WASHING">Mark Washing</option>
                                            @endif
                                            @if($task->status === 'WASHING')
                                                <option value="READY">Mark Ready</option>
                                            @endif
                                            @if($task->status === 'READY')
                                                <option value="EN_ROUTE">Mark En Route</option>
                                            @endif
                                        </select>
                                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded text-sm">Update</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No active orders.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>