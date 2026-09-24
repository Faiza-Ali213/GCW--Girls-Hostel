@extends('Layout.admin')

@section('content')
<div class="staff-container">
    
    <!-- Page Header -->
    <div class="page-header-section">
        <h2><i class="bi bi-person-badge me-2" style="color: #4F46E5;"></i>Staff Management</h2>
        <p class="text-muted">Overview of hostel employees and their duties.</p>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="stat-card total-staff">
                <div class="stat-icon"><i class="bi bi-people"></i></div>
                <div class="stat-number">{{ $totalStaff ?? 0 }}</div>
                <div class="stat-label">Total Staff</div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="stat-card active-staff">
                <div class="stat-icon"><i class="bi bi-person-check"></i></div>
                <div class="stat-number">{{ $activeStaff ?? 0 }}</div>
                <div class="stat-label">Active Staff</div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="stat-card inactive-staff">
                <div class="stat-icon"><i class="bi bi-person-x"></i></div>
                <div class="stat-number">{{ $inactiveStaff ?? 0 }}</div>
                <div class="stat-label">Inactive Staff</div>
            </div>
        </div>
    </div>

    <!-- Search & Action Row -->
    <div class="action-row">
        <div class="search-container">
            <i class="bi bi-search"></i>
            <form action="{{ route('staff_records') }}" method="GET" class="search-form">
                <input type="text" name="search" class="staff-search" 
                       placeholder="Search staff by name or role..." 
                       value="{{ request('search') }}">
                <button type="submit" class="btn-search">
                    <i class="bi bi-search"></i> Search
                </button>
                @if(request('search'))
                    <a href="{{ route('staff_records') }}" class="btn-clear">
                        <i class="bi bi-x-circle"></i> Clear
                    </a>
                @endif
            </form>
        </div>
        
        <a href="{{ route('staff.create') }}" class="btn-add-staff">
            <i class="bi bi-plus-circle"></i> Add New Record
        </a>
    </div>

    <!-- Staff Table -->
    <div class="staff-table-card">
        <div class="table-responsive">
            <table class="table staff-table align-middle">
                <thead>
                    <tr>
                        <th width="60px">#</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>CNIC</th>                       {{-- ✅ CNIC column added --}}
                        <th>Duty / Shift</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff ?? [] as $member)
                    <tr>
                        <td class="text-muted fw-bold">{{ ($staff->currentPage() - 1) * $staff->perPage() + $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($member->profile_picture)
                                    <img src="{{ asset('storage/' . $member->profile_picture) }}" 
                                         alt="{{ $member->name }}" 
                                         class="rounded-circle me-2" 
                                         width="35" height="35"
                                         style="object-fit: cover;">
                                @else
                                    <div class="avatar-placeholder me-2">
                                        {{ substr($member->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="fw-bold text-dark">{{ $member->name }}</span>
                            </div>
                        </td>
                        <td><span class="role-badge">{{ $member->role }}</span></td>
                        <td>{{ $member->phone }}</td>
                        <td>{{ $member->cnic ?? 'N/A' }}</td>    {{-- ✅ CNIC value added --}}
                        <td>{{ $member->duty_shift ?? 'N/A' }}</td>
                        <td>
                            <span class="status-badge status-{{ $member->status }}">
                                {{ ucfirst($member->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="action-buttons">
                                <a href="{{ route('staff.show', $member->id) }}" class="action-btn view-btn" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('staff.edit', $member->id) }}" class="action-btn edit-btn" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('staff.destroy', $member->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete-btn" title="Delete" 
                                            onclick="return confirm('Are you sure you want to delete this staff member?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">                           {{-- ✅ 7 se 8 kiya --}}
                            <div class="empty-state">
                                <i class="bi bi-people"></i>
                                <h5>No Staff Members Found</h5>
                                <p>Start by adding your first staff record.</p>
                                <a href="{{ route('staff.create') }}" class="btn btn-primary btn-sm mt-3">
                                    <i class="bi bi-plus-circle"></i> Add First Staff
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if(isset($staff) && $staff->hasPages())
            <div class="pagination-container">
                {{ $staff->appends(request()->query())->links() }}
            </div>
        @endif
        
        <!-- Showing info -->
        @if(isset($staff) && $staff->count() > 0)
            <div class="pagination-container" style="border-top: none; padding-top: 0;">
                <small class="text-muted">
                    Showing {{ $staff->firstItem() ?? 0 }} to {{ $staff->lastItem() ?? 0 }} of {{ $staff->total() ?? 0 }} staff members
                </small>
            </div>
        @endif
    </div>
</div>

<style>
/* ============================================ */
/* STAFF MANAGEMENT - BLUE THEME */
/* ============================================ */

.staff-container {
    padding: 20px 0;
}

/* Page Header */
.page-header-section {
    margin-bottom: 25px;
}

.page-header-section h2 {
    font-weight: 700;
    color: #0b1a33;
    font-size: 1.8rem;
    margin-bottom: 5px;
}

.page-header-section h2 i {
    color: #4F46E5;
}

.page-header-section .text-muted {
    font-size: 0.95rem;
    color: #6c757d;
}

/* Statistics Cards */
.stat-card {
    background: white;
    border-radius: 16px;
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

.stat-card.total-staff { 
    border-top-color: #4F46E5; 
}
.stat-card.total-staff .stat-icon { 
    color: #4F46E5; 
}

.stat-card.active-staff { 
    border-top-color: #10B981; 
}
.stat-card.active-staff .stat-icon { 
    color: #10B981; 
}

.stat-card.inactive-staff { 
    border-top-color: #EF4444; 
}
.stat-card.inactive-staff .stat-icon { 
    color: #EF4444; 
}

/* Search & Action Row */
.action-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 25px;
}

.search-container {
    flex: 1;
    min-width: 300px;
    display: flex;
    align-items: center;
    background: white;
    border-radius: 12px;
    padding: 0 15px;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.search-container:focus-within {
    border-color: #4F46E5;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
}

.search-container i {
    color: #94a3b8;
    margin-right: 10px;
    font-size: 1.1rem;
}

.search-form {
    display: flex;
    align-items: center;
    width: 100%;
    gap: 8px;
}

.staff-search {
    border: none;
    padding: 12px 0;
    flex: 1;
    outline: none;
    background: transparent;
    font-size: 0.95rem;
    color: #0b1a33;
}

.staff-search::placeholder {
    color: #adb5bd;
}

.btn-search {
    background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
    color: white;
    border: none;
    padding: 6px 18px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-search:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    color: white;
}

.btn-clear {
    background: #f1f3f5;
    color: #6c757d;
    border: none;
    padding: 6px 14px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    text-decoration: none;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-clear:hover {
    background: #e9ecef;
    color: #495057;
}

.btn-add-staff {
    background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
    color: white;
    border: none;
    padding: 11px 28px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    text-decoration: none;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.25);
}

.btn-add-staff:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(79, 70, 229, 0.35);
    color: white;
}

/* Staff Table */
.staff-table-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    overflow: hidden;
    border: 1px solid #f0f2f5;
}

.staff-table {
    margin-bottom: 0;
}

.staff-table thead {
    background: #f8fafc;
}

.staff-table thead th {
    border: none;
    padding: 14px 20px;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 0.5px;
    color: #64748b;
    border-bottom: 2px solid #eef2f6;
}

.staff-table tbody td {
    padding: 14px 20px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f3f5;
}

.staff-table tbody tr:last-child td {
    border-bottom: none;
}

.staff-table tbody tr:hover {
    background: #f8faff;
}

/* Avatar Placeholder */
.avatar-placeholder {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
    flex-shrink: 0;
    text-transform: uppercase;
}

/* Role Badge */
.role-badge {
    background: #EEF2FF;
    color: #4F46E5;
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
}

/* Status Badges */
.status-badge {
    padding: 5px 14px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
}

.status-active {
    background: #ECFDF5;
    color: #10B981;
}

.status-inactive {
    background: #FEF2F2;
    color: #EF4444;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.action-btn {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    text-decoration: none;
    cursor: pointer;
    font-size: 0.95rem;
    background: transparent;
    color: inherit;
}

.action-btn i {
    font-size: 1rem;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.view-btn {
    background: #EEF2FF;
    color: #4F46E5;
}

.view-btn:hover {
    background: #4F46E5;
    color: white;
}

.edit-btn {
    background: #FFFBEB;
    color: #F59E0B;
}

.edit-btn:hover {
    background: #F59E0B;
    color: white;
}

.delete-btn {
    background: #FEF2F2;
    color: #EF4444;
}

.delete-btn:hover {
    background: #EF4444;
    color: white;
}

/* Pagination */
.pagination-container {
    padding: 15px 20px;
    border-top: 1px solid #f1f3f5;
}

.pagination-container .pagination {
    margin: 0;
    justify-content: flex-end;
}

.pagination-container .page-item.active .page-link {
    background: #4F46E5;
    border-color: #4F46E5;
    color: white;
    border-radius: 8px;
}

.pagination-container .page-link {
    color: #4F46E5;
    border-radius: 8px;
    margin: 0 3px;
    border: none;
    padding: 6px 14px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.pagination-container .page-link:hover {
    background: #EEF2FF;
    color: #4F46E5;
    border-radius: 8px;
}

/* Empty State */
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

.empty-state .btn-primary {
    background: linear-gradient(135deg, #4F46E5, #4338CA);
    border: none;
    padding: 10px 25px;
    border-radius: 10px;
    font-weight: 600;
}

.empty-state .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .action-row {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-container {
        min-width: auto;
    }
    
    .search-form {
        flex-wrap: wrap;
    }
    
    .btn-search, .btn-clear {
        flex: 1;
        justify-content: center;
    }
    
    .btn-add-staff {
        justify-content: center;
    }
    
    .action-buttons {
        flex-wrap: wrap;
    }
    
    .staff-table thead th,
    .staff-table tbody td {
        padding: 10px 12px;
        font-size: 0.85rem;
    }
}

@media (max-width: 576px) {
    .staff-container {
        padding: 10px 0;
    }
    
    .page-header-section h2 {
        font-size: 1.4rem;
    }
    
    .stat-card .stat-number {
        font-size: 1.5rem;
    }
    
    .stat-card .stat-icon {
        font-size: 2rem;
    }
    
    .btn-add-staff {
        font-size: 0.85rem;
        padding: 9px 18px;
    }
}
</style>

@endsection