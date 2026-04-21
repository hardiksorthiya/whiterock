/**
 * Fluid smooth scrolling (Lenis). Feels like slow, continuous motion—especially on wheel.
 * Disabled when prefers-reduced-motion is set.
 */
function initLenisSmoothScroll() {
    if (typeof Lenis === "undefined") {
        return;
    }

    const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    const lenis = new Lenis({
        duration: 1.45,
        easing: (t) => (t === 1 ? 1 : 1 - Math.pow(2, -10 * t)),
        smoothWheel: true,
        wheelMultiplier: 0.78,
        touchMultiplier: 1.08,
        syncTouch: false,
    });

    window.__lenis = lenis;

    function raf(time) {
        lenis.raf(time);
        requestAnimationFrame(raf);
    }

    requestAnimationFrame(raf);
}

function initMobileMenu() {
    const toggleBtn = document.getElementById("menuToggle");
    const mobileMenu = document.getElementById("mobileMenu");
    const overlay = document.getElementById("menuOverlay");

    if (!toggleBtn || !mobileMenu || !overlay) {
        return;
    }

    function closeMenu() {
        toggleBtn.classList.remove("active");
        mobileMenu.classList.remove("active");
        overlay.classList.remove("active");
        document.body.classList.remove("menu-open");
        toggleBtn.setAttribute("aria-expanded", "false");
        toggleBtn.setAttribute("aria-label", "Open menu");
    }

    function openMenu() {
        toggleBtn.classList.add("active");
        mobileMenu.classList.add("active");
        overlay.classList.add("active");
        document.body.classList.add("menu-open");
        toggleBtn.setAttribute("aria-expanded", "true");
        toggleBtn.setAttribute("aria-label", "Close menu");
    }

    toggleBtn.addEventListener("click", () => {
        if (mobileMenu.classList.contains("active")) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    overlay.addEventListener("click", closeMenu);

    mobileMenu.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", closeMenu);
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            closeMenu();
        }
    });
}

function initHeaderOnScroll() {
    const header = document.querySelector(".site-header");
    if (!header) return;

    const setScrolledState = () => {
        const shouldBeScrolled = window.scrollY > 30;
        header.classList.toggle("is-scrolled", shouldBeScrolled);
    };

    // Run once on load
    setScrolledState();

    let lastScrollY = window.scrollY;
    let ticking = false;
    const onScroll = () => {
        if (ticking) return;
        ticking = true;
        window.requestAnimationFrame(() => {
            const currentY = window.scrollY;
            const isScrollingDown = currentY > lastScrollY;
            if (isScrollingDown && currentY > 50) {
                header.classList.add("is-hidden");
            } else {
                header.classList.remove("is-hidden");
            }

            setScrolledState();
            lastScrollY = currentY;
            ticking = false;
        });
    };

    window.addEventListener("scroll", onScroll, { passive: true });
}

function initScrollReveal() {
    const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    const allTargets = document.querySelectorAll(
        ".content section, .site-footer, .product-section, .why-modern, .sorath-services"
    );
    const targets = Array.from(allTargets).filter((el) => !el.classList.contains("home-applications"));

    if (targets.length === 0) return;

    targets.forEach((el) => el.classList.add("section-reveal"));

    if (prefersReducedMotion || !("IntersectionObserver" in window)) {
        targets.forEach((el) => el.classList.add("is-visible"));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add("is-visible");
                observer.unobserve(entry.target);
            });
        },
        { threshold: 0.12, rootMargin: "0px 0px -10% 0px" }
    );

    targets.forEach((el, i) => {
        el.style.setProperty("--reveal-delay", `${Math.min(i * 40, 220)}ms`);
        observer.observe(el);
    });
}

/**
 * Slow parallax on inner-page breadcrumb heroes: background drifts gently while scrolling
 * (feels “heavier” / slower than the page — reverse is smooth when scrolling back up).
 */
function initBreadcrumbParallax() {
    const section = document.querySelector(".breadcrumb-section");
    const bg = document.querySelector(".breadcrumb-section__bg");
    if (!section || !bg) return;

    const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    if (prefersReducedMotion) return;

    const slowFactor = 0.14;
    const inner = section.querySelector(".breadcrumb-section__inner");
    const contentShift = 0.05;

    let ticking = false;
    const update = () => {
        const rect = section.getBoundingClientRect();
        const scrolled = -rect.top;
        const yBg = scrolled * slowFactor;
        const maxBg = section.offsetHeight * 0.14;
        const clampedBg = Math.max(-maxBg, Math.min(maxBg, yBg));

        bg.style.transform = `translate3d(0, ${clampedBg}px, 0) scale(1.1)`;

        if (inner) {
            const yIn = Math.min(Math.max(scrolled * contentShift, 0), 48);
            inner.style.transform = `translate3d(0, ${yIn}px, 0)`;
        }
        ticking = false;
    };

    const onScroll = () => {
        if (ticking) return;
        ticking = true;
        window.requestAnimationFrame(update);
    };

    window.addEventListener("scroll", onScroll, { passive: true });
    window.addEventListener("resize", onScroll, { passive: true });
    onScroll();
}

function initCounters() {
    const counters = document.querySelectorAll(".sorath-counter[data-count]");
    if (counters.length === 0) return;

    const animateCounter = (counter) => {
        if (counter.dataset.animated === "1") return;

        const target = parseInt(counter.getAttribute("data-count") || "0", 10);
        if (!Number.isFinite(target) || target < 0) return;

        counter.dataset.animated = "1";
        counter.textContent = "0";

        const duration = 1400;
        const start = performance.now();

        const step = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            counter.textContent = String(Math.round(target * eased));
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                counter.textContent = String(target);
            }
        };

        requestAnimationFrame(step);
    };

    const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    if (prefersReducedMotion || !("IntersectionObserver" in window)) {
        counters.forEach(animateCounter);
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            });
        },
        { threshold: 0.3, rootMargin: "0px 0px -8% 0px" }
    );

    counters.forEach((counter) => observer.observe(counter));
}

function initAboutRoadmapSwiper() {
    const el = document.querySelector(".js-about-road-swiper");
    if (!el || typeof Swiper === "undefined") return;

    const roadmapSwiperConfig = {
        slidesPerView: 6,
        slidesPerGroup: 1,
        spaceBetween: 16,
        speed: 650,
        loop: true,
        allowTouchMove: true,
        grabCursor: true,
        autoplay: {
            delay: 10000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        navigation: {
            nextEl: ".js-about-road-next",
            prevEl: ".js-about-road-prev",
        },
        pagination: {
            el: ".js-about-road-pagination",
            clickable: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 2,
                spaceBetween: 8,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 12,
            },
            1200: {
                slidesPerView: 6,
                spaceBetween: 16,
            },
        },
    };

    // Expose for quick tuning in browser console.
    window.aboutRoadmapSwiperConfig = roadmapSwiperConfig;
    window.aboutRoadmapSwiper = new Swiper(el, roadmapSwiperConfig);
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initLenisSmoothScroll);
} else {
    initLenisSmoothScroll();
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initMobileMenu);
} else {
    initMobileMenu();
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initHeaderOnScroll);
} else {
    initHeaderOnScroll();
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initScrollReveal);
} else {
    initScrollReveal();
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initBreadcrumbParallax);
} else {
    initBreadcrumbParallax();
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initCounters);
} else {
    initCounters();
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initAboutRoadmapSwiper);
} else {
    initAboutRoadmapSwiper();
}


