<link href="{{ asset('css/gallery.css') }}" rel="stylesheet">

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