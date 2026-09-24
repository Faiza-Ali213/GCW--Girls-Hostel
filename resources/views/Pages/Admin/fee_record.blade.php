@extends('Layout.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/fee-record.css') }}">

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h4>
            <i class="fas fa-money-bill-wave"></i>
            Fee Records
        </h4>
        <div class="sub-title">Manage student fee payments and track pending balances</div>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <a href="{{ route('fee_record.sync') }}" class="btn-sync" onclick="return confirm('Sync all students from Student Records?');">
            <i class="fas fa-sync"></i> Sync Students
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card total">
            <div class="stat-icon"><i class="fas fa-receipt"></i></div>
            <div class="stat-number">{{ $totalRecords ?? 0 }}</div>
            <div class="stat-label">Total Records</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card paid">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-number">{{ $totalPaid ?? 0 }}</div>
            <div class="stat-label">Paid</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card pending">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-number">{{ $totalUnpaid ?? 0 }}</div>
            <div class="stat-label">Pending</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card partial">
            <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
            <div class="stat-number">{{ $totalPartial ?? 0 }}</div>
            <div class="stat-label">Partial</div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="filter-section">
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Search by student name, room or phone..." value="{{ request('search') }}">
    </div>
    <select id="statusFilter" class="filter-select">
        <option value="">All Status</option>
        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option>
    </select>
</div>

<!-- Fee Records Table - ✅ UPDATED FOR SCROLLING -->
<div class="modern-table" style="overflow-x: auto; width: 100%;">
    <table class="table table-hover" id="feeTable" style="min-width: 1100px;">
        <thead>
            <tr>
                <th style="width:50px;">Sr.No</th>
                <th>Student Name</th>
                <th style="width:80px;">Room</th>
                <th>Phone</th>
                <th style="width:100px;">Fee</th>
                <th style="width:100px;">Paid</th>
                <th style="width:100px;">Pending</th>
                <th style="width:100px;">Status</th>
                <th style="width:200px;" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($feeRecords ?? [] as $index => $record)
            <tr id="record-{{ $record->id }}" data-id="{{ $record->id }}">
                <td>
                    <span class="font-weight-bold" style="color: #4F46E5;">{{ $feeRecords->firstItem() + $index }}</span>
                </td>
                <td>
                    <div class="student-info">
                        <div class="student-avatar">
                            {{ substr($record->student_name, 0, 2) }}
                        </div>
                        <div>
                            <div class="student-name">{{ $record->student_name }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="room-badge">{{ $record->room_no ?? 'N/A' }}</span>
                </td>
                <td>{{ $record->phone_number }}</td>
                <td class="amount-fee">PKR {{ number_format($record->fee_amount, 2) }}</td>
                <td class="amount-paid">PKR {{ number_format($record->paid_amount, 2) }}</td>
                <td class="amount-pending">PKR {{ number_format($record->pending_amount, 2) }}</td>
                <td>
                    <span class="status-badge status-{{ $record->fee_status }}">
                        @if($record->fee_status == 'paid')
                            <i class="fas fa-check-circle"></i>
                        @elseif($record->fee_status == 'pending')
                            <i class="fas fa-clock"></i>
                        @else
                            <i class="fas fa-hourglass-half"></i>
                        @endif
                        {{ ucfirst($record->fee_status) }}
                    </span>
                </td>
                <td class="text-center">
                    <div class="action-group">
                        <!-- View Button -->
                        <a href="{{ route('fee-record.show', $record->id) }}" class="action-btn view" title="View Details">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <!-- Edit Button -->
                        <a href="{{ route('fee-record.edit', $record->id) }}" class="action-btn edit" title="Edit Record">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        @if($record->fee_status == 'paid')
                            <!-- When PAID: Show Receipt Button -->
                            <a href="{{ route('fee-record.receipt', $record->id) }}" class="action-btn receipt" title="View Receipt">
                                <i class="fas fa-receipt"></i>
                            </a>
                        @elseif($record->fee_status == 'partial')
                            <!-- When PARTIAL: Show Pay and Receipt -->
                            <a href="{{ route('fee-record.pay', $record->id) }}" class="action-btn pay" title="Pay Fee">
                                <i class="fas fa-hand-holding-usd"></i>
                            </a>
                            <a href="{{ route('fee-record.receipt', $record->id) }}" class="action-btn receipt" title="View Receipt">
                                <i class="fas fa-receipt"></i>
                            </a>
                        @else
                            <!-- When PENDING: Show Pay Only -->
                            <a href="{{ route('fee-record.pay', $record->id) }}" class="action-btn pay" title="Pay Fee">
                                <i class="fas fa-hand-holding-usd"></i>
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9">
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h5>No Fee Records Found</h5>
                        <p>Click "Sync Students" to import all students from Student Records.</p>
                        <a href="{{ route('fee_record.sync') }}" class="btn-sync" style="display:inline-flex;margin-top:15px;">
                            <i class="fas fa-sync"></i> Sync Now
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if(isset($feeRecords) && $feeRecords->count() > 0)
<div class="pagination-wrapper">
    {{ $feeRecords->links() }}
</div>
@endif

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Footer Info -->
<div class="mt-3 text-muted text-center">
    <small>
        <i class="fas fa-info-circle"></i> 
        Showing {{ isset($feeRecords) ? $feeRecords->count() : 0 }} record(s) 
        | Last updated: {{ now()->format('d-m-Y H:i:s') }}
    </small>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/fee-record.js') }}"></script>
<script>
$(document).ready(function() {
    // Pass route to JS
    window.feeRecordRoute = '{{ route("fee_record") }}';
});
</script>
@endpush