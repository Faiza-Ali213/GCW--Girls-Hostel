// ============================================================
// CONTACT PAGE - FAQ ACCORDION
// ============================================================

document.addEventListener('DOMContentLoaded', function () {

    // ============================================================
    // FAQ ACCORDION - FIXED
    // ============================================================

    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');

        if (question) {
            question.addEventListener('click', function () {
                // Close all other items
                faqItems.forEach(otherItem => {
                    if (otherItem !== item && otherItem.classList.contains('active')) {
                        otherItem.classList.remove('active');
                    }
                });

                // Toggle current item
                item.classList.toggle('active');
            });
        }
    });

    // ============================================================
    // FORM SUBMISSION
    // ============================================================

    const form = document.querySelector('.form-wrapper form');

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const btn = this.querySelector('.btn-submit');
            const original = btn.innerHTML;

            btn.innerHTML = 'Sending... <i class="bi bi-hourglass-split"></i>';
            btn.disabled = true;

            setTimeout(() => {
                btn.innerHTML = '✅ Sent Successfully!';
                btn.style.background = '#28a745';
                this.reset();

                setTimeout(() => {
                    btn.innerHTML = original;
                    btn.style.background = '';
                    btn.disabled = false;
                }, 3000);
            }, 2000);
        });
    }

    // ============================================================
    // SCROLL ANIMATIONS
    // ============================================================

    const elements = document.querySelectorAll('.info-item, .faq-item');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    elements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'all 0.6s ease';
        observer.observe(el);
    });

    console.log('✅ Contact page loaded!');
});