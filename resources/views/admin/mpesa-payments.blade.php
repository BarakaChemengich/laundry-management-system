@extends('layouts.app')

@section('content')
<div class="dashboard-content">

    <div class="greeting-section">
        <h1>M-Pesa Payment Management 💳</h1>
        <p>Monitor, manage, and initiate M-Pesa transactions across the platform.</p>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        @foreach(['completed' => ['green', 'fa-check-circle', 'Completed', $stats['completed'], 'KES '.number_format($stats['total'], 2)],
                  'pending' => ['amber', 'fa-clock', 'Pending', $stats['pending'], 'Awaiting confirmation'],
                  'failed' => ['red', 'fa-times-circle', 'Failed', $stats['failed'], 'Transactions failed'],
                  'refunded' => ['purple', 'fa-undo', 'Refunded', $stats['refunded'], 'Refunds processed']] as $key => [$color, $icon, $label, $value, $sub])
        <div class="stat-card">
            <div class="stat-icon {{ $color }}"><i class="fas {{ $icon }}"></i></div>
            <div>
                <p class="stat-label">{{ $label }}</p>
                <p class="stat-value">{{ number_format($value) }}</p>
                <p class="stat-sub">{{ $sub }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Revenue -->
    <div class="stats-grid" style="margin-bottom:24px;">
        <div class="stat-card" style="grid-column:span 4;">
            <div class="stat-icon indigo" style="width:auto;background:none;padding:0 8px 0 0;">
                <i class="fas fa-chart-line" style="font-size:24px;"></i>
            </div>
            <div style="flex:1;">
                <p class="stat-label">Revenue Overview</p>
                <div style="display:flex;gap:32px;margin-top:4px;flex-wrap:wrap;">
                    @foreach(['Today' => $stats['today'], 'This Week' => $stats['this_week'], 'This Month' => $stats['this_month'], 'Total' => $stats['total']] as $label => $amount)
                    <div>
                        <span style="font-size:12px;color:var(--muted);">{{ $label }}</span>
                        <p style="font-size:18px;font-weight:700;color:{{ $label === 'Total' ? 'var(--blue)' : 'var(--text)' }};">KES {{ number_format($amount, 2) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Initiate Payment -->
    <div class="section-card" style="border-left:4px solid var(--blue);">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-plus-circle" style="color:var(--blue);"></i>
                <h2>Initiate M-Pesa Payment</h2>
            </div>
        </div>
        <div style="padding:20px;">
            <form id="initiatePaymentForm" class="mpesa-init-form">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>Order ID</label>
                        <input type="number" name="order_id" id="initOrderId" placeholder="Enter Order ID" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" id="initPhone" placeholder="254712345678" required class="form-control">
                    </div>
                    <div class="form-group" style="display:flex;align-items:flex-end;">
                        <button type="button" onclick="initiateMpesaFromAdmin()" class="btn-initiate">
                            <i class="fas fa-paper-plane"></i> Send STK Push
                        </button>
                    </div>
                </div>
                <div id="initStatus" class="init-status"></div>
            </form>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-bar">
        <form method="GET" action="{{ route('admin.mpesa-payments.index') }}" class="filter-form">
            <div class="filter-group">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="filter-input">
            </div>
            <div class="filter-group">
                <select name="status" class="filter-select">
                    <option value="">All Status</option>
                    @foreach(['PENDING'=>'Pending','COMPLETED'=>'Completed','FAILED'=>'Failed','REFUNDED'=>'Refunded'] as $val => $label)
                    <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="filter-input">
            </div>
            <div class="filter-group">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="filter-input">
            </div>
            <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Filter</button>
            <a href="{{ route('admin.mpesa-payments.index') }}" class="btn-reset">Reset</a>
        </form>
    </div>

    <!-- Table -->
    <div class="section-card">
        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Payment #</th><th>Order #</th><th>Customer</th><th>Phone</th>
                        <th>Amount</th><th>Receipt</th><th>Merchant ID</th><th>Status</th><th>Date</th><th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td><strong>#{{ $payment->id }}</strong></td>
                        <td>#00{{ $payment->order_id }}</td>
                        <td>{{ $payment->order->customer->name ?? 'N/A' }}</td>
                        <td>{{ $payment->phone_number ?? 'N/A' }}</td>
                        <td><strong>KES {{ number_format($payment->amount, 2) }}</strong></td>
                        <td><span class="receipt-text">{{ $payment->mpesa_receipt_number ?? 'N/A' }}</span></td>
                        <td><span class="merchant-id">{{ Str::limit($payment->merchant_request_id ?? 'N/A', 15) }}</span></td>
                        <td><span class="status-badge {{ strtolower($payment->status) }}">{{ $payment->status }}</span></td>
                        <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            @if($payment->status === 'COMPLETED')
                            <button onclick="openRefundModal({{ $payment->id }})" class="btn-refund" title="Refund"><i class="fas fa-undo"></i></button>
                            @elseif($payment->status === 'PENDING')
                            <span class="text-muted">Waiting...</span>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="10" class="empty-row">No M-Pesa payments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="table-footer">{{ $payments->links() }}</div>
    </div>

</div>

<!-- Refund Modal -->
<div id="refundModal" class="modal-overlay hidden">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-undo" style="color:var(--orange);"></i> Refund Payment</h3>
            <button onclick="closeRefundModal()" class="modal-close"><i class="fas fa-times"></i></button>
        </div>
        <form id="refundForm" method="POST" action="">
            @csrf
            <div class="modal-body">
                <div class="payment-info-box">
                    <p><strong>Payment ID:</strong> <span id="refundPaymentId"></span></p>
                    <p><strong>Amount:</strong> <span id="refundAmount"></span></p>
                </div>
                <div class="mpesa-form-group">
                    <label for="refundReason">Reason for Refund</label>
                    <textarea id="refundReason" name="reason" rows="3" class="modal-textarea" placeholder="Enter reason..." required></textarea>
                </div>
                <div class="warning-box">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>This action cannot be undone.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeRefundModal()" class="modal-btn-cancel">Cancel</button>
                <button type="submit" class="modal-btn-refund"><i class="fas fa-undo"></i> Confirm Refund</button>
            </div>
        </form>
    </div>
</div>

<style>
.mpesa-init-form{display:flex;flex-direction:column;gap:12px;}
.form-row{display:flex;gap:16px;align-items:flex-end;flex-wrap:wrap;}
.form-group{flex:1;min-width:150px;}
.form-group label{display:block;font-size:12px;font-weight:600;color:var(--muted);margin-bottom:4px;}
.form-control{width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:var(--radius-sm);font-size:14px;transition:border-color .2s;}
.form-control:focus{outline:none;border-color:var(--blue);}
.btn-initiate{padding:10px 24px;border:none;border-radius:var(--radius-sm);background:#2563EB;color:#fff;font-weight:600;font-size:14px;cursor:pointer;transition:background .2s;display:flex;align-items:center;gap:8px;white-space:nowrap;}
.btn-initiate:hover{background:#1D4ED8;}
.btn-initiate:disabled{opacity:.6;cursor:not-allowed;}
.init-status{margin-top:12px;padding:10px 16px;border-radius:var(--radius-sm);display:none;}
.init-status.success{display:block;background:#f0fdf4;color:#16a34a;border:1px solid #86efac;}
.init-status.error{display:block;background:#fef2f2;color:#dc2626;border:1px solid #fca5a5;}
.init-status.info{display:block;background:#eff6ff;color:#2563eb;border:1px solid #93c5fd;}
.stat-icon.red{background:#FEE2E2;color:#DC2626;}
.stat-icon.purple{background:#EDE9FE;color:#7C3AED;}
.receipt-text{font-family:monospace;font-size:11px;background:#F3F4F6;padding:2px 6px;border-radius:4px;}
.merchant-id{font-family:monospace;font-size:10px;color:var(--muted);}
.btn-refund{padding:4px 10px;border:none;border-radius:var(--radius-sm);background:#FEF3C7;color:#92400E;font-size:13px;cursor:pointer;transition:.2s;}
.btn-refund:hover{background:#FDE68A;}
.payment-info-box{background:#F3F4F6;border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:16px;font-size:14px;}
.payment-info-box p{margin:4px 0;}
.warning-box{background:#FEF3C7;border:1px solid #F59E0B;border-radius:var(--radius-sm);padding:12px 16px;margin-top:16px;display:flex;align-items:center;gap:10px;font-size:13px;color:#92400E;}
.warning-box i{font-size:18px;}
.modal-btn-refund{padding:8px 24px;border:none;border-radius:var(--radius-sm);background:#F59E0B;color:#fff;font-weight:600;font-size:13px;cursor:pointer;transition:.2s;display:flex;align-items:center;gap:8px;}
.modal-btn-refund:hover{background:#D97706;}
.text-muted{color:var(--muted);}
.hidden{display:none !important;}
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.5);display:none;align-items:center;justify-content:center;z-index:1000;}
.modal-overlay.flex{display:flex;}
.modal-content{background:var(--white);border-radius:var(--radius-lg);max-width:500px;width:90%;box-shadow:0 20px 60px rgba(0,0,0,0.2);overflow:hidden;}
.modal-header{padding:20px 24px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;}
.modal-header h3{font-size:16px;font-weight:700;display:flex;align-items:center;gap:10px;}
.modal-close{background:none;border:none;font-size:20px;color:var(--muted);cursor:pointer;padding:4px;}
.modal-body{padding:24px;}
.modal-footer{padding:16px 24px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;gap:12px;}
.modal-btn-cancel{padding:8px 20px;border:1px solid var(--border);border-radius:var(--radius-sm);background:var(--white);color:var(--text);font-weight:600;font-size:13px;cursor:pointer;transition:.2s;}
.modal-btn-cancel:hover{background:#F3F4F6;}
.modal-textarea{width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:var(--radius-sm);font-size:14px;resize:vertical;transition:border-color .2s;}
.modal-textarea:focus{outline:none;border-color:var(--blue);}
@media(max-width:1200px){.stats-grid{grid-template-columns:repeat(2,1fr);}.form-row{flex-direction:column;}.form-group{min-width:100%;}}
@media(max-width:768px){.stats-grid{grid-template-columns:1fr;}}
</style>

<script>
async function initiateMpesaFromAdmin() {
    const orderId = document.getElementById('initOrderId').value;
    const phone = document.getElementById('initPhone').value;
    const statusDiv = document.getElementById('initStatus');
    const btn = document.querySelector('.btn-initiate');

    if (!orderId || !phone) {
        showInitStatus('Please fill in both Order ID and Phone Number.', 'error');
        return;
    }

    let formattedPhone = phone.replace(/^\+/, '').replace(/^0/, '');
    if (!formattedPhone.startsWith('254')) formattedPhone = '254' + formattedPhone;

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
    showInitStatus('Sending STK Push... Please wait.', 'info');

    try {
        const response = await fetch('{{ route("admin.mpesa-payments.initiate") }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({order_id: orderId, phone: formattedPhone})
        });
        const data = await response.json();

        if (data.success) {
            showInitStatus('✅ STK Push sent successfully!', 'success');
            btn.innerHTML = '<i class="fas fa-check"></i> Sent';
            setTimeout(() => location.reload(), 3000);
        } else {
            showInitStatus('❌ ' + data.message, 'error');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-paper-plane"></i> Send STK Push';
        }
    } catch (error) {
        showInitStatus('❌ Network error. Please try again.', 'error');
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-paper-plane"></i> Send STK Push';
    }
}

function showInitStatus(message, type) {
    const div = document.getElementById('initStatus');
    div.textContent = message;
    div.className = 'init-status ' + type;
    div.style.display = 'block';
}

function openRefundModal(paymentId) {
    document.getElementById('refundModal').classList.remove('hidden');
    document.getElementById('refundModal').classList.add('flex');
    document.getElementById('refundForm').action = '/admin/mpesa-payments/' + paymentId + '/refund';
    document.getElementById('refundPaymentId').textContent = '#' + paymentId;
    const row = event.target.closest('tr');
    document.getElementById('refundAmount').textContent = row.querySelector('td:nth-child(5)').textContent;
    document.getElementById('refundReason').value = '';
}

function closeRefundModal() {
    document.getElementById('refundModal').classList.add('hidden');
    document.getElementById('refundModal').classList.remove('flex');
}

document.getElementById('refundModal').addEventListener('click', function(e) {
    if (e.target === this) closeRefundModal();
});
</script>

@endsection