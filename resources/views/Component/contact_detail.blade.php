<link href="{{ asset('css/contact_detail.css') }}" rel="stylesheet">

<section class="contact-section" id="contact-trigger">
    <div class="container">
        <div class="row g-0 contact-wrapper">
            
            <div class="col-lg-6 contact-content reveal-up">
                <h2 class="contact-main-heading">Contact Us</h2>
                <p class="contact-subtext mb-5">
                    Have any questions or need assistance? Feel free to reach out to us — we're here to help!
                </p>
                
                <div class="info-grid">
                    <div class="info-block">
                        <h6 class="info-label">Phone</h6>
                        <p class="info-detail">03157180041</p>
                    </div>
                    <div class="info-block">
                        <h6 class="info-label">Email</h6>
                        <p class="info-detail">info@gcwhostel.com</p>
                    </div>
                    <div class="info-block">
                        <h6 class="info-label">Location</h6>
                        <p class="info-detail">Madina Masjid Rd, Block B<br>Satellite Town , Gujranwala</p>
                    </div>
                    <div class="info-block">
                        <h6 class="info-label">Working Time</h6>
                        <p class="info-detail">Everyday<br>9am — 6pm</p>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="https://wa.me/03157180041" class="btn-contact-wide">Contact Us</a>
                </div>
            </div>

            <div class="col-lg-6 map-container reveal-zoom">
                <img src="{{ asset('Assert/contact.png') }}" alt="Our Location" class="map-img">
            </div>

        </div>
    </div>
</section>

<script src="{{ asset('js/contact_detail.js') }}"></script>