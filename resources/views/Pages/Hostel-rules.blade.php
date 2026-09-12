@extends('Layout.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/rules.css') }}">

<!-- ========================================== -->
<!-- HERO SECTION -->
<!-- ========================================== -->
<section class="rules-hero-section">
    <div class="rules-hero-overlay"></div>
    <div class="container rules-hero-content">
        <span class="hero-accent">GCW HOSTEL • GUJRANWALA</span>
        <h1 class="hero-title">Rules &amp; Regulations</h1>
        <p class="hero-subtitle">
            Creating a safe, disciplined, and harmonious living environment for every resident. 
            Our guidelines ensure mutual respect, academic focus, and a peaceful community life. 
            Please take a moment to familiarize yourself with them.
        </p>
    </div>
</section>

<!-- ========================================== -->
<!-- RULES SECTION -->
<!-- ========================================== -->
<section class="rules-section py-5" id="rules-section">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge-accent">Conduct &amp; Discipline</span>
            <h2 class="display-5 fw-bold text-dark">Hostel Rules &amp; Regulations</h2>
            <div class="header-line mx-auto"></div>
        </div>

        <div class="row g-4">
            @php
                $rules = [
                    ['icon' => 'bi-clock-history', 'title' => 'Gate Timings', 'desc' => 'The main gate closes strictly at 9:00 PM. No entry/exit is allowed after hours without prior written permission.'],
                    ['icon' => 'bi-person-badge', 'title' => 'Identity Cards', 'desc' => 'Residents must carry their hostel ID cards at all times and present.'],
                    ['icon' => 'bi-potted-plant', 'title' => 'Cleanliness', 'desc' => 'Rooms must be kept tidy. Littering in the corridors or lush green lawns is strictly prohibited.'],
                    ['icon' => 'bi-volume-mute', 'title' => 'Silence Hours', 'desc' => 'Quiet hours begin at 10:00 PM to ensure an environment conducive to academic focus and rest.'],
                    ['icon' => 'bi-lightning-charge', 'title' => 'Electric Appliances', 'desc' => 'Heavy electric appliances like heaters or ACs are not allowed. Usage of unauthorized items leads to fines.'],
                    ['icon' => 'bi-shield-check', 'title' => 'Visitors Policy', 'desc' => 'Only authorized visitors are allowed on Sundays (9 AM - 5 PM). No visitors are permitted inside resident rooms.']
                ];
            @endphp

            @foreach($rules as $rule)
            <div class="col-lg-4 col-md-6">
                <div class="rule-card">
                    <div class="rule-icon-box">
                        <i class="bi {{ $rule['icon'] }}"></i>
                    </div>
                    <h4>{{ $rule['title'] }}</h4>
                    <p>{{ $rule['desc'] }}</p>
                    <div class="rule-card-footer">
                        <span class="status-indicator"></span> Strictly Enforced
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script src="{{ asset('js/rules.js') }}"></script>

<!-- ========================================== -->
<!-- HERO SECTION CSS -->
<!-- ========================================== -->
<style>
    .rules-hero-section {
        position: relative;
        width: 100%;
        height: 55vh;
        min-height: 420px;
        background: linear-gradient(135deg, #4A3228 0%, #6B5544 50%, #8B6B4A 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        overflow: hidden;
    }

    .rules-hero-section::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .rules-hero-section::after {
        content: '';
        position: absolute;
        bottom: -150px;
        left: -100px;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .rules-hero-overlay {
        display: none;
    }

    .rules-hero-content {
        position: relative;
        z-index: 5;
        max-width: 850px;
        padding: 0 20px;
    }

    .rules-hero-content .hero-accent {
        display: inline-block;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 5px;
        color: #D4AF37;
        margin-bottom: 20px;
        text-transform: uppercase;
        padding: 8px 24px;
        border: 2px solid rgba(212, 175, 55, 0.4);
        border-radius: 50px;
        background: rgba(212, 175, 55, 0.08);
    }

    .rules-hero-content .hero-title {
        font-size: 64px;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 25px 0;
        text-transform: uppercase;
        letter-spacing: 4px;
        line-height: 1.1;
        text-shadow: 3px 3px 30px rgba(0,0,0,0.8);
    }

    .rules-hero-content .hero-subtitle {
        font-size: 19px;
        color: #f5efe6;
        line-height: 1.8;
        max-width: 750px;
        margin: 0 auto;
        font-weight: 400;
    }

    @media (max-width: 768px) {
        .rules-hero-section {
            height: 50vh;
            min-height: 380px;
        }
        .rules-hero-content .hero-title {
            font-size: 36px;
            letter-spacing: 2px;
        }
        .rules-hero-content .hero-subtitle {
            font-size: 15px;
            line-height: 1.6;
        }
        .rules-hero-content .hero-accent {
            font-size: 11px;
            letter-spacing: 3px;
            padding: 6px 18px;
        }
    }
</style>

@endsection