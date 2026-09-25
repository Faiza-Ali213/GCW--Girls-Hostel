@extends('Layout.admin')

@section('content')
<div class="room-container">

    <!-- Page Header -->
    <div class="page-header-section">
        <h2><i class="bi bi-door-open me-2" style="color: #4F46E5;"></i>Room Allocation</h2>
        <p class="text-muted">Manage hostel rooms and their availability.</p>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="stat-card total-rooms">
                <div class="stat-number">{{ $totalRooms ?? 0 }}</div>
                <div class="stat-label">Total Rooms</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="stat-card available-rooms">
                <div class="stat-number">{{ $availableRooms ?? 0 }}</div>
                <div class="stat-label">Available</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="stat-card full-rooms">
                <div class="stat-number">{{ $fullRooms ?? 0 }}</div>
                <div class="stat-label">Full</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="stat-card maintenance-rooms">
                <div class="stat-number">{{ $maintenanceRooms ?? 0 }}</div>
                <div class="stat-label">Maintenance</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="stat-card available-beds">
                <div class="stat-number">{{ $availableBeds ?? 0 }}</div>
                <div class="stat-label">Available Beds</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="stat-card occupied-beds">
                <div class="stat-number">{{ $occupiedBeds ?? 0 }}</div>
                <div class="stat-label">Occupied Beds</div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Row -->
    <form action="{{ route('room_allocation') }}" method="GET" id="roomFilterForm">
        <div class="search-filter-row">
            
            <!-- Search Input -->
            <div class="search-input-wrapper">
                <i class="bi bi-search"></i>
                <input type="text" 
                       name="search" 
                       class="search-input" 
                       placeholder="Search room number..." 
                       value="{{ request('search') }}"
                       onkeypress="if(event.key === 'Enter'){ this.form.submit(); }">
            </div>

            <!-- Status Filter -->
            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="available"   {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                <option value="full"        {{ request('status') == 'full' ? 'selected' : '' }}>Full</option>
                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>

            <!-- Block Filter -->
            <select name="block" class="filter-select" onchange="this.form.submit()">
                <option value="">All Blocks</option>
                <option value="A" {{ request('block') == 'A' ? 'selected' : '' }}>Block A</option>
                <option value="B" {{ request('block') == 'B' ? 'selected' : '' }}>Block B</option>
                <option value="C" {{ request('block') == 'C' ? 'selected' : '' }}>Block C</option>
            </select>

            <!-- Search Button -->
            <button type="submit" class="btn-search-room">
                <i class="bi bi-search"></i> Search
            </button>

            <!-- Clear Button -->
            @if(request('search') || request('status') || request('block'))
                <a href="{{ route('room_allocation') }}" class="btn-clear-room">
                    <i class="bi bi-x-circle"></i> Clear
                </a>
            @endif

            <!-- ✅ Add New Room Button -->
            <a href="{{ route('room-allocation.create') }}" class="btn-add-room">
                <i class="bi bi-plus-circle"></i> Add New Room
            </a>

        </div>
    </form>

    <!-- Rooms Table -->
    <div class="rooms-table-card">
        <div class="table-responsive">
            <table class="table rooms-table align-middle">
                <thead>
                    <tr>
                        <th width="60px">#</th>
                        <th>Room Number</th>
                        <th>Block</th>
                        <th>Floor</th>
                        <th>Type</th>
                        <th>Capacity</th>
                        <th>Occupied</th>
                        <th>Available</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms ?? [] as $room)
                    <tr>
                        <td class="text-muted fw-bold">{{ $loop->iteration }}</td>
                        <td><span class="room-number">{{ $room->room_number }}</span></td>
                        <td><span class="block-badge">{{ $room->block }}</span></td>
                        <td>{{ $room->floor ?? 'N/A' }}</td>
                        <td><span class="type-badge">{{ $room->type ?? 'N/A' }}</span></td>
                        <td>{{ $room->capacity ?? 'N/A' }}</td>
                        <td>{{ $room->occupied ?? 0 }}</td>
                        <td>{{ $room->available ?? 0 }}</td>
                        <td>
                            <span class="status-badge status-{{ $room->status ?? 'available' }}">
                                {{ ucfirst($room->status ?? 'Available') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="action-buttons">
                                <a href="{{ route('room-allocation.show', $room->id) }}" class="action-btn view-btn">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('room-allocation.edit', $room->id) }}" class="action-btn edit-btn">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('room-allocation.destroy', $room->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete-btn" 
                                            onclick="return confirm('Delete this room?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <i class="bi bi-door-closed"></i>
                                <h5>No Rooms Found</h5>
                                <p>No rooms match your search criteria.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($rooms) && $rooms->hasPages())
            <div class="pagination-container">
                {{ $rooms->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<style>
/* ============================================ */
/* ROOM ALLOCATION - BLUE THEME */
/* ============================================ */

.room-container {
    padding: 20px 0;
}

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

/* Statistics Cards */
.stat-card {
    background: white;
    border-radius: 16px;
    padding: 18px 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    text-align: center;
    transition: all 0.3s ease;
    border-top: 4px solid;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}

.stat-card .stat-number {
    font-size: 1.8rem;
    font-weight: 700;
    color: #0b1a33;
    margin-bottom: 4px;
}

.stat-card .stat-label {
    color: #94a3b8;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-card.total-rooms { border-top-color: #4F46E5; }
.stat-card.available-rooms { border-top-color: #10B981; }
.stat-card.full-rooms { border-top-color: #EF4444; }
.stat-card.maintenance-rooms { border-top-color: #F59E0B; }
.stat-card.available-beds { border-top-color: #3B82F6; }
.stat-card.occupied-beds { border-top-color: #8B5CF6; }

/* Search & Filter Row */
.search-filter-row {
    display: flex;
    align-items: center;
    gap: 12px;
    background: white;
    padding: 15px 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.search-input-wrapper {
    flex: 1;
    min-width: 250px;
    position: relative;
    display: flex;
    align-items: center;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 0 15px;
    transition: all 0.3s ease;
    background: white;
}

.search-input-wrapper:focus-within {
    border-color: #4F46E5;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
}

.search-input-wrapper i {
    color: #94a3b8;
    margin-right: 10px;
}

.search-input {
    border: none;
    outline: none;
    padding: 12px 0;
    flex: 1;
    font-size: 0.95rem;
    background: transparent;
    color: #334155;
}

.filter-select {
    padding: 10px 15px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.9rem;
    color: #334155;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 140px;
}

.filter-select:focus {
    border-color: #4F46E5;
    outline: none;
}

.btn-search-room {
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

.btn-search-room:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
    color: white;
}

.btn-clear-room {
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

.btn-clear-room:hover {
    background: #e2e8f0;
    color: #1e293b;
}

/* ✅ Add New Room Button */
.btn-add-room {
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
}

.btn-add-room:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.35);
    color: white;
}

/* Rooms Table */
.rooms-table-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    overflow: hidden;
    border: 1px solid #f0f2f5;
}

.rooms-table {
    margin-bottom: 0;
}

.rooms-table thead {
    background: #f8fafc;
}

.rooms-table thead th {
    border: none;
    padding: 14px 18px;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 0.5px;
    color: #64748b;
    border-bottom: 2px solid #eef2f6;
    white-space: nowrap;
}

.rooms-table tbody td {
    padding: 14px 18px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f3f5;
}

.rooms-table tbody tr:hover {
    background: #f8faff;
}

.room-number {
    font-weight: 700;
    color: #0b1a33;
    font-size: 0.95rem;
}

.block-badge {
    background: #EEF2FF;
    color: #4F46E5;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
}

.type-badge {
    background: #f1f5f9;
    color: #475569;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
    text-transform: capitalize;
}

.status-badge {
    padding: 5px 14px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
}

.status-available {
    background: #ECFDF5;
    color: #10B981;
}

.status-full {
    background: #FEF2F2;
    color: #EF4444;
}

.status-maintenance {
    background: #FFFBEB;
    color: #F59E0B;
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
    margin-bottom: 0;
}

/* Pagination */
.pagination-container {
    padding: 15px 20px;
    border-top: 1px solid #f1f3f5;
}

/* Responsive */
@media (max-width: 768px) {
    .search-filter-row {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-input-wrapper,
    .filter-select,
    .btn-search-room,
    .btn-clear-room,
    .btn-add-room {
        width: 100%;
        justify-content: center;
    }
}
</style>

@endsection