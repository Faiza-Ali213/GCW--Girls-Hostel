@extends('Layout.app')

@section('title', 'My Complaints')

@section('content')
<div class="container py-5">
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold" style="color: #4A3228;">
                <i class="bi bi-clipboard-check me-2" style="color: #8B6B4A;"></i>
                My Complaints
            </h2>
            <p class="text-muted mb-0">Track the live status of your complaints</p>
        </div>
        <a href="{{ route('complaint.registration') }}" class="btn btn-primary" 
           style="background: linear-gradient(135deg, #8B6B4A, #A8825A); border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; color: white;">
            <i class="bi bi-plus-circle me-2"></i> New Complaint
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <div class="stat-card">
                <div class="stat-number" style="color: #4F46E5;">{{ $totalComplaints ?? 0 }}</div>
                <div class="stat-label">Total</div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="stat-card">
                <div class="stat-number" style="color: #F59E0B;">{{ $pendingCount ?? 0 }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="stat-card">
                <div class="stat-number" style="color: #0EA5E9;">{{ $inProgressCount ?? 0 }}</div>
                <div class="stat-label">In Progress</div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="stat-card">
                <div class="stat-number" style="color: #10B981;">{{ $resolvedCount ?? 0 }}</div>
                <div class="stat-label">Resolved</div>
            </div>
        </div>
    </div>

    <!-- Complaints List -->
    <div class="complaints-wrapper">
        @forelse($complaints as $complaint)
            <div class="complaint-card">
                
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                    <div>
                        <h5 class="mb-1" style="color: #4A3228; font-weight: 700;">
                            {{ $complaint->title }}
                        </h5>
                        <small class="text-muted">
                            <i class="bi bi-hash"></i> Complaint #{{ $complaint->id }}
                            <span class="mx-2">•</span>
                            <i class="bi bi-calendar"></i> 
                            {{ $complaint->created_at->format('d M Y, h:i A') }}
                        </small>
                    </div>
                    
                    <!-- Status Badge -->
                    <div>
                        @if($complaint->status == 'pending')
                            <span class="status-badge pending">
                                <i class="bi bi-clock-history"></i> Pending
                            </span>
                        @elseif($complaint->status == 'in_progress')
                            <span class="status-badge in-progress">
                                <i class="bi bi-arrow-repeat"></i> In Progress
                            </span>
                        @elseif($complaint->status == 'resolved')
                            <span class="status-badge resolved">
                                <i class="bi bi-check-circle"></i> Resolved
                            </span>
                        @else
                            <span class="status-badge rejected">
                                <i class="bi bi-x-circle"></i> Rejected
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Human Readable Status Message -->
                <div class="status-message mb-3">
                    @if($complaint->status == 'pending')
                        <div class="alert-status pending">
                            <i class="bi bi-info-circle-fill"></i>
                            <div>
                                <strong>Pending Review:</strong> Your complaint has been submitted successfully. Our team will review it shortly.
                            </div>
                        </div>
                    @elseif($complaint->status == 'in_progress')
                        <div class="alert-status in-progress">
                            <i class="bi bi-arrow-repeat"></i>
                            <div>
                                <strong>In Progress:</strong> Good news! Our team is actively working on your complaint. We'll update you soon.
                            </div>
                        </div>
                    @elseif($complaint->status == 'resolved')
                        <div class="alert-status resolved">
                            <i class="bi bi-check-circle-fill"></i>
                            <div>
                                <strong>Resolved:</strong> Your complaint has been successfully resolved. Thank you for your patience!
                            </div>
                        </div>
                    @else
                        <div class="alert-status rejected">
                            <i class="bi bi-x-circle-fill"></i>
                            <div>
                                <strong>Rejected:</strong> Unfortunately, your complaint could not be processed. Please contact the office for more details.
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="complaint-description">
                    {{ $complaint->description }}
                </div>

                <!-- Priority -->
                @if($complaint->priority)
                    <div class="mt-3">
                        <span class="priority-badge priority-{{ $complaint->priority }}">
                            <i class="bi bi-flag"></i> {{ ucfirst($complaint->priority) }} Priority
                        </span>
                    </div>
                @endif

                <!-- Admin Response -->
                @if(isset($complaint->admin_response) && $complaint->admin_response)
                    <div class="admin-response mt-3">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-chat-left-text-fill" style="color: #4F46E5; font-size: 1.3rem;"></i>
                            <div>
                                <strong style="color: #4F46E5;">Response from Admin:</strong>
                                <p class="mb-0 mt-1">{{ $complaint->admin_response }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Progress Timeline -->
                <div class="timeline mt-4">
                    <div class="timeline-item active">
                        <div class="timeline-dot active"></div>
                        <div>
                            <strong>Submitted</strong>
                            <div class="text-muted small">{{ $complaint->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    
                    <div class="timeline-connector {{ $complaint->status != 'pending' ? 'active' : '' }}"></div>
                    
                    <div class="timeline-item {{ $complaint->status != 'pending' ? 'active' : '' }}">
                        <div class="timeline-dot {{ $complaint->status != 'pending' ? 'active' : '' }}"></div>
                        <div>
                            <strong>Under Review</strong>
                            <div class="text-muted small">
                                @if($complaint->status != 'pending')
                                    Team is reviewing
                                @else
                                    Waiting
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-connector {{ $complaint->status == 'resolved' ? 'active' : '' }}"></div>
                    
                    <div class="timeline-item {{ $complaint->status == 'resolved' ? 'active' : '' }}">
                        <div class="timeline-dot {{ $complaint->status == 'resolved' ? 'active resolved' : '' }}"></div>
                        <div>
                            <strong>Resolved</strong>
                            <div class="text-muted small">
                                @if($complaint->status == 'resolved')
                                    {{ $complaint->updated_at->diffForHumans() }}
                                @else
                                    Pending
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h5>No Complaints Yet</h5>
                <p>You haven't submitted any complaints yet.</p>
                <a href="{{ route('complaint.registration') }}" class="btn-new-complaint">
                    <i class="bi bi-plus-circle me-2"></i> Submit Your First Complaint
                </a>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($complaints->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $complaints->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        border: 1px solid #f0f2f5;
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    }
    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 4px;
    }
    .stat-label {
        font-size: 0.8rem;
        color: #64748B;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .complaints-wrapper {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .complaint-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        border: 1px solid #f0f2f5;
        transition: all 0.3s ease;
        border-left: 5px solid #8B6B4A;
    }
    .complaint-card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }

    .status-badge {
        padding: 6px 16px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .status-badge.pending { background: #FFFBEB; color: #F59E0B; }
    .status-badge.in-progress { background: #E0F2FE; color: #0EA5E9; }
    .status-badge.resolved { background: #ECFDF5; color: #10B981; }
    .status-badge.rejected { background: #FEF2F2; color: #EF4444; }

    .alert-status {
        padding: 14px 18px;
        border-radius: 12px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 0.92rem;
        line-height: 1.5;
    }
    .alert-status.pending {
        background: #FFFBEB;
        color: #92400E;
        border-left: 4px solid #F59E0B;
    }
    .alert-status.in-progress {
        background: #E0F2FE;
        color: #075985;
        border-left: 4px solid #0EA5E9;
    }
    .alert-status.resolved {
        background: #ECFDF5;
        color: #065F46;
        border-left: 4px solid #10B981;
    }
    .alert-status.rejected {
        background: #FEF2F2;
        color: #991B1B;
        border-left: 4px solid #EF4444;
    }
    .alert-status i { font-size: 1.3rem; flex-shrink: 0; margin-top: 2px; }

    .complaint-description {
        color: #475569;
        line-height: 1.7;
        padding: 14px 16px;
        background: #FAFBFC;
        border-radius: 10px;
        border-left: 3px solid #E2E8F0;
    }

    .priority-badge {
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }
    .priority-high { background: #FEF2F2; color: #EF4444; }
    .priority-medium { background: #FFFBEB; color: #F59E0B; }
    .priority-low { background: #ECFDF5; color: #10B981; }

    .admin-response {
        padding: 16px;
        background: #EEF2FF;
        border-radius: 12px;
        border-left: 4px solid #4F46E5;
    }

    .timeline {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 18px;
        background: #FAFBFC;
        border-radius: 12px;
        flex-wrap: wrap;
    }
    .timeline-item {
        display: flex;
        align-items: center;
        gap: 10px;
        opacity: 0.4;
        flex: 1;
        min-width: 130px;
    }
    .timeline-item.active { opacity: 1; }
    
    .timeline-dot {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #CBD5E1;
        flex-shrink: 0;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #CBD5E1;
    }
    .timeline-dot.active {
        background: #F59E0B;
        box-shadow: 0 0 0 2px #F59E0B;
    }
    .timeline-dot.active.resolved {
        background: #10B981;
        box-shadow: 0 0 0 2px #10B981;
    }
    
    .timeline-connector {
        flex: 0 0 30px;
        height: 3px;
        background: #E2E8F0;
        border-radius: 2px;
    }
    .timeline-connector.active { background: #F59E0B; }
    
    .timeline-item strong {
        font-size: 0.85rem;
        color: #4A3228;
        display: block;
    }
    .timeline-item .text-muted { font-size: 0.75rem; }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    }
    .empty-state i {
        font-size: 4rem;
        color: #CBD5E1;
        display: block;
        margin-bottom: 20px;
    }
    .empty-state h5 {
        color: #4A3228;
        font-weight: 700;
    }
    .empty-state p {
        color: #94A3B8;
        margin-bottom: 20px;
    }
    .btn-new-complaint {
        background: linear-gradient(135deg, #8B6B4A, #A8825A);
        color: white;
        padding: 12px 28px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }
    .btn-new-complaint:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(139, 115, 85, 0.3);
        color: white;
    }

    @media (max-width: 768px) {
        .complaint-card { padding: 18px; }
        .timeline { flex-direction: column; align-items: flex-start; padding: 14px; }
        .timeline-connector { width: 3px; height: 20px; flex: none; }
        .timeline-item { min-width: auto; width: 100%; }
    }
</style>
@endsection