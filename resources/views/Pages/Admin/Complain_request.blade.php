@extends('Layout.admin')

@section('content')
<style>
    .stat-card {
        background: white;
        border-radius: 14px;
        padding: 22px 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border-top: 4px solid;
        position: relative;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    }
    .stat-card .stat-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 2.8rem;
        opacity: 0.06;
    }
    .stat-card .stat-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 4px;
        letter-spacing: -0.3px;
        color: #0b1a33;
    }
    .stat-card .stat-label {
        color: #94a3b8;
        font-size: 0.82rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-card.pending { border-top-color: #F59E0B; }
    .stat-card.pending .stat-icon { color: #F59E0B; }
    .stat-card.in-progress { border-top-color: #0EA5E9; }
    .stat-card.in-progress .stat-icon { color: #0EA5E9; }
    .stat-card.resolved { border-top-color: #10B981; }
    .stat-card.resolved .stat-icon { color: #10B981; }
    .stat-card.total { border-top-color: #4F46E5; }
    .stat-card.total .stat-icon { color: #4F46E5; }

    .modern-table {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        background: white;
        border: 1px solid #f0f2f5;
    }
    .modern-table thead {
        background: #f8fafc;
        border-bottom: 2px solid #eef2f6;
    }
    .modern-table thead th {
        border: none;
        padding: 14px 20px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        color: #64748b;
    }
    .modern-table tbody tr {
        transition: all 0.15s ease;
        border-left: 3px solid transparent;
    }
    .modern-table tbody tr:hover {
        background: #f8faff;
        border-left-color: #4F46E5;
    }
    .modern-table tbody td {
        padding: 12px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f5;
        color: #0b1a33;
    }
    .modern-table tbody tr:last-child td {
        border-bottom: none;
    }

    .priority-badge {
        padding: 4px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .priority-high { background: #FEF2F2; color: #EF4444; }
    .priority-medium { background: #FFFBEB; color: #F59E0B; }
    .priority-low { background: #ECFDF5; color: #10B981; }

    .status-badge {
        padding: 4px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .status-pending { background: #FFFBEB; color: #F59E0B; }
    .status-in_progress { background: #E0F2FE; color: #0EA5E9; }
    .status-resolved { background: #ECFDF5; color: #10B981; }
    .status-rejected { background: #FEF2F2; color: #EF4444; }

    .complaint-by-badge {
        padding: 4px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .complaint-by-student { background: #ECFDF5; color: #10B981; }
    .complaint-by-user { background: #E0F2FE; color: #0EA5E9; }

    .status-selector {
        padding: 4px 8px;
        border-radius: 6px;
        border: 2px solid #e2e8f0;
        font-weight: 600;
        font-size: 0.75rem;
        background: #ffffff;
        color: #0f172a;
        cursor: pointer;
        transition: all 0.2s ease;
        min-width: 120px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .status-selector:focus {
        border-color: #1a2a4a;
        outline: none;
        box-shadow: 0 0 0 3px rgba(26, 42, 74, 0.1);
    }
    .status-selector option.pending { color: #F59E0B; }
    .status-selector option.in_progress { color: #0EA5E9; }
    .status-selector option.resolved { color: #10B981; }
    .status-selector option.rejected { color: #EF4444; }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.2s ease;
        margin: 0 2px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        gap: 4px;
    }
    .action-btn.view { background: #EEF2FF; color: #4F46E5; }
    .action-btn.view:hover { background: #4F46E5; color: white; }

    .page-header {
        background: white;
        border-radius: 16px;
        padding: 22px 28px;
        margin-bottom: 28px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        border: 1px solid #f0f2f5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    .page-header h4 {
        margin: 0;
        font-weight: 700;
        color: #0b1a33;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.3rem;
    }
    .page-header h4 i { color: #4F46E5; }

    .page-header .header-actions {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-save-status {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        color: #ffffff !important;
        border: none;
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
        text-decoration: none;
    }
    .btn-save-status:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.35);
        color: #ffffff !important;
    }

    .btn-search-complaint {
        background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
        color: #ffffff !important;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.25);
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-search-complaint:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.35);
        color: #ffffff !important;
    }

    .btn-clear-complaint {
        background: #f1f5f9;
        color: #64748b;
        border: none;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }
    .btn-clear-complaint:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }

    .search-input-complaint {
        width: 100%;
        padding: 12px 16px 12px 42px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9rem;
        outline: none;
        transition: all 0.3s ease;
    }
    .search-input-complaint:focus {
        border-color: #4F46E5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
    }

    .filter-select-complaint {
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9rem;
        min-width: 150px;
        cursor: pointer;
        background: white;
        outline: none;
    }
    .filter-select-complaint:focus {
        border-color: #4F46E5;
    }

    .avatar-circle {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #EEF2FF 0%, #E0E7FF 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4F46E5;
        font-weight: 700;
        font-size: 13px;
        flex-shrink: 0;
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
    }
    .empty-state i {
        font-size: 3.5rem;
        color: #d1d5db;
        display: block;
        margin-bottom: 15px;
    }
    .empty-state h5 {
        color: #0b1a33;
        font-weight: 600;
        margin-bottom: 5px;
    }
    .empty-state p {
        color: #94a3b8;
        margin-bottom: 15px;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        border: none;
    }
    .alert-success { background: #ECFDF5; color: #065F46; border-left: 4px solid #10B981; }
    .alert-danger { background: #FEF2F2; color: #991B1B; border-left: 4px solid #EF4444; }
    .alert-warning { background: #FFFBEB; color: #92400E; border-left: 4px solid #F59E0B; }
    .alert i { font-size: 1.2rem; }
    .alert .close { margin-left: auto; color: inherit; opacity: 0.5; }
    .alert .close:hover { opacity: 1; }

    .footer-info {
        text-align: center;
        color: #94a3b8;
        font-size: 0.8rem;
        margin-top: 15px;
    }

    .status-selector-wrapper {
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }
    .status-selector-wrapper select {
        width: 100%;
        max-width: 140px;
    }

    .top-action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
        background: white;
        padding: 15px 20px;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        border: 1px solid #f0f2f5;
    }

    @media (max-width: 768px) {
        .stat-card .stat-number { font-size: 1.5rem; }
        .page-header { flex-direction: column; align-items: flex-start; gap: 15px; }
        .page-header .header-actions { width: 100%; }
        .btn-save-status { width: 100%; justify-content: center; }
        .modern-table { overflow-x: auto; }
        .modern-table table { min-width: 900px; }
        .action-btn { padding: 4px 10px; font-size: 0.7rem; }
        .status-selector { min-width: 100px; font-size: 0.65rem; }
        .top-action-bar { flex-direction: column; align-items: stretch; }
        .top-action-bar .btn-save-status { width: 100%; justify-content: center; }
        .search-form-complaint { flex-direction: column; align-items: stretch; }
        .btn-search-complaint, .btn-clear-complaint { width: 100%; justify-content: center; }
        .filter-select-complaint { width: 100%; }
    }

    @media (max-width: 576px) {
        .stat-card { padding: 16px 18px; }
        .stat-card .stat-number { font-size: 1.3rem; }
        .stat-card .stat-icon { font-size: 2rem; }
    }
</style>

<!-- Display Flash Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Page Header -->
<div class="page-header">
    <h4>
        <i class="fas fa-clipboard-list"></i>
        Complaint Management
    </h4>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card pending">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-number">{{ $pendingCount ?? 0 }}</div>
            <div class="stat-label">Pending Complaints</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card in-progress">
            <div class="stat-icon"><i class="fas fa-spinner"></i></div>
            <div class="stat-number">{{ $inProgressCount ?? 0 }}</div>
            <div class="stat-label">In Progress</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card resolved">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-number">{{ $resolvedCount ?? 0 }}</div>
            <div class="stat-label">Resolved</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card total">
            <div class="stat-icon"><i class="fas fa-clipboard"></i></div>
            <div class="stat-number">{{ isset($complaints) ? $complaints->count() : 0 }}</div>
            <div class="stat-label">Total Complaints</div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- ✅ SEARCH & FILTER BAR (NEW) -->
<!-- ============================================ -->
<div class="top-action-bar" style="margin-bottom: 15px;">
    <form action="{{ route('complaint_management') }}" method="GET" 
          class="search-form-complaint"
          style="display: flex; gap: 10px; width: 100%; flex-wrap: wrap; align-items: center;">
        
        <!-- Search Input -->
        <div style="flex: 1; min-width: 250px; position: relative;">
            <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
            <input type="text" 
                   name="search" 
                   class="search-input-complaint"
                   placeholder="Search by title, student name or room..." 
                   value="{{ request('search') }}"
                   onkeypress="if(event.key === 'Enter'){ this.form.submit(); }">
        </div>

        <!-- Status Filter -->
        <select name="status" class="filter-select-complaint" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>

        <!-- Priority Filter -->
        <select name="priority" class="filter-select-complaint" onchange="this.form.submit()">
            <option value="">All Priority</option>
            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
        </select>

        <!-- Search Button -->
        <button type="submit" class="btn-search-complaint">
            <i class="fas fa-search"></i> Search
        </button>

        <!-- Clear Button -->
        @if(request('search') || request('status') || request('priority'))
            <a href="{{ route('complaint_management') }}" class="btn-clear-complaint">
                <i class="fas fa-times"></i> Clear
            </a>
        @endif
    </form>
</div>

<!-- Top Action Bar with Save Button (Existing) -->
<div class="top-action-bar">
    <div>
        <span style="font-weight: 600; color: #0b1a33;">
            <i class="fas fa-edit"></i> Update Complaint Statuses
        </span>
        <small class="text-muted d-block" style="font-size: 0.8rem;">Change statuses below and click save to update all at once</small>
    </div>
    <button type="submit" form="statusUpdateForm" class="btn-save-status">
        <i class="fas fa-save"></i> Save All Status Changes
    </button>
</div>

<!-- Complaints Table -->
<div class="modern-table">
    <form id="statusUpdateForm" action="{{ route('complaints.update') }}" method="POST">
        @csrf
        @method('PUT')
        <table class="table table-hover" id="complaintsTable">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Title</th>
                    <th>Student</th>
                    <th>Complaint By</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($complaints ?? [] as $complaint)
                <tr id="complaint-row-{{ $complaint->id }}">
                    <td>
                        <span class="font-weight-bold" style="color: #4F46E5;">#{{ $complaint->id }}</span>
                    </td>
                    <td>
                        <strong style="color: #0b1a33;">{{ $complaint->title }}</strong>
                        <div class="text-muted small" style="color: #94a3b8 !important;">{{ Str::limit($complaint->description, 50) }}</div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center" style="gap: 8px;">
                            <div class="avatar-circle">
                                {{ substr($complaint->student_name, 0, 2) }}
                            </div>
                            <div>
                                <div style="font-weight: 500; color: #0b1a33;">{{ $complaint->student_name }}</div>
                                @if($complaint->room_number)
                                    <small style="color: #94a3b8;"><i class="fas fa-door-open"></i> Room {{ $complaint->room_number }}</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="complaint-by-badge complaint-by-{{ strtolower($complaint->complaint_by ?? 'user') }}">
                            <i class="fas fa-user-{{ strtolower($complaint->complaint_by ?? 'user') == 'student' ? 'graduate' : 'circle' }}"></i>
                            {{ ucfirst($complaint->complaint_by ?? 'User') }}
                        </span>
                    </td>
                    <td>
                        <span class="priority-badge priority-{{ $complaint->priority }}">
                            <i class="fas fa-flag"></i> {{ ucfirst($complaint->priority) }}
                        </span>
                    </td>
                    <td>
                        <div class="status-selector-wrapper">
                            <select name="statuses[{{ $complaint->id }}]" class="status-selector" id="status-select-{{ $complaint->id }}">
                                <option value="pending" class="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="in_progress" class="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>🔄 In Progress</option>
                                <option value="resolved" class="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>✅ Resolved</option>
                                <option value="rejected" class="rejected" {{ $complaint->status == 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div style="color: #0b1a33;">{{ $complaint->created_at->format('d-m-Y') }}</div>
                        <small style="color: #94a3b8;">{{ $complaint->created_at->diffForHumans() }}</small>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('complaints.show', $complaint->id) }}" class="action-btn view" data-toggle="tooltip" title="View Details">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h5>No Complaints Found</h5>
                            <p>No complaints have been submitted yet.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </form>
</div>

<!-- Footer Info -->
<div class="footer-info">
    <i class="fas fa-info-circle"></i> 
    Showing {{ isset($complaints) ? $complaints->count() : 0 }} complaint(s) 
    | Last updated: {{ now()->format('d-m-Y H:i:s') }}
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    console.log('✅ Complaint page loaded successfully');
});
</script>
@endpush