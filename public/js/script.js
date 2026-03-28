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




// Slug from product name (product create/edit only)
(function () {
    var slugInput = document.querySelector('input[name="slug"]');
    var nameInput = document.querySelector('input[name="name"]');
    if (!slugInput || !nameInput) return;

    var isSlugEdited = false;
    slugInput.addEventListener('input', function () {
        isSlugEdited = true;
    });

    nameInput.addEventListener('keyup', function () {
        if (isSlugEdited) return;
        var name = this.value;
        var slug = name
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
        slugInput.value = slug;
    });
})();

// Product list: select all checkboxes on this page
(function () {
    var selectAll = document.getElementById('select-all');
    if (!selectAll) return;
    selectAll.addEventListener('change', function () {
        document.querySelectorAll('.select-item').forEach(function (cb) {
            cb.checked = selectAll.checked;
        });
    });
})();