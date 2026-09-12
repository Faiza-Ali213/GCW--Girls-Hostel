@extends('Layout.app')

@section('content')

<link href="{{ asset('css/gallery.css') }}" rel="stylesheet">

<!-- ========================================== -->
<!-- HERO SECTION -->
<!-- ========================================== -->
<section class="gallery-hero-section">
    <div class="gallery-hero-overlay"></div>
    <div class="container gallery-hero-content">
        <span class="hero-accent">GCW HOSTEL • GUJRANWALA</span>
        <h1 class="hero-title">Our Gallery</h1>
        <p class="hero-subtitle">
            Step inside our vibrant community. From peaceful green gardens to cozy study corners, 
            discover the spaces where memories are made and dreams take flight.
        </p>
    </div>
</section>

<!-- ========================================== -->
<!-- GALLERY SECTION (AAPKA PURANA CODE) -->
<!-- ========================================== -->
<section class="gallery-section" id="gallery-trigger">
    <div class="container">
        <div class="text-center mb-5 reveal-down">
            <span class="accent-text d-block mb-2">Our Gallery</span>
            <h2 class="split-title mx-auto">A Glimpse Into Your Future Home</h2>
            <p class="feature-subtext mx-auto mt-3">
                Experience the vibrant life at GCW Hostel through our visual journey. From cozy study corners to 
                lively community spaces, see where your academic success begins.
            </p>
        </div>

        <div class="gallery-grid">
            <div class="gallery-item item-1 reveal-left">
                <img src="{{ asset('Assert/pic15.jpeg') }}" alt="Hostel Exterior">
            </div>
            <div class="gallery-item item-2 reveal-down">
                <img src="{{ asset('Assert/pic16.jpeg') }}" alt="Hostel Common Area">
            </div>
            <div class="gallery-item item-3 reveal-right">
                <img src="{{ asset('Assert/pic6.jpeg') }}" alt="Hostel Room">
            </div>
            <div class="gallery-item item-4 reveal-up">
                <img src="{{ asset('Assert/pic8.jpeg') }}" alt="Dining Hall">
            </div>
            <div class="gallery-item item-5 reveal-left">
                <img src="{{ asset('Assert/pic11.jpeg') }}" alt="Garden">
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('js/gallery.js') }}"></script>

<!-- ========================================== -->
<!-- HERO SECTION CSS (SAB SE AAKHIR MEIN, TAKE OVERRIDE KARE) -->
<!-- ========================================== -->
<style>
    .gallery-hero-section {
        position: relative !important;
        width: 100% !important;
        height: 65vh !important;
        min-height: 500px !important;
        background-image: url('{{ asset("Assert/pic15.jpeg") }}') !important; 
        background-size: cover !important;
        background-position: center !important;
        background-attachment: fixed !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        overflow: hidden !important;
    }

    .gallery-hero-overlay {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background: linear-gradient(to bottom, rgba(30, 20, 15, 0.95), rgba(60, 45, 35, 0.85)) !important;
        z-index: 1 !important;
    }

    .gallery-hero-content {
        position: relative !important;
        z-index: 2 !important;
        max-width: 800px !important;
        padding: 0 20px !important;
    }

    .gallery-hero-content .hero-accent {
        display: block !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        letter-spacing: 5px !important;
        color: #D4AF37 !important;
        margin-bottom: 15px !important;
        text-transform: uppercase !important;
        text-shadow: 1px 1px 5px rgba(0,0,0,0.8) !important;
    }

    .gallery-hero-content .hero-title {
        font-size: 60px !important;
        font-weight: 700 !important;
        color: #ffffff !important;
        margin: 0 0 20px 0 !important;
        text-transform: uppercase !important;
        letter-spacing: 3px !important;
        line-height: 1.2 !important;
        text-shadow: 3px 3px 25px rgba(0,0,0,1), 0 0 15px rgba(0,0,0,0.9) !important;
    }

    .gallery-hero-content .hero-subtitle {
        font-size: 18px !important;
        color: #f5f5f5 !important;
        line-height: 1.7 !important;
        max-width: 700px !important;
        margin: 0 auto !important;
        text-shadow: 2px 2px 12px rgba(0,0,0,1) !important;
    }

    @media (max-width: 768px) {
        .gallery-hero-section {
            height: 60vh !important;
            background-attachment: scroll !important;
        }
        .gallery-hero-content .hero-title {
            font-size: 34px !important;
        }
        .gallery-hero-content .hero-subtitle {
            font-size: 15px !important;
        }
        .gallery-hero-content .hero-accent {
            font-size: 11px !important;
            letter-spacing: 3px !important;
        }
    }
</style>

@endsection