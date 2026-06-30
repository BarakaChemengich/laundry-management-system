@extends('layouts.app')

@section('content')
<div class="dashboard-content">

    <div class="greeting-section">
        <h1>Audit Logs 📋</h1>
        <p>Monitor all system activities and user actions.</p>
    </div>

    <!-- Filters -->
    <div class="filter-bar">
        <form method="GET" action="{{ route('admin.audit-logs.index') }}" class="filter-form">
            <div class="filter-group">
                <select name="user_id" class="filter-select">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <select name="action" class="filter-select">
                    <option value="">All Actions</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                            {{ str_replace('_', ' ', $action) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <select name="table" class="filter-select">
                    <option value="">All Tables</option>
                    @foreach($tables as $table)
                        <option value="{{ $table }}" {{ request('table') == $table ? 'selected' : '' }}>
                            {{ $table }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="filter-input">
            </div>
            <div class="filter-group">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="filter-input">
            </div>
            <button type="submit" class="btn-filter">
                <i class="fas fa-search"></i> Filter
            </button>
            <a href="{{ route('admin.audit-logs.index') }}" class="btn-reset">Reset</a>
        </form>
    </div>

    <!-- Audit Logs Table -->
    <div class="section-card">
        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Table</th>
                        <th>Record ID</th>
                        <th>IP Address</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($auditLogs as $log)
                        <tr>
                            <td>#{{ $log->id }}</td>
                            <td>{{ $log->user->name ?? 'System' }}</td>
                            <td>
                                <span class="action-badge">
                                    {{ str_replace('_', ' ', $log->action) }}
                                </span>
                            </td>
                            <td>{{ $log->table_name }}</td>
                            <td>{{ $log->record_id ?? 'N/A' }}</td>
                            <td>{{ $log->ip_address ?? 'N/A' }}</td>
                            <td>{{ $log->created_at->format('M d, H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-row">No audit logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="table-footer">
            {{ $auditLogs->links() }}
        </div>
    </div>

</div>

<style>
.action-badge {
    padding: 2px 10px;
    border-radius: var(--radius-full);
    font-size: 11px;
    font-weight: 500;
    background: #F3F4F6;
    color: #4B5563;
}
</style>

@endsection