<link rel="stylesheet" href="{{ asset('css/faq.css') }}">

<section class="faq-modern-section py-5" id="faq-section">
    <div class="container">
        <div class="text-center mb-5">
            <span class="faq-pre-title">Hostel Life Insights</span>
            <h2 class="faq-main-title">Frequently Asked Questions</h2>
            <div class="title-accent-bar"></div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="faq-container">
                    @php
                        $faqs = [
                            [
                                'q' => 'What is the hostel fee per year?',
                                'a' => 'The annual hostel fee is PKR 30,000. This covers room accommodation and basic hostel facilities. Payments can be made on a yearly basis at the clerk office.'
                            ],
                            [
                                'q' => 'Is the mess fee included in the hostel fee?',
                                'a' => 'No, the mess fee is not included in the hostel fee. The PKR 30,000 annual fee only covers accommodation. Mess charges (meals) are billed separately based on the monthly mess menu and consumption.'
                            ],
                            [
                                'q' => 'What are the visiting hours for parents?',
                                'a' => 'Parents and authorized guardians can visit on Sundays between 9:00 AM and 5:00 PM. Weekday visits require prior approval from the Warden office.'
                            ],
                            [
                                'q' => 'What security measures are in place at the hostel?',
                                'a' => 'Security is our top priority. We have 24/7 CCTV surveillance, professional on-site guards, and a strict entry/exit register for all visitors. Only authorized guardians are allowed inside the premises.'
                            ],
                        ];
                    @endphp

                    @foreach($faqs as $index => $item)
                    <div class="faq-card shadow-sm" data-index="{{ $index }}">
                        <div class="faq-header" onclick="toggleFaq({{ $index }})">
                            <span class="faq-question">{{ $item['q'] }}</span>
                            <div class="faq-icon-wrapper">
                                <span class="faq-icon">+</span>
                            </div>
                        </div>
                        <div class="faq-body" id="faq-body-{{ $index }}">
                            <div class="faq-content">
                                <p class="mb-0">{{ $item['a'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('js/faq.js') }}"></script>