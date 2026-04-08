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






// roadmap

(function() {
        var throttle = function(type, name, obj) {
            obj = obj || window;
            var running = false;
            var func = function() {
                if (running) {
                    return;
                }
                running = true;
                requestAnimationFrame(function() {
                    obj.dispatchEvent(new CustomEvent(name));
                    running = false;
                });
            };
            obj.addEventListener(type, func);
        };
        throttle("resize", "optimizedResize");
    })();

    var roadmap = (function() {
        var wrapper = document.querySelector('.js-roadmap-timeline');
        var timeframes = document.querySelectorAll('.js-roadmap-timeframe');
        var mediaQuery = window.matchMedia("(min-width: 1201px)");
        var topMaxHeight;
        var bottomMaxHeight;

        handleStyling();
        window.addEventListener("optimizedResize", handleStyling);

        function handleStyling() {
            if (mediaQuery.matches) {
                applyHeights();
                styleWrapper();
            } else {
                clearWrapperStyling();
            }
        }

        function applyHeights() {
            topMaxHeight = getMaxHeight(timeframes, 0);
            bottomMaxHeight = getMaxHeight(timeframes, 1);
        }

        function getMaxHeight(els, start) {
            var maxHeight = 0;
            var i = start;

            for (; i < els.length - 1; i = i + 2) {
                var elHeight = els[i].offsetHeight;
                maxHeight = maxHeight > elHeight ? maxHeight : elHeight;
            }

            return maxHeight;
        }

        function styleWrapper() {
            wrapper.style.paddingBottom = bottomMaxHeight + 'px';
            wrapper.style.paddingTop = topMaxHeight + 'px';
        }

        function clearWrapperStyling() {
            wrapper.style.paddingBottom = '';
            wrapper.style.paddingTop = '';
        }
    })();