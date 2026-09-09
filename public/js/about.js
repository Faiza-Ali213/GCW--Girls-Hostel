document.addEventListener('DOMContentLoaded', function () {
    const textElement = document.getElementById('typewriter-text');
    const content = textElement.innerText.trim();
    const words = content.split(/\s+/); // Split by any whitespace
    textElement.innerHTML = ''; // Clear original text

    // Wrap each word in a span
    words.forEach(word => {
        const span = document.createElement('span');
        span.classList.add('word-span');
        span.innerText = word;
        textElement.appendChild(span);

        // Add a text node for the space so it doesn't get swallowed
        textElement.appendChild(document.createTextNode(' '));
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Animate Heading and Image
                entry.target.querySelectorAll('.reveal-down, .reveal-right-slide').forEach(el => {
                    el.classList.add('is-active');
                });

                // Animate Word by Word
                const spans = textElement.querySelectorAll('.word-span');
                spans.forEach((span, index) => {
                    setTimeout(() => {
                        span.style.opacity = '1';
                    }, index * 100); // Adjusted timing for smoother flow
                });

                // Once triggered, stop observing
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    observer.observe(document.querySelector('#about-trigger'));
});