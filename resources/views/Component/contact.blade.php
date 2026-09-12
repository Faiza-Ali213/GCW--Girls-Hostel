<!-- ========================================== -->
<!-- CONTACT US COMPONENT (FIXED) -->
<!-- ========================================== -->

<style>
    .contact-section {
        padding: 100px 20px;
        background-color: #F9F6F0; /* Aapki site ka light background */
        font-family: 'Poppins', sans-serif;
    }

    .contact-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .contact-card {
        display: flex;
        background-color: #ffffff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(74, 59, 50, 0.1);
        border: 1px solid #EADBC8;
    }

    /* Left Side: Text & Details */
    .contact-info {
        flex: 1;
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .contact-info h2 {
        font-size: 42px;
        color: #4A3B32; /* Dark Brown */
        margin-bottom: 15px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .contact-info .heading-line {
        width: 60px;
        height: 4px;
        background-color: #D4AF37; /* Gold */
        margin-bottom: 25px;
    }

    .contact-info p.intro-text {
        font-size: 16px;
        color: #6B5B52;
        line-height: 1.7;
        margin-bottom: 40px;
    }

    /* Grid for Details */
    .contact-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 40px;
    }

    .detail-item h4 {
        font-size: 18px;
        color: #4A3B32;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .detail-item p {
        font-size: 15px;
        color: #6B5B52;
        line-height: 1.5;
        margin: 0;
    }

    .detail-item a {
        color: #6B5B52;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .detail-item a:hover {
        color: #D4AF37;
    }

    /* Contact Button */
    .contact-btn {
        display: inline-block;
        background-color: #8B5A2B; /* Brown */
        color: #ffffff;
        padding: 15px 40px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-align: center;
        align-self: flex-start;
    }

    .contact-btn:hover {
        background-color: #D4AF37;
        color: #4A3B32;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3);
    }

    /* Right Side: Image */
    .contact-image {
        flex: 1;
        min-height: 500px;
        position: relative;
        overflow: hidden;
    }

    .contact-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.5s ease;
    }

    .contact-image:hover img {
        transform: scale(1.05);
    }

    .contact-image::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, rgba(74, 59, 50, 0.1), rgba(74, 59, 50, 0.3));
        z-index: 1;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .contact-card {
            flex-direction: column-reverse;
        }
        .contact-image {
            min-height: 350px;
        }
        .contact-info {
            padding: 40px 30px;
        }
    }

    @media (max-width: 576px) {
        .contact-info h2 {
            font-size: 32px;
        }
        .contact-details-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        .contact-btn {
            width: 100%;
            text-align: center;
        }
    }
</style>

<section class="contact-section" id="contact-trigger">
    <div class="contact-container">
        <div class="contact-card">
            
            <!-- LEFT SIDE: Information -->
            <div class="contact-info">
                <h2>Contact Us</h2>
                <div class="heading-line"></div>
                
                <p class="intro-text">
                    Have any questions or need assistance? Feel free to reach out 
                    to us — we're here to help you find your perfect home away from home.
                </p>

                <div class="contact-details-grid">
                    <!-- Phone -->
                    <div class="detail-item">
                        <h4>Phone</h4>
                        <p><a href="tel:03157180041">0315 718 0041</a></p>
                    </div>

                    <!-- Email -->
                    <div class="detail-item">
                        <h4>Email</h4>
                        <p><a href="mailto:info@gcwhostel.com">info@gcwhostel.com</a></p>
                    </div>

                    <!-- Location -->
                    <div class="detail-item">
                        <h4>Location</h4>
                        <p>Madina Masjid Rd, Block B<br>Satellite Town, Gujranwala</p>
                    </div>

                    <!-- Working Time -->
                    <div class="detail-item">
                        <h4>Working Time</h4>
                        <p>Everyday<br>9am — 6pm</p>
                    </div>
                </div>

                <!-- Button -->
                <a href="mailto:info@gcwhostel.com" class="contact-btn">Contact Us</a>
            </div>

            <!-- RIGHT SIDE: Image -->
            <div class="contact-image">
                <img src="{{ asset('Assert/pic22.jpeg') }}" alt="Contact GCW Hostel">
            </div>

        </div>
    </div>
</section>