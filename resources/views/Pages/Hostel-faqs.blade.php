@extends('Layout.app')

@section('content')

<link href="{{ asset('css/faq.css') }}" rel="stylesheet">

<!-- ========================================== -->
<!-- HERO SECTION (GRADIENT BACKGROUND - NO IMAGE) -->
<!-- ========================================== -->
<section class="faq-hero-section">
    <div class="faq-hero-content">
        <span class="hero-accent">GCW HOSTEL • GUJRANWALA</span>
        <h1 class="hero-title">Frequently Asked Questions</h1>
        <p class="hero-subtitle">
            Got questions? We've got answers. From room facilities and mess menus 
            to security protocols and visitor policies — discover everything you need 
            to know about life at GCW Hostel.
        </p>
    </div>
</section>

<!-- ========================================== -->
<!-- FAQ SECTION -->
<!-- ========================================== -->
<section class="faq-modern-section" id="faq-trigger">
    <div class="container">
        <div class="text-center mb-5">
            <span class="faq-pre-title d-block mb-2">Hostel Life Insights</span>
            <h2 class="faq-main-title mx-auto">Your Questions, Answered</h2>
            <p class="faq-intro-text mx-auto mt-3">
                Browse through the most common queries asked by our residents and their families. 
                Can't find what you're looking for? Reach out to our warden office anytime.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="faq-container">
                    @php
                        $faqs = [
                            ['q' => 'What are the visiting hours for parents?', 'a' => 'Parents and authorized guardians can visit on Sundays between 9:00 AM and 5:00 PM. Weekday visits require Warden approval.'],
                            ['q' => 'Is the mess fee included in the monthly rent?', 'a' => 'Yes! The monthly package covers 3 hygienic meals daily. Our menu includes items like Biryani, Palak Chicken, and special Sunday treats like Halwa Puri.'],
                            ['q' => 'What is the security protocol at the hostel?', 'a' => 'Security is our priority. We feature 24/7 CCTV surveillance and professional on-site guards to ensure a safe environment.'],
                            ['q' => 'Is high-speed Wi-Fi available?', 'a' => 'Absolutely. We provide 24/7 unlimited high-speed Wi-Fi access throughout the hostel premises to support your academic needs.'],
                            ['q' => 'What are the room sharing options available?', 'a' => 'We offer 2-seater, 3-seater, and 4-seater rooms depending on availability. Each room is furnished with beds, study tables, cupboards, and attached washrooms.'],
                            ['q' => 'Is there a proper study environment?', 'a' => 'Yes, we maintain a quiet and disciplined environment. There are dedicated study hours, and a separate study room is available for exam preparation.'],
                        ];
                    @endphp

                    @foreach($faqs as $index => $item)
                    <div class="faq-card" data-index="{{ $index }}">
                        <div class="faq-header" onclick="toggleFaq({{ $index }})">
                            <span class="faq-question">{{ $item['q'] }}</span>
                            <div class="faq-icon-wrapper">
                                <span class="faq-icon">+</span>
                            </div>
                        </div>
                        <div class="faq-body" id="faq-body-{{ $index }}">
                            <div class="faq-content">
                                <p class="mb-0">{{ $item['a'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('js/faq.js') }}"></script>

<!-- ========================================== -->
<!-- HERO SECTION CSS - GRADIENT BACKGROUND -->
<!-- ========================================== -->
<style>
    .faq-hero-section {
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

    .faq-hero-section::before {
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

    .faq-hero-section::after {
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

    .faq-hero-content {
        position: relative;
        z-index: 5;
        max-width: 850px;
        padding: 0 20px;
    }

    .faq-hero-content .hero-accent {
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

    .faq-hero-content .hero-title {
        font-size: 64px;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 25px 0;
        text-transform: uppercase;
        letter-spacing: 4px;
        line-height: 1.1;
        text-shadow: 3px 3px 30px rgba(0,0,0,0.8);
    }

    .faq-hero-content .hero-subtitle {
        font-size: 19px;
        color: #f5efe6;
        line-height: 1.8;
        max-width: 750px;
        margin: 0 auto;
        font-weight: 400;
    }

    @media (max-width: 768px) {
        .faq-hero-section {
            height: 50vh;
            min-height: 380px;
        }
        .faq-hero-content .hero-title {
            font-size: 36px;
            letter-spacing: 2px;
        }
        .faq-hero-content .hero-subtitle {
            font-size: 15px;
            line-height: 1.6;
        }
        .faq-hero-content .hero-accent {
            font-size: 11px;
            letter-spacing: 3px;
            padding: 6px 18px;
        }
    }
</style>

@endsection