(() => {
    'use strict';

    const header = document.querySelector('[data-header]');
    const toggle = document.querySelector('[data-toggle]');
    const drawer = document.querySelector('[data-drawer]');

    if (header) {
        const onScroll = () => header.classList.toggle('is-stuck', window.scrollY > 8);
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    if (toggle && drawer) {
        const setOpen = (open) => {
            toggle.setAttribute('aria-expanded', String(open));
            drawer.classList.toggle('is-open', open);
        };

        toggle.addEventListener('click', () => {
            setOpen(toggle.getAttribute('aria-expanded') !== 'true');
        });

        drawer.addEventListener('click', (e) => {
            if (e.target.closest('a')) setOpen(false);
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 960) setOpen(false);
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') setOpen(false);
        });
    }

    const reveals = document.querySelectorAll('.reveal');
    if (!reveals.length) return;

    if (!('IntersectionObserver' in window)) {
        reveals.forEach((el) => el.classList.add('is-in'));
        return;
    }

    const io = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-in');
                obs.unobserve(entry.target);
            });
        },
        { rootMargin: '0px 0px -12% 0px', threshold: 0.05 }
    );

    reveals.forEach((el) => io.observe(el));
})();
