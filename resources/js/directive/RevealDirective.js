/**
 * v-reveal — fades an element in once it scrolls into view.
 * Usage: v-reveal or v-reveal="150" (delay in ms).
 */
const observer = typeof window !== 'undefined' && 'IntersectionObserver' in window
    ? new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {threshold: 0.12, rootMargin: '0px 0px -40px 0px'})
    : null;

export const reveal = {
    mounted(el, binding) {
        if (!observer) {
            return;
        }

        el.classList.add('reveal');

        if (binding.value) {
            el.style.transitionDelay = `${binding.value}ms`;
        }

        observer.observe(el);
    },
    unmounted(el) {
        observer?.unobserve(el);
    },
};
