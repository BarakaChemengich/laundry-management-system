@extends('layouts.app')

@section('content')
<div class="dashboard-content">

    <div class="greeting-section">
        <h1>Order Management 📦</h1>
        <p>View and manage all orders across the platform.</p>
    </div>

    <!-- Filters -->
    <div class="filter-bar">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="filter-form">
            <div class="filter-group">
                <input type="text" name="search" placeholder="Search orders..." value="{{ request('search') }}" class="filter-input">
            </div>
            <div class="filter-group">
                <select name="status" class="filter-select">
                    <option value="">All Status</option>
                    <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>Pending</option>
                    <option value="ACCEPTED" {{ request('status') == 'ACCEPTED' ? 'selected' : '' }}>Accepted</option>
                    <option value="PICKED_UP" {{ request('status') == 'PICKED_UP' ? 'selected' : '' }}>Picked Up</option>
                    <option value="WASHING" {{ request('status') == 'WASHING' ? 'selected' : '' }}>Washing</option>
                    <option value="READY" {{ request('status') == 'READY' ? 'selected' : '' }}>Ready</option>
                    <option value="EN_ROUTE" {{ request('status') == 'EN_ROUTE' ? 'selected' : '' }}>En Route</option>
                    <option value="DELIVERED" {{ request('status') == 'DELIVERED' ? 'selected' : '' }}>Delivered</option>
                    <option value="CANCELLED" {{ request('status') == 'CANCELLED' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="filter-group">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="filter-input" placeholder="Date From">
            </div>
            <div class="filter-group">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="filter-input" placeholder="Date To">
            </div>
            <button type="submit" class="btn-filter">
                <i class="fas fa-search"></i> Filter
            </button>
            <a href="{{ route('admin.orders.index') }}" class="btn-reset">Reset</a>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="section-card">
        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Vendor</th>
                        <th>Rider</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td><strong>#00{{ $order->id }}</strong></td>
                            <td>{{ $order->customer->name ?? 'N/A' }}</td>
                            <td>{{ $order->vendor->name ?? 'Unassigned' }}</td>
                            <td>{{ $order->rider->name ?? 'Unassigned' }}</td>
                            <td>KES {{ number_format($order->total_price, 2) }}</td>
                            <td>
                                <span class="status-badge {{ strtolower($order->status) }}">
                                    {{ str_replace('_', ' ', $order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.view', $order) }}" class="btn-view">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-row">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="table-footer">
            {{ $orders->links() }}
        </div>
    </div>

</div>

<style>
.btn-view {
    padding: 4px 10px;
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    background: var(--white);
    color: var(--blue);
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-view:hover {
    background: var(--blue);
    color: white;
    border-color: var(--blue);
}
</style>

@endsection