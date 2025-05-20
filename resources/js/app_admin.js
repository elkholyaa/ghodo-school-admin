// Initialize AdminLTE components
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AdminLTE sidebar
    if (window.$ && window.$.fn.overlayScrollbars) {
        $('.main-sidebar .sidebar').overlayScrollbars({
            scrollbars: {
                autoHide: 'leave',
                autoHideDelay: 200
            }
        });
    }

    // Toggle sidebar
    const toggleSidebar = document.querySelector('[data-widget="pushmenu"]');
    if (toggleSidebar) {
        toggleSidebar.addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.toggle('sidebar-collapse');
            if (window.innerWidth <= 768) {
                document.body.classList.toggle('sidebar-open');
            }
        });
    }

    // Add active class to menu items based on current URL
    const currentUrl = window.location.href;
    document.querySelectorAll('.sidebar .nav-link').forEach(function(link) {
        if (currentUrl.includes(link.getAttribute('href'))) {
            link.classList.add('active');
            link.closest('.nav-item').classList.add('menu-open');
            const parentTreeview = link.closest('.nav-treeview');
            if (parentTreeview) {
                parentTreeview.closest('.nav-item').classList.add('menu-open');
            }
        }
    });

    // Initialize dropdown menus
    if (window.$ && window.$.fn.dropdown) {
        $('.dropdown-toggle').dropdown();
    }
    
    // Initialize any AdminLTE plugins
    if (window.$ && window.$.fn.DataTable) {
        $('.datatable').DataTable();
    }

    if (window.$ && window.$.fn.daterangepicker) {
        $('.date-range-picker').daterangepicker();
    }

    // Mobile detection
    const isMobile = window.innerWidth <= 768;
    
    // Don't collapse sidebar on page load for desktop
    if (!isMobile) {
        document.body.classList.remove('sidebar-collapse');
    }
    
    // Responsive behavior for mobile devices
    const handleResize = function() {
        if (window.innerWidth <= 768) {
            // On mobile, keep sidebar collapsed by default
            document.body.classList.remove('sidebar-open');
            if (!document.body.classList.contains('sidebar-collapse')) {
                document.body.classList.add('sidebar-collapse');
            }
        } else {
            // On desktop, expand sidebar by default
            document.body.classList.remove('sidebar-collapse');
        }
    };

    // Run once on load
    handleResize();
    
    // Then on resize
    window.addEventListener('resize', handleResize);
    
    // For mobile devices, close sidebar when clicking outside
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768 && 
            document.body.classList.contains('sidebar-open') && 
            !e.target.closest('.main-sidebar') && 
            !e.target.closest('[data-widget="pushmenu"]')) {
            document.body.classList.remove('sidebar-open');
        }
    });

    // Support for RTL layout
    document.body.classList.add('sidebar-rtl');
});
