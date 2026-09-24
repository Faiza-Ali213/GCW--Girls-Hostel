@extends('Layout.admin')

@section('content')
<div class="dashboard-wrapper">
    <div class="dashboard-header">
        <h2>Dashboard <span>| Hostel Management Statistics</span></h2>
    </div>

    <div class="stats-container">
        <div class="row-top">
            <div class="pro-card">
                <div class="icon-circle">
                    <i class="bi bi-house-door"></i>
                </div>
                <span class="stat-label">Total Rooms</span>
                <span class="stat-value">{{ $totalRooms ?? 0 }}</span>
            </div>

            <div class="pro-card">
                <div class="icon-circle">
                    <i class="bi bi-people"></i>
                </div>
                <span class="stat-label">Total Students</span>
                <span class="stat-value">{{ $totalStudents ?? 0 }}</span>
            </div>

            <div class="pro-card">
                <div class="icon-circle">
                    <i class="bi bi-person-workspace"></i>
                </div>
                <span class="stat-label">Total Staff</span>
                <span class="stat-value">{{ $totalStaff ?? 0 }}</span>
            </div>
        </div>

        <div class="row-bottom">
            <div class="pro-card">
                <div class="icon-circle">
                    <i class="bi bi-bookmark-check"></i>
                </div>
                <span class="stat-label">Allocated Rooms</span>
                <span class="stat-value">{{ $allocatedRooms ?? 0 }}</span>
            </div>

            <div class="pro-card">
                <div class="icon-circle">
                    <i class="bi bi-door-open"></i>
                </div>
                <span class="stat-label">Empty Rooms</span>
                <span class="stat-value">{{ $emptyRooms ?? 0 }}</span>
            </div>
        </div>
    </div>
</div>

<style>
/* ======================================== */
/* DASHBOARD SECTION - BLUE THEME */
/* ======================================== */

/* Main Container */
.dashboard-wrapper {
    padding: 20px;
    background: #ffffff;
    min-height: 100vh;
}

.dashboard-header h2 {
    color: #0b1a33;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 25px;
}

.dashboard-header h2 span {
    color: #4F46E5;
    font-size: 1rem;
    font-weight: 400;
}

/* ======================================== */
/* STATS CONTAINER */
/* ======================================== */

.stats-container {
    display: grid;
    gap: 25px;
    margin: 4px 0 30px 0;
}

/* Row 1: 3 Grids */
.row-top {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

/* Row 2: 2 Grids */
.row-bottom {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
    width: 80%;
    margin: 0 auto;
}

/* ======================================== */
/* PROFESSIONAL CARD - BLUE THEME */
/* ======================================== */

.pro-card {
    background: #f8faff;
    border-radius: 20px;
    padding: 40px 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    border: 2px solid #818CF8;
    box-shadow: 0 10px 30px rgba(79, 70, 229, 0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.pro-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(79, 70, 229, 0.15);
    border-color: #4F46E5;
}

/* Brand Accent Bar on Top of Card */
.pro-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 6px;
    background: linear-gradient(135deg, #4338CA 0%, #4F46E5 50%, #818CF8 100%);
}

/* ======================================== */
/* ICON CIRCLE - BLUE THEME */
/* ======================================== */

.icon-circle {
    width: 80px;
    height: 80px;
    background: rgba(79, 70, 229, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    transition: all 0.3s ease;
    border: 2px solid rgba(79, 70, 229, 0.1);
}

.pro-card:hover .icon-circle {
    background: linear-gradient(135deg, #4338CA 0%, #4F46E5 100%);
    border-color: #4F46E5;
    transform: scale(1.05);
}

.icon-circle i {
    font-size: 2.2rem;
    color: #4F46E5;
    transition: all 0.3s ease;
}

.pro-card:hover .icon-circle i {
    color: #ffffff;
}

/* ======================================== */
/* TEXT STYLING */
/* ======================================== */

.stat-label {
    color: #4338CA;
    font-size: 1.1rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 5px;
}

.stat-value {
    font-size: 3rem;
    font-weight: 800;
    color: #0b1a33;
}

.stat-value span {
    color: #4F46E5;
}

/* ======================================== */
/* RESPONSIVE */
/* ======================================== */

@media (max-width: 992px) {
    .row-top {
        grid-template-columns: repeat(2, 1fr);
    }

    .row-bottom {
        grid-template-columns: 1fr;
        width: 100%;
    }
}

@media (max-width: 768px) {
    .dashboard-wrapper {
        padding: 15px;
    }

    .dashboard-header h2 {
        font-size: 1.6rem;
    }

    .row-top {
        grid-template-columns: 1fr;
    }

    .pro-card {
        padding: 30px 20px;
    }

    .stat-value {
        font-size: 2.2rem;
    }

    .icon-circle {
        width: 65px;
        height: 65px;
    }

    .icon-circle i {
        font-size: 1.8rem;
    }

    .stat-label {
        font-size: 0.95rem;
    }
}

@media (max-width: 576px) {
    .dashboard-wrapper {
        padding: 10px;
    }

    .dashboard-header h2 {
        font-size: 1.3rem;
    }

    .dashboard-header h2 span {
        font-size: 0.85rem;
        display: block;
        margin-top: 5px;
    }

    .pro-card {
        padding: 25px 15px;
        border-radius: 15px;
    }

    .stat-value {
        font-size: 1.8rem;
    }

    .icon-circle {
        width: 55px;
        height: 55px;
    }

    .icon-circle i {
        font-size: 1.5rem;
    }

    .stat-label {
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .row-bottom {
        gap: 15px;
    }

    .stats-container {
        gap: 15px;
    }
}

/* ======================================== */
/* DARK MODE - BLUE THEME */
/* ======================================== */

@media (prefers-color-scheme: dark) {
    .dashboard-wrapper {
        background: #e2e8f0;
    }

    .dashboard-header h2 {
        color: #0f172a;
    }

    .dashboard-header h2 span {
        color: #818CF8;
    }

    .pro-card {
        background: #1e293b;
        border-color: #4F46E5;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .pro-card:hover {
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        border-color: #818CF8;
    }

    .pro-card::before {
        background: linear-gradient(135deg, #4338CA 0%, #4F46E5 50%, #818CF8 100%);
    }

    .icon-circle {
        background: rgba(79, 70, 229, 0.15);
        border-color: rgba(79, 70, 229, 0.1);
    }

    .pro-card:hover .icon-circle {
        background: linear-gradient(135deg, #4338CA 0%, #4F46E5 100%);
        border-color: #4F46E5;
    }

    .icon-circle i {
        color: #818CF8;
    }

    .pro-card:hover .icon-circle i {
        color: #ffffff;
    }

    .stat-label {
        color: #94a3b8;
    }

    .stat-value {
        color: #e2e8f0;
    }

    .stat-value span {
        color: #818CF8;
    }
}

/* ======================================== */
/* ROOT VARIABLES - BLUE THEME */
/* ======================================== */

:root {
    --dashboard-primary: #4F46E5;
    --dashboard-primary-light: #818CF8;
    --dashboard-primary-lighter: #A5B4FC;
    --dashboard-primary-dark: #4338CA;
    --dashboard-primary-darker: #3730A3;
    --dashboard-bg: #ffffff;
}
</style>
@endsection