<link href="{{ asset('css/room.css') }}" rel="stylesheet">
<section class="room-section py-5">
    <div class="container">
        <div class="row mb-5 align-items-center">
            <div class="col-12 col-md-8 text-center text-md-start">
                <span class="accent-text d-block mb-2">Our Living Spaces</span>
                <h2 class="split-title mb-0">Tailored sharing options for every student</h2>
            </div>
            <div class="col-12 col-md-4 text-center text-md-end mt-4 mt-md-0">
                <a href="{{ route('rooms') }}" class="btn-all-rooms">View All Rooms <span class="arrow-icon">↗</span></a>
            </div>
        </div>

        <div class="room-container">
            @php
                $rooms = [
                    [
                        'name' => 'Premium Twin Suite',
                        'desc' => 'Our most exclusive sharing option. Designed for two students, this room offers maximum privacy, dedicated individual study desks, and extra storage for a focused academic life.',
                        'sharing' => '2 Persons Sharing',
                        'image' => 'Assert/pic6.jpeg',
                        'icon' => 'bi-people-fill'
                    ],
                    [
                        'name' => 'Classic Triple Sharing',
                        'desc' => 'The perfect balance of social life and personal space. This room comfortably accommodates three students with individual wardrobes and high-quality shared furniture.',
                        'sharing' => '3 Persons Sharing',
                        'image' => 'Assert/room4.jpeg',
                        'icon' => 'bi-microsoft-teams'
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
                                <a href="\booking" class="btn-reserve-primary w-100 text-center">Reserve Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<script src="{{ asset('js/room.js') }}"></script>