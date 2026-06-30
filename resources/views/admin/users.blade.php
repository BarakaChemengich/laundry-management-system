@extends('layouts.app')

@section('content')
<div class="dashboard-content">

    <div class="greeting-section">
        <h1>User Management 👥</h1>
        <p>Manage all users, approve vendors and riders, and monitor user activity.</p>
    </div>

    <!-- Filters -->
    <div class="filter-bar">
        <form method="GET" action="{{ route('admin.users.index') }}" class="filter-form">
            <div class="filter-group">
                <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}" class="filter-input">
            </div>
            <div class="filter-group">
                <select name="role" class="filter-select">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                            {{ $role->display_name ?? $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <select name="status" class="filter-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Filter</button>
            <a href="{{ route('admin.users.index') }}" class="btn-reset">Reset</a>
        </form>
    </div>

    <!-- Users Table -->
    <div class="section-card">
        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th><th>Name</th><th>Email</th><th>Phone</th>
                        <th>Role</th><th>Status</th><th>Joined</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>#{{ $user->id }}</td>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number ?? 'N/A' }}</td>
                        <td><span class="role-badge">{{ $user->role->display_name ?? $user->role->name ?? 'N/A' }}</span></td>
                        <td><span class="status-badge {{ $user->status }}">{{ ucfirst($user->status) }}</span></td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($user->status === 'pending' && in_array($user->role_id, [3, 4]))
                                <form action="{{ route('admin.users.approve', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-approve"><i class="fas fa-check"></i></button>
                                </form>
                                <form action="{{ route('admin.users.reject', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-reject"><i class="fas fa-times"></i></button>
                                </form>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="empty-row">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="table-footer">{{ $users->links() }}</div>
    </div>

</div>

<style>
.filter-bar{background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);padding:16px 20px;margin-bottom:24px;box-shadow:var(--shadow);}
.filter-form{display:flex;flex-wrap:wrap;gap:12px;align-items:center;}
.filter-group{flex:1;min-width:150px;}
.filter-input,.filter-select{width:100%;padding:8px 14px;border:1px solid var(--border);border-radius:var(--radius-sm);font-size:13px;background:var(--white);transition:border-color .2s;}
.filter-input:focus,.filter-select:focus{outline:none;border-color:var(--blue);}
.btn-filter{padding:8px 20px;border:none;border-radius:var(--radius-sm);background:var(--blue);color:#fff;font-weight:600;font-size:13px;cursor:pointer;transition:background .2s;display:flex;align-items:center;gap:6px;}
.btn-filter:hover{background:var(--blue-dark);}
.btn-reset{padding:8px 16px;border:1px solid var(--border);border-radius:var(--radius-sm);background:var(--white);color:var(--text);font-weight:600;font-size:13px;cursor:pointer;transition:.2s;text-decoration:none;}
.btn-reset:hover{background:#F3F4F6;}
.text-muted{color:var(--muted);}
.table-footer{padding:12px 20px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;}
@media(max-width:768px){.filter-form{flex-direction:column;}.filter-group{min-width:100%;}}
</style>

@endsection