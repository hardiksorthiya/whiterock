// Sidebar toggle script
(function () {
    var sidebar = document.getElementById('sidebar');
    var main = document.getElementById('appMain');
    var backdrop = document.getElementById('sidebarBackdrop');
    var toggle = document.getElementById('sidebarToggle');

    function isMobile() {
        return window.matchMedia('(max-width: 991.98px)').matches;
    }

    function openMobileSidebar() {
        sidebar.classList.add('show');
        backdrop.classList.add('show');
        backdrop.setAttribute('aria-hidden', 'false');
        document.body.classList.add('sidebar-open');
    }

    function closeMobileSidebar() {
        sidebar.classList.remove('show');
        backdrop.classList.remove('show');
        backdrop.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('sidebar-open');
    }

    function toggleDesktopSidebar() {
        sidebar.classList.toggle('collapsed');
        main.classList.toggle('sidebar-collapsed');
    }

    function onToggle() {
        if (isMobile()) {
            if (sidebar.classList.contains('show')) {
                closeMobileSidebar();
            } else {
                openMobileSidebar();
            }
        } else {
            toggleDesktopSidebar();
        }
    }

    toggle.addEventListener('click', onToggle);

    backdrop.addEventListener('click', function () {
        if (isMobile()) closeMobileSidebar();
    });

    window.addEventListener('resize', function () {
        if (!isMobile()) closeMobileSidebar();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && isMobile() && sidebar.classList.contains('show')) {
            closeMobileSidebar();
        }
    });
})();