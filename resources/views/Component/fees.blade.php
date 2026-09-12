<!-- ============================================ -->
<!-- FEES RECORD SECTION -->
<!-- ============================================ -->
<link rel="stylesheet" href="{{ asset('css/fees.css') }}">

<section class="fees-section py-5" id="fees-section">
    <div class="container">
        <div class="text-center mb-5">
            <span class="fees-badge">💰 Fee Structure</span>
            <h2 class="fees-title">Hostel <span>Fees Record</span></h2>
            <p class="fees-subtitle">Transparent pricing with no hidden charges — choose the plan that suits you best.</p>
        </div>

        @php
            $fees = [
                [
                    'type' => '2 Persons Sharing',
                    'icon' => 'bi-people-fill',
                    'price' => '60,000',
                    'per_head' => 'Rs. 30,000 per head',
                    'duration' => 'per Year',
                    'features' => [
                        'Spacious Twin Room',
                        'Individual Wardrobe',
                        'Dedicated Study Table',
                        'Attached Bathroom',
                        'High-Speed Wi-Fi',
                    ],
                    'popular' => false,
                ],
                [
                    'type' => '3 Persons Sharing',
                    'icon' => 'bi-microsoft-teams',
                    'price' => '90,000',
                    'per_head' => 'Rs. 30,000 per head',
                    'duration' => 'per Year',
                    'features' => [
                        'Comfortable Triple Room',
                        'Personal Storage Space',
                        'Shared Study Area',
                        '24/7 Security',
                        'High-Speed Wi-Fi',
                    ],
                    'popular' => true,
                ],
                [
                    'type' => '4 Persons Sharing',
                    'icon' => 'bi-grid-3x3-gap-fill',
                    'price' => '1,20,000',
                    'per_head' => 'Rs. 30,000 per head',
                    'duration' => 'per Year',
                    'features' => [
                        'Spacious Quad Room',
                        'Personal Storage Space',
                        'Common Study Area',
                        '24/7 Security',
                        'High-Speed Wi-Fi',
                    ],
                    'popular' => false,
                ],
            ];
        @endphp

        <div class="row g-4 justify-content-center">
            @foreach($fees as $index => $fee)
            <div class="col-lg-4 col-md-6">
                <div class="fee-card {{ $fee['popular'] ? 'popular' : '' }}">
                    @if($fee['popular'])
                        <div class="popular-badge">Most Popular</div>
                    @endif

                    <div class="fee-icon">
                        <i class="bi {{ $fee['icon'] }}"></i>
                    </div>

                    <h3 class="fee-type">{{ $fee['type'] }}</h3>

                    <div class="fee-price">
                        <span class="currency">Rs.</span>
                        <span class="amount">{{ $fee['price'] }}</span>
                        <span class="duration">{{ $fee['duration'] }}</span>
                    </div>

                    <p class="fee-per-head">{{ $fee['per_head'] }}</p>

                    <hr class="fee-divider">

                    <ul class="fee-features">
                        @foreach($fee['features'] as $feature)
                            <li><i class="bi bi-check-circle-fill"></i> {{ $feature }}</li>
                        @endforeach
                    </ul>

                    <a href="/booking" class="fee-btn">Book Now</a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Extra Info -->
        <div class="fee-note mt-5">
            <p class="mb-2"><i class="bi bi-info-circle me-2"></i> <strong>Please Note:</strong></p>
            <ul class="mb-0 ps-4">
                <li>The hostel fee is <strong>Rs. 30,000 per head per year</strong> for all sharing types (2, 3, and 4 persons).</li>
                <li><strong>Mess (meal) charges are NOT included</strong> in the above fee and are billed separately.</li>
                <li>A refundable security deposit is required at the time of admission.</li>
            </ul>
        </div>
    </div>
</section>