@extends('Layout.app')

@section('title', 'Rooms | GCW Hostel')

@section('content')
<link href="{{ asset('css/Rooms.css') }}" rel="stylesheet">

<section class="rooms-hero-luxury">
    <div class="hero-image-container">
        <div class="hero-vignette"></div>
        <img src="{{ asset('Assert/hostel room.jpg') }}" alt="GCW Hostel Interior" class="hero-main-img">
    </div>

    <div class="container hero-content-wrapper">
        <div class="text-center text-white mb-5 reveal-hero">
            <h1 class="hero-title">Discover Your Perfect Space, <br>Compare & Book Your Stay</h1>
            <p class="hero-subtitle">Premium living for students at Government Graduate College (W) Satellite town Gujranwala.</p>
        </div>

        <div class="booking-glass-bar reveal-hero-up">
            <div class="row align-items-center g-3">
                <div class="col-md-3 border-end-custom">
                    <label class="bar-label">Location</label>
                    <div class="bar-value"><i class="bi bi-geo-alt me-2"></i>Satellite town, GRW</div>
                </div>
                <div class="col-md-3 border-end-custom">
                    <label class="bar-label">Sharing Type</label>
                    <div class="bar-value"><i class="bi bi-people-fill me-2"></i>2, 3 & 4 Sharing</div>
                </div>
                <div class="col-md-3 border-end-custom">
                    <label class="bar-label">Pricing</label>
                    <div class="bar-value">Starting from Rs. 80,000<br>per Year</div>
                </div>
                <div class="col-md-3">
                    <a href="#room-list" class="btn-search-hero">Check Availability</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="room-section py-5" id="room-list">
    <div class="container">
        <div class="room-container mt-4">
            @php
                $rooms = [
                    [
                        'name' => 'Premium Twin Suite',
                        'desc' => 'Our most exclusive sharing option. Designed for two students, offering maximum privacy and dedicated study zones.',
                        'sharing' => '2 Persons Sharing',
                        'image' => 'Assert/pic6.jpeg',
                        'icon' => 'bi-people-fill'
                    ],
                    [
                        'name' => 'Classic Triple Sharing',
                        'desc' => 'The perfect balance of social life and personal space. Accommodates three students with individual wardrobes.',
                        'sharing' => '3 Persons Sharing',
                        'image' => 'Assert/pic25.jpeg',
                        'icon' => 'bi-microsoft-teams'
                    ],
                    [
                        'name' => 'Economy Quad Room',
                        'desc' => 'A vibrant community-focused space for four students. Affordable luxury with spacious layouts.',
                        'sharing' => '4 Persons Sharing',
                        'image' => 'Assert/pic1.jpeg',
                        'icon' => 'bi-grid-3x3-gap-fill'
                    ]
                ];
            @endphp

            @foreach($rooms as $index => $room)
            <div class="room-card mb-5">
                <div class="row g-0">
                    <div class="col-12 col-lg-6 {{ $index % 2 != 0 ? 'order-lg-2' : '' }}">
                        <div class="room-image" style="background-image: url('{{ asset($room['image']) }}');"></div>
                    </div>
                    <div class="col-12 col-lg-6 {{ $index % 2 != 0 ? 'order-lg-1' : '' }}">
                        <div class="room-details">
                            <h3 class="room-name">{{ $room['name'] }}</h3>
                            <p class="room-desc">{{ $room['desc'] }}</p>
                            <hr class="divider">
                            <div class="room-info mb-4">
                                <span class="info-label d-block mb-2">Room Specification</span>
                                <div class="info-icons d-flex flex-wrap gap-3">
                                    <span><i class="bi {{ $room['icon'] }}"></i> {{ $room['sharing'] }}</span>
                                    <span><i class="bi bi-shield-check"></i> 24/7 Security</span>
                                </div>
                            </div>
                            <div class="room-actions">
                                <a href="/booking" class="btn-reserve-primary w-100 text-center">Reserve Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<script src="{{ asset('js/Rooms.js') }}"></script>
@endsection