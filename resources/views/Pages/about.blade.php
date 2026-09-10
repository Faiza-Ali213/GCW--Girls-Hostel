@extends('Layout.app')

@section('content')
<link href="{{ asset('css/about.css') }}" rel="stylesheet">

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
                    <img src="{{ asset('Assert/about_icon.png') }}" alt="Our Team">
                </div>
            </div>

        </div>
    </div>
</section>

<script src="{{ asset('js/about.js') }}"></script>

@include('Component.History')
@include('component.gallery')
@include('Component.faq')

@endsection