{{-- History.blade.php --}}
<link href="{{ asset('css/History.css') }}" rel="stylesheet">

<section class="history-section py-5 overflow-hidden">
    <div class="container">
        <div class="row mb-5 reveal-fade-down">
            <div class="col-12 text-center">
                <span class="text-uppercase fw-bold text-accent mb-2 d-block">Legacy &amp; Heritage</span>
                <h2 class="display-4 fw-bold" style="color: #0B2E33;">The Foundation of Excellence</h2>
                <div class="header-line mx-auto"></div>
            </div>
        </div>

        <div class="row g-5 align-items-start">
            <div class="col-lg-5 reveal-slide-right">
                <div class="history-image-wrapper">
                    <div class="history-frame shadow-lg">
                        {{-- Fix: Use correct asset path and add fallback --}}
                        <img src="{{ asset('Assert/pic18.jpeg') }}" 
                             alt="Foundation Stone 1980" 
                             class="img-fluid w-100"
                             onerror="this.src='{{ asset('images/default.jpg') }}'; this.alt='Image not found';">
                        <div class="image-caption p-3 text-center">
                            <small class="text-white">Foundation Stone: July 2, 1980</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7 reveal-slide-left">
                <div class="history-content">
                    <p class="lead mb-4">
                        The journey of GCW Hostel began with a vision to provide a safe, secure, and nurturing environment specifically designed for female students and professionals in the heart of Gujranwala.
                    </p>
                    <p>
                        As etched into the heritage of our walls, the foundation of this institution was formally laid on July 2, 1980. This significant milestone in women's education in the region was inaugurated by Sardar Muhammad Aslam Sukhera, who served as the Deputy Commissioner of Gujranwala at that time.
                    </p>
                    <p>
                        From its humble beginnings as a single residential block, the hostel has grown into a premier living space. It offers modern facilities like 24-hour Free WiFi, CCTV security, and lush green lawns, all while maintaining the dignity and traditions established over four decades ago.
                    </p>
                    <div class="founder-quote mt-4 p-4 border-start border-4">
                        <i class="bi bi-quote fs-2" style="color: #0B2E33;"></i>
                        <p class="fst-italic mb-0 text-dark">"A home away from home, built on a foundation of safety."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Move script to end of body for better loading --}}
<script src="{{ asset('js/History.js') }}"></script>