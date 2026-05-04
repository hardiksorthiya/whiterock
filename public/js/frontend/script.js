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
        speed: 1000,
        loop: true,
        allowTouchMove: true,
        grabCursor: true,
        autoplay: {
            delay: 1000,
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


/**
 * Home: Product Applications (continuous marquee + modal gallery)
 */
function initApplicationsMarquee() {
    const rails = document.querySelectorAll(".home-applications__rail");
    if (!rails || rails.length === 0) return;

    function applyDistance() {
        rails.forEach(function (rail) {
            if (!rail) return;
            const fullWidth = rail.scrollWidth || 0;
            const half = fullWidth / 2;
            if (half > 0) {
                rail.style.setProperty("--marquee-distance", half + "px");
            }
        });
    }

    applyDistance();
    window.addEventListener(
        "resize",
        function () {
            applyDistance();
        },
        { passive: true }
    );
}

function initApplicationsModals() {
    const modals = document.querySelectorAll(".home-applications__modal");
    if (!modals || modals.length === 0) return;

    modals.forEach(function (modal) {
        if (!modal) return;

        const modalId = modal.getAttribute("id") || "";
        const match = modalId.match(/^applicationImagesModal-(.+)$/);
        if (!match) return;

        const suffix = match[1];
        const dataEl = document.getElementById("applicationCardMap-" + suffix);
        if (!dataEl) return;

        let applications = null;
        try {
            applications = JSON.parse(dataEl.textContent || dataEl.innerHTML);
        } catch (e) {
            return;
        }

        const title = modal.querySelector("#applicationImagesModalLabel-" + suffix);
        const body = modal.querySelector("#applicationImagesModalBody-" + suffix);
        if (!title || !body) return;

        modal.addEventListener("show.bs.modal", function (event) {
            const trigger = event.relatedTarget;
            if (!trigger) return;

            const applicationId = String(trigger.getAttribute("data-application-id") || "");
            const app = applications?.[applicationId];
            if (!app || !body || !title) return;

            title.textContent = app.name + " - Gallery";
            const images = Array.isArray(app.images) ? app.images : [];

            if (images.length === 0) {
                body.innerHTML =
                    '<div class="text-center text-muted py-4">No images in this category yet.</div>';
                return;
            }

            const viewerMainId = "applicationViewerMainImage-" + suffix;
            const viewerThumbsId = "applicationViewerThumbs-" + suffix;

            body.innerHTML = `
                <div class="home-applications__viewer">
                    <button type="button" class="home-applications__viewer-nav home-applications__viewer-prev" aria-label="Previous image">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <img src="${images[0]}" alt="${app.name} image 1" class="home-applications__modal-main-img" id="${viewerMainId}">
                    <button type="button" class="home-applications__viewer-nav home-applications__viewer-next" aria-label="Next image">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
                <div class="home-applications__modal-thumbs mt-3" id="${viewerThumbsId}">
                    ${images
                        .map(function (img, idx) {
                            const isActive = idx === 0 ? "is-active" : "";
                            return `
                                <button type="button" class="home-applications__thumb-btn ${isActive}" data-slide-to="${idx}" aria-label="Show image ${idx + 1}">
                                    <img src="${img}" alt="${app.name} thumbnail ${idx + 1}" class="home-applications__thumb-img">
                                </button>
                            `;
                        })
                        .join("")}
                </div>
            `;

            const mainImage = body.querySelector("#" + viewerMainId);
            const thumbsWrap = body.querySelector("#" + viewerThumbsId);
            const prevBtn = body.querySelector(".home-applications__viewer-prev");
            const nextBtn = body.querySelector(".home-applications__viewer-next");
            if (!mainImage || !thumbsWrap || !prevBtn || !nextBtn) return;

            const thumbButtons = Array.from(
                thumbsWrap.querySelectorAll(".home-applications__thumb-btn")
            );

            let activeIndex = 0;
            let touchStartX = 0;

            const updateViewer = function (index) {
                if (!images.length) return;
                activeIndex = (index + images.length) % images.length;
                mainImage.src = images[activeIndex];
                mainImage.alt = app.name + " image " + (activeIndex + 1);

                thumbButtons.forEach(function (btn, idx) {
                    btn.classList.toggle("is-active", idx === activeIndex);
                });
            };

            thumbButtons.forEach(function (btn, idx) {
                btn.addEventListener("click", function () {
                    updateViewer(idx);
                });
            });

            prevBtn.addEventListener("click", function () {
                updateViewer(activeIndex - 1);
            });
            nextBtn.addEventListener("click", function () {
                updateViewer(activeIndex + 1);
            });

            mainImage.addEventListener(
                "touchstart",
                function (e) {
                    touchStartX = e.changedTouches[0]?.clientX ?? 0;
                },
                { passive: true }
            );

            mainImage.addEventListener(
                "touchend",
                function (e) {
                    const touchEndX = e.changedTouches[0]?.clientX ?? 0;
                    const deltaX = touchEndX - touchStartX;
                    if (Math.abs(deltaX) < 24) return;
                    if (deltaX > 0) {
                        updateViewer(activeIndex - 1);
                    } else {
                        updateViewer(activeIndex + 1);
                    }
                },
                { passive: true }
            );
        });
    });
}

function initApplications() {
    initApplicationsMarquee();
    initApplicationsModals();
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initApplications);
} else {
    initApplications();
}

/**
 * Gallery category slider (marquee + same lightbox pattern as applications)
 */
function initGalleryCategoryModals() {
    const modals = document.querySelectorAll('[id^="gcGalleryModal-"]');
    if (!modals || modals.length === 0) return;

    modals.forEach(function (modal) {
        if (!modal) return;

        const modalId = modal.getAttribute("id") || "";
        const match = modalId.match(/^gcGalleryModal-(.+)$/);
        if (!match) return;

        const suffix = match[1];
        const dataEl = document.getElementById("gcGalleryPayload-" + suffix);
        if (!dataEl) return;

        let payload = null;
        try {
            payload = JSON.parse(dataEl.textContent || dataEl.innerHTML);
        } catch (e) {
            return;
        }

        const title = modal.querySelector("#gcGalleryModalLabel-" + suffix);
        const body = modal.querySelector("#gcGalleryModalBody-" + suffix);
        if (!title || !body) return;

        modal.addEventListener("show.bs.modal", function (event) {
            const trigger = event.relatedTarget;
            if (!trigger) return;

            const startRaw = trigger.getAttribute("data-gc-index");
            let startIndex = parseInt(String(startRaw || "0"), 10);
            if (Number.isNaN(startIndex)) startIndex = 0;

            const albumTitle = typeof payload.title === "string" ? payload.title : "Gallery";
            const images = Array.isArray(payload.images) ? payload.images : [];

            title.textContent = albumTitle + " — Gallery";

            if (images.length === 0) {
                body.innerHTML =
                    '<div class="text-center text-muted py-4">No images in this gallery yet.</div>';
                return;
            }

            startIndex = Math.max(0, Math.min(startIndex, images.length - 1));

            const viewerMainId = "gcViewerMainImage-" + suffix;
            const viewerThumbsId = "gcViewerThumbs-" + suffix;

            body.innerHTML = `
                <div class="home-applications__viewer">
                    <button type="button" class="home-applications__viewer-nav home-applications__viewer-prev" aria-label="Previous image">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <img src="${images[startIndex]}" alt="${albumTitle} image ${startIndex + 1}" class="home-applications__modal-main-img" id="${viewerMainId}">
                    <button type="button" class="home-applications__viewer-nav home-applications__viewer-next" aria-label="Next image">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
                <div class="home-applications__modal-thumbs mt-3" id="${viewerThumbsId}">
                    ${images
                        .map(function (img, idx) {
                            const isActive = idx === startIndex ? "is-active" : "";
                            return `
                                <button type="button" class="home-applications__thumb-btn ${isActive}" data-slide-to="${idx}" aria-label="Show image ${idx + 1}">
                                    <img src="${img}" alt="${albumTitle} thumbnail ${idx + 1}" class="home-applications__thumb-img">
                                </button>
                            `;
                        })
                        .join("")}
                </div>
            `;

            const mainImage = body.querySelector("#" + viewerMainId);
            const thumbsWrap = body.querySelector("#" + viewerThumbsId);
            const prevBtn = body.querySelector(".home-applications__viewer-prev");
            const nextBtn = body.querySelector(".home-applications__viewer-next");
            if (!mainImage || !thumbsWrap || !prevBtn || !nextBtn) return;

            const thumbButtons = Array.from(
                thumbsWrap.querySelectorAll(".home-applications__thumb-btn")
            );

            let activeIndex = startIndex;
            let touchStartX = 0;

            const updateViewer = function (index) {
                if (!images.length) return;
                activeIndex = (index + images.length) % images.length;
                mainImage.src = images[activeIndex];
                mainImage.alt = albumTitle + " image " + (activeIndex + 1);

                thumbButtons.forEach(function (btn, idx) {
                    btn.classList.toggle("is-active", idx === activeIndex);
                });
            };

            thumbButtons.forEach(function (btn, idx) {
                btn.addEventListener("click", function () {
                    updateViewer(idx);
                });
            });

            prevBtn.addEventListener("click", function () {
                updateViewer(activeIndex - 1);
            });
            nextBtn.addEventListener("click", function () {
                updateViewer(activeIndex + 1);
            });

            mainImage.addEventListener(
                "touchstart",
                function (e) {
                    touchStartX = e.changedTouches[0]?.clientX ?? 0;
                },
                { passive: true }
            );

            mainImage.addEventListener(
                "touchend",
                function (e) {
                    const touchEndX = e.changedTouches[0]?.clientX ?? 0;
                    const deltaX = touchEndX - touchStartX;
                    if (Math.abs(deltaX) < 24) return;
                    if (deltaX > 0) {
                        updateViewer(activeIndex - 1);
                    } else {
                        updateViewer(activeIndex + 1);
                    }
                },
                { passive: true }
            );
        });
    });
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initGalleryCategoryModals);
} else {
    initGalleryCategoryModals();
}


