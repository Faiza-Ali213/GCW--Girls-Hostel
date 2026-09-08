<link href="{{ asset('css/spilt.css') }}" rel="stylesheet">

<style>
/* --- SPLIT SECTION - HERO BUTTON COLORS MATCHING --- */

/* Split Section Background - Hero jaisa */
.split-section {
    background: linear-gradient(135deg, #e8dcc8 0%, #f5efe6 100%) !important;
}

/* Accent Text - Hero Badge Style */
.accent-text {
    background: rgba(180, 130, 80, 0.15) !important;
    color: #8B6B4A !important;
    border: 1px solid rgba(180, 130, 80, 0.2) !important;
}

/* Split Title */
.split-title {
    color: #4A3228 !important;
}

.split-title span {
    color: #8B6B4A !important;
}

/* ======================================== */
/* EXPLORE ALL BUTTON - EXACT HERO BUTTON COLOR */
/* ======================================== */
.btn-all-rooms {
    background: linear-gradient(135deg, #8B6B4A 0%, #A8825A 100%) !important;
    color: #FFFFFF !important;
    border: 2px solid #8B6B4A !important;
    box-shadow: 0 4px 15px rgba(139, 115, 85, 0.25) !important;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
}

.btn-all-rooms:hover {
    background: linear-gradient(135deg, #6B5544 0%, #8B6B4A 100%) !important;
    color: #FFFFFF !important;
    border-color: #6B5544 !important;
    transform: translateX(5px) scale(1.02) !important;
    box-shadow: 0 8px 30px rgba(139, 115, 85, 0.35) !important;
}

/* ======================================== */
/* OUR COMMUNITY BUTTON - EXACT HERO BUTTON COLOR */
/* ======================================== */
.btn-arrow {
    color: #4A3228 !important;
    text-decoration: none !important;
    font-weight: 700 !important;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
}

.btn-arrow:hover {
    color: #8B6B4A !important;
}

/* Arrow Circle - Hero Button Colors */
.arrow-circle {
    background: linear-gradient(135deg, #8B6B4A 0%, #A8825A 100%) !important;
    color: #FFFFFF !important;
    border: 2px solid #8B6B4A !important;
    box-shadow: 0 4px 15px rgba(139, 115, 85, 0.2) !important;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
}

.btn-arrow:hover .arrow-circle {
    background: linear-gradient(135deg, #6B5544 0%, #8B6B4A 100%) !important;
    border-color: #6B5544 !important;
    transform: rotate(45deg) scale(1.05) !important;
    box-shadow: 0 8px 25px rgba(139, 115, 85, 0.3) !important;
}

/* Content Text */
.content-text p {
    border-left: 4px solid #C49A6C !important;
    color: #6B5544 !important;
}

/* Image Borders */
.img-container {
    border: 2px solid #C49A6C !important;
    box-shadow: 0 15px 40px rgba(139, 115, 85, 0.15) !important;
}

.img-container:hover {
    border-color: #8B6B4A !important;
    box-shadow: 0 20px 60px rgba(139, 115, 85, 0.2) !important;
}

.split-img-small {
    border: 2px solid #C49A6C !important;
    box-shadow: 0 15px 40px rgba(139, 115, 85, 0.12) !important;
}

.split-img-small:hover {
    border-color: #8B6B4A !important;
    box-shadow: 0 25px 60px rgba(139, 115, 85, 0.18) !important;
}
</style>

<section class="split-section" id="split-section-trigger">
    <div class="container">
        <div class="row mb-4 align-items-end reveal-fade-up">
            <div class="col-md-8">
                <span class="accent-text d-block mb-2">Comfort Meets Convenience</span>
                <h2 class="split-title mb-0">Designed for the <span>Modern Student</span> & Professional</h2>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="#" class="btn-all-rooms">Explore All <span class="arrow-icon">↗</span></a>
            </div>
        </div>

        <div class="row align-items-start">
            <div class="col-md-6 mb-5 mb-md-0 reveal-left">
                <div class="img-container">
                    <img src="{{ asset('Assert/pic11.jpeg') }}" 
                         alt="Hostel Common Area" class="split-img-tall">
                </div>
            </div>

            <div class="col-md-6 ps-md-5 reveal-right">
                <div class="mb-4">
                    <img src="{{ asset('Assert/pic3.jpeg') }}" 
                         alt="Study Zone" class="split-img-small">
                </div>

                <div class="content-text">
                    <p style="line-height: 1.6; color: #6B5544; opacity: 0.9;" class="mb-4">
                        At GCW Hostel, we understand that a hostel is more than just a bed. It is a place where friendships are forged and futures are built...
                        Govt Graduate College for Women Satellite town Gujranwala, Hostel is located in the heart of Satellite Town, Gujranwala — A perfect living space for women working of government sector and our own students! Enjoy hygienic food, lush green lawns, 24/7 security, a fully equipped dining area, and furnished rooms — all at an economical cost. With every facility just a few minutes' walk away, comfort and convenience are guaranteed. Come and visit us!
                    </p>
                    <a href="/about" class="btn-arrow">
                        Our Community <span class="arrow-circle">↗</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('js/spilt.js') }}"></script>