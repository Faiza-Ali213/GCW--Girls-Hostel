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

<!-- ✅ Search and Filter - NOW WITH FORM -->
<form action="{{ route('fee_record') }}" method="GET" id="feeSearchForm">
    <div class="filter-section">
        
        <!-- Search Input -->
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" 
                   name="search"
                   id="searchInput" 
                   placeholder="Search by student name, room or phone..." 
                   value="{{ request('search') }}"
                   onkeypress="if(event.key === 'Enter'){ this.form.submit(); }">
        </div>

        <!-- Status Filter -->
        <select name="status" id="statusFilter" class="filter-select" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option>
        </select>

        <!-- Search Button -->
        <button type="submit" class="btn-search-fee">
            <i class="fas fa-search"></i> Search
        </button>

        <!-- Clear Button -->
        @if(request('search') || request('status'))
            <a href="{{ route('fee_record') }}" class="btn-clear-fee">
                <i class="fas fa-times"></i> Clear
            </a>
        @endif

    </div>
</form>

<!-- Fee Records Table -->
<div class="modern-table">
    <table class="table table-hover" id="feeTable">
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
                        <!-- View Button - Always Visible -->
                        <a href="{{ route('fee-record.show', $record->id) }}" class="action-btn view" title="View Details">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <!-- Edit Button - Always Visible -->
                        <a href="{{ route('fee-record.edit', $record->id) }}" class="action-btn edit" title="Edit Record">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        @if($record->fee_status == 'paid')
                            <!-- When PAID: Show Receipt Button (No Pay) -->
                            <a href="{{ route('fee-record.receipt', $record->id) }}" class="action-btn view" title="View Receipt" style="background: #ECFDF5; border-color: #10B981;">
                                <i class="fas fa-receipt" style="color: #10B981 !important;"></i>
                            </a>
                        @elseif($record->fee_status == 'partial')
                            <!-- When PARTIAL: Show Pay and Receipt -->
                            <a href="{{ route('fee-record.pay', $record->id) }}" class="action-btn pay" title="Pay Fee">
                                <i class="fas fa-hand-holding-usd"></i>
                            </a>
                            <a href="{{ route('fee-record.receipt', $record->id) }}" class="action-btn view" title="View Receipt">
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
    {{ $feeRecords->appends(request()->query())->links() }}
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

{{-- ✅ Search Button CSS --}}
<style>
    .btn-search-fee {
        background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }
    .btn-search-fee:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
        color: white;
    }

    .btn-clear-fee {
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
    .btn-clear-fee:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }
</style>

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