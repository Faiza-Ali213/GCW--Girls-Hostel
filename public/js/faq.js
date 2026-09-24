// ============================================
// FAQ TOGGLE FUNCTION
// ============================================
function toggleFaq(index) {
    const card = document.querySelector(`.faq-card[data-index="${index}"]`);
    const body = document.getElementById(`faq-body-${index}`);
    const allCards = document.querySelectorAll('.faq-card');
    const allBodies = document.querySelectorAll('.faq-body');

    if (!card || !body) return;

    // Close all other FAQs
    allCards.forEach((c, i) => {
        if (i !== index) {
            c.classList.remove('active');
            if (allBodies[i]) allBodies[i].style.maxHeight = null;
        }
    });

    // Toggle current card
    if (card.classList.contains('active')) {
        card.classList.remove('active');
        body.style.maxHeight = null;
    } else {
        card.classList.add('active');
        // scrollHeight dynamically calculates the text height
        body.style.maxHeight = body.scrollHeight + "px";
    }
}

// ============================================
// REVEAL-UP ANIMATION (SAFE VERSION)
// ============================================
// Ye animation cards ko hide karti hai, lekin fallback ke saath
// taake agar observer fail ho jaye toh cards 1.5s baad visible ho jayein

document.addEventListener('DOMContentLoaded', () => {
    const revealElements = document.querySelectorAll('.reveal-up');

    // Agar koi reveal-up element nahi hai toh kuch nahi karna
    if (revealElements.length === 0) return;

    // Observer for smooth reveal on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = "1";
                    entry.target.style.transform = "translateY(0)";
                }, index * 100);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    revealElements.forEach(el => {
        el.style.opacity = "0";
        el.style.transform = "translateY(30px)";
        el.style.transition = "all 0.6s ease-out";
        observer.observe(el);
    });

    // ✅ FALLBACK: Agar 1.5 seconds ke andar observer trigger na ho
    // toh sab elements ko forcefully visible kar do
    setTimeout(() => {
        revealElements.forEach(el => {
            el.style.opacity = "1";
            el.style.transform = "translateY(0)";
        });
    }, 1500);
});