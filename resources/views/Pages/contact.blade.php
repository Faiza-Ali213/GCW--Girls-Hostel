@extends('Layout.app')

@section('content')
<link href="{{ asset('css/contact.css') }}" rel="stylesheet">

<!-- ============================================================ -->
<!-- HERO SECTION                                                  -->
<!-- ============================================================ -->
<section class="contact-hero">
    <div class="hero-overlay"></div>
    <div class="hero-content text-center">
        <h1 class="hero-title">Reach Out To Us</h1>
        <p class="hero-description">
            Have questions about our facilities or room availability?<br>
            Our team is here to help you find your perfect home away from home.
        </p>
        <a href="#contact-details" class="hero-scroll" style="text-decoration: none; color: rgba(255,255,255,0.5); display: inline-block;">
            <span>SCROLL TO DETAILS</span>
            <i class="bi bi-chevron-down" style="display: block; font-size: 24px; margin-top: 8px;"></i>
        </a>
    </div>
</section>

<!-- ============================================================ -->
<!-- CONTACT INFO + FORM                                          -->
<!-- ============================================================ -->
<section class="contact-main" id="contact-details">
    <div class="container">
        <div class="row g-4">
            
            <!-- LEFT: Contact Info -->
            <div class="col-lg-5">
                <div class="contact-info-wrapper">
                    <h2 class="section-title">Get in Touch</h2>
                    <p class="section-subtitle">We'd love to hear from you</p>

                    <div class="contact-info-list">
                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-phone"></i></div>
                            <div>
                                <span class="info-label">Phone</span>
                                <p class="info-value">0315 7180041</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-envelope"></i></div>
                            <div>
                                <span class="info-label">Email</span>
                                <p class="info-value">info@gcwhostel.com</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-geo-alt"></i></div>
                            <div>
                                <span class="info-label">Location</span>
                                <p class="info-value">Madina Masjid Rd, Block B<br>Satellite Town, Gujranwala</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-clock"></i></div>
                            <div>
                                <span class="info-label">Working Time</span>
                                <p class="info-value">Everyday • 9am — 6pm</p>
                            </div>
                        </div>
                    </div>

                    <div class="social-media">
                        <h6>Follow Us</h6>
                        <div class="social-icons">
                            <a href="https://www.facebook.com/" target="_blank" rel="noopener" aria-label="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://www.instagram.com/" target="_blank" rel="noopener" aria-label="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="https://www.youtube.com/" target="_blank" rel="noopener" aria-label="YouTube">
                                <i class="bi bi-youtube"></i>
                            </a>
                            <a href="https://twitter.com/" target="_blank" rel="noopener" aria-label="Twitter">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="https://wa.me/923157180041" target="_blank" rel="noopener" aria-label="WhatsApp">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                        </div>
                    </div>

                    <a href="https://wa.me/923157180041" class="whatsapp-btn">
                        <i class="bi bi-whatsapp"></i> Chat on WhatsApp
                    </a>
                </div>
            </div>

            <!-- RIGHT: Contact Form -->
            <div class="col-lg-7">
                <div class="form-wrapper">
                    <div class="form-header">
                        <h2>Send Us a Message</h2>
                        <p>We'll get back to you within 24 hours</p>
                    </div>

                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Your Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your name" value="{{ old('name') }}" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Your Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="How can we help you?" value="{{ old('subject') }}">
                            @error('subject')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="5" placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-send"></i> Send Message
                        </button>
                    </form>

                    @if(session('success'))
                        <div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- FAQ SECTION                                                   -->
<!-- ============================================================ -->
<section class="faq-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="faq-heading">Frequently Asked Questions</h2>
            <p class="faq-subtext">Find answers to common questions about GCW Hostel</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How do I book a room at GCW Hostel?</span>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>You can book a room by clicking the "Book Now" button on our website, or by calling us directly at <strong>0315 7180041</strong>.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>What amenities are included in the hostel?</span>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>We provide <strong>free WiFi</strong>, <strong>home-style meals (Mess)</strong>, <strong>fully-furnished rooms</strong>, <strong>24/7 security</strong>, and a comfortable study environment.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>What are the check-in and check-out times?</span>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Check-in time is <strong>12:00 PM</strong> and check-out time is <strong>11:00 AM</strong>.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>Is the hostel safe for girls?</span>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Yes! We have <strong>round-the-clock security</strong>, <strong>CCTV surveillance</strong>, and <strong>dedicated female staff</strong>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- GOOGLE MAP                                                    -->
<!-- ============================================================ -->
<section class="map-section">
    <div class="container-fluid p-0">
        <div class="map-wrapper">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d27173.3456789012!2d74.1234567!3d32.1234567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzLCsDA3JzI0LjQiTiA3NMKwMDcnMjQuMCJF!5e0!3m2!1sen!2s!4v1234567890" 
                allowfullscreen 
                loading="lazy">
            </iframe>
            <div class="map-overlay">
                <div class="map-overlay-content">
                    <i class="bi bi-geo-alt-fill"></i>
                    <h4>Find Us Here</h4>
                    <p>Madina Masjid Rd, Block B, Satellite Town, Gujranwala</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('js/contact.js') }}"></script>
@endsection