@extends('layouts.app')

@section('content')
<div class="dashboard-content">

    <div class="greeting-section">
        <h1>Payment Management 💳</h1>
        <p>View all payments, monitor transactions, and manage refunds.</p>
    </div>

    <!-- Filters -->
    <div class="filter-bar">
        <form method="GET" action="{{ route('admin.payments.index') }}" class="filter-form">
            <div class="filter-group">
                <input type="text" name="search" placeholder="Search by receipt..." value="{{ request('search') }}" class="filter-input">
            </div>
            <div class="filter-group">
                <select name="status" class="filter-select">
                    <option value="">All Status</option>
                    <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>Pending</option>
                    <option value="COMPLETED" {{ request('status') == 'COMPLETED' ? 'selected' : '' }}>Completed</option>
                    <option value="FAILED" {{ request('status') == 'FAILED' ? 'selected' : '' }}>Failed</option>
                    <option value="REFUNDED" {{ request('status') == 'REFUNDED' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <button type="submit" class="btn-filter">
                <i class="fas fa-search"></i> Filter
            </button>
            <a href="{{ route('admin.payments.index') }}" class="btn-reset">Reset</a>
        </form>
    </div>

    <!-- Payments Table -->
    <div class="section-card">
        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Payment #</th>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Amount</th>
                        <th>Receipt</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td><strong>#{{ $payment->id }}</strong></td>
                            <td>#00{{ $payment->order_id }}</td>
                            <td>{{ $payment->order->customer->name ?? 'N/A' }}</td>
                            <td>{{ $payment->phone_number ?? 'N/A' }}</td>
                            <td>KES {{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->mpesa_receipt_number ?? 'N/A' }}</td>
                            <td>
                                <span class="status-badge {{ strtolower($payment->status) }}">
                                    {{ $payment->status }}
                                </span>
                            </td>
                            <td>{{ $payment->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($payment->status === 'COMPLETED')
                                    <form action="{{ route('admin.payments.refund', $payment) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="reason" value="Refund initiated by admin">
                                        <button type="submit" class="btn-refund" onclick="return confirm('Are you sure you want to refund this payment?')">
                                            <i class="fas fa-undo"></i> Refund
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="empty-row">No payments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="table-footer">
            {{ $payments->links() }}
        </div>
    </div>

</div>

<style>
.btn-refund {
    padding: 4px 12px;
    border: none;
    border-radius: var(--radius-sm);
    background: #FEF3C7;
    color: #92400E;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.btn-refund:hover {
    background: #FDE68A;
}
</style>

@endsection