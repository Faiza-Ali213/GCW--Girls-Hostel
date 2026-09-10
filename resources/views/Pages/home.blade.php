@extends('Layout.app')

@section('content')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<section class="hero-container">
    <div class="hero-content">
        <h1 class="hero-title">Empowering Your Journey in a Space Built for Her</h1>
        
        <div class="hero-description">
            <p> <p style="text-align: justify;">
  <br>
  Experience peace of mind with 24/7 security in a vibrant environment designed exclusively for girls. Focus on your goals while we take care of the rest—from high-speed internet to nutritious meals. More than just a room—it's a community where friendships grow and dreams take flight.
</p>
        </div>
    </div>

    <div class="hero-image">
        <img src="{{ asset('Assert/pic2.jpeg') }}" alt="Hostel Interior">
    </div>
</section>
@include('Component.spilt')
@include('Component.room')
@include('Component.features')
<section id="faq-section">
    @include('Component.faq')
</section>
<section id="rules-section">
    @include('Component.rules')
</section>
<section id="gallery-section">
    @include('Component.gallery')
</section>
@include('Component.contact_detail')

@endsection