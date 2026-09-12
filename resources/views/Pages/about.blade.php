@extends('Layout.app')

@section('content')
<link href="{{ asset('css/about.css') }}" rel="stylesheet">

<!-- ========================================== -->
<!-- AAPKA PURANA ABOUT US SECTION (WAISA HI RAHEGA) -->
<!-- ========================================== -->
<section class="about-section" id="about-trigger">
    <div class="container">
        <div class="row align-items-center">
            
            <div class="col-lg-6 about-text-col">
                <h2 class="about-heading reveal-down">ABOUT US</h2>
                <div class="heading-line reveal-down"></div>
                
                <div class="about-passage" id="typewriter-text">
                  <p class="justify-text">
                  <h1>ABOUT US</h1>
                  <p style="text-align: justify;">
                    At GCW Hostel, we provide more than just accommodation — we offer a secure, supportive, and vibrant community for girls to live, learn, and grow. With round-the-clock security, modern amenities, and a warm homely atmosphere, we ensure you have everything you need to succeed. Join us and experience a place where comfort meets convenience, and every girl is empowered to reach her full potential.
                  </p>  
                </div>
            </div>

            <div class="col-lg-6 about-img-col">
                <div class="about-bg-shape"></div>
                <div class="about-main-image reveal-right-slide">
                    <img src="{{ asset('Assert/pic24.jpeg') }}" alt="Our Team">
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ========================================== -->
<!-- NAYA SECTION: VISION, MISSION & VALUES -->
<!-- ========================================== -->

<!-- CSS Styles for VMV Section -->
<style>
    .vmv-section {
        padding: 80px 20px;
        background-color: #F9F6F0; /* Aapki site ka light background */
        font-family: 'Poppins', sans-serif;
    }

    .vmv-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .vmv-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .vmv-header h2 {
        font-size: 36px;
        color: #4A3B32;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
    }

    .vmv-header p {
        font-size: 18px;
        color: #6B5B52;
    }

    /* 3 Column Grid */
    .vmv-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }

    /* Card Design */
    .vmv-card {
        background-color: #FFFFFF;
        padding: 40px 30px;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-bottom: 4px solid #8B5A2B; /* Brown border */
    }

    .vmv-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    /* Icons */
    .vmv-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 20px;
        background-color: #FDF5E6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #D4AF37; /* Gold Color */
    }

    .vmv-icon svg {
        width: 35px;
        height: 35px;
    }

    .vmv-card h3 {
        font-size: 22px;
        color: #4A3B32;
        margin-bottom: 15px;
        text-transform: uppercase;
        font-weight: 600;
    }

    .vmv-card p {
        font-size: 15px;
        color: #666;
        line-height: 1.6;
        margin-bottom: 0;
    }

    /* Values List */
    .vmv-list {
        text-align: left;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .vmv-list li {
        font-size: 14px;
        color: #666;
        margin-bottom: 10px;
        line-height: 1.5;
        position: relative;
        padding-left: 20px;
    }

    .vmv-list li::before {
        content: "•";
        color: #D4AF37;
        font-weight: bold;
        font-size: 20px;
        position: absolute;
        left: 0;
        top: -2px;
    }

    /* Mobile Responsive */
    @media (max-width: 992px) {
        .vmv-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .vmv-grid {
            grid-template-columns: 1fr;
        }
        .vmv-header h2 {
            font-size: 28px;
        }
        .vmv-card {
            padding: 30px 20px;
        }
    }
</style>

<!-- HTML Structure for VMV Section -->
<section class="vmv-section">
    <div class="vmv-container">
        <!-- Heading -->
        <div class="vmv-header">
            <h2>Our Core Principles</h2>
            <p>Guiding our community towards excellence and empowerment.</p>
        </div>

        <!-- 3 Columns -->
        <div class="vmv-grid">
            
            <!-- 1. Mission -->
            <div class="vmv-card">
                <div class="vmv-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                </div>
                <h3>Our Mission</h3>
                <p>To provide a safe, secure, and nurturing environment specifically designed for female students and professionals, ensuring they have the support they need to excel in their academic and professional journeys.</p>
            </div>

            <!-- 2. Vision -->
            <div class="vmv-card">
                <div class="vmv-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </div>
                <h3>Our Vision</h3>
                <p>To be the leading residential facility in Gujranwala, recognized for empowering women through a vibrant community, modern amenities, and a homely atmosphere that fosters personal growth and lifelong learning.</p>
            </div>

            <!-- 3. Values -->
            <div class="vmv-card">
                <div class="vmv-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12l4 6-10 13L2 9z"></path><path d="M11 3 8 9l4 13 4-13-3-6"></path><path d="M2 9h20"></path></svg>
                </div>
                <h3>Our Values</h3>
                <ul class="vmv-list">
                    <li><strong>Integrity:</strong> Upholding honesty and strong moral principles.</li>
                    <li><strong>Excellence:</strong> Striving for the highest standards in everything we do.</li>
                    <li><strong>Community:</strong> Building a supportive and inclusive family environment.</li>
                    <li><strong>Empowerment:</strong> Encouraging every girl to reach her full potential.</li>
                </ul>
            </div>

        </div>
    </div>
</section>
<!-- ========================================== -->
<!-- NAYA SECTION KHATAM -->
<!-- ========================================== -->


<script src="{{ asset('js/about.js') }}"></script>

@include('Component.History')
@include('component.gallery')

@endsection