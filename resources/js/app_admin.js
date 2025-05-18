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
        toggleSidebar.addEventListener('click', function() {
            document.body.classList.toggle('sidebar-collapse');
        });
    }

    // Add active class to menu items based on current URL
    const currentUrl = window.location.href;
    document.querySelectorAll('.sidebar .nav-link').forEach(function(link) {
        if (currentUrl.includes(link.getAttribute('href'))) {
            link.classList.add('active');
            link.closest('.nav-item').classList.add('menu-open');
            link.closest('.nav-treeview').closest('.nav-item').classList.add('menu-open');
        }
    });

    // Initialize any AdminLTE plugins
    if (window.$.fn.DataTable) {
        $('.datatable').DataTable();
    }

    if (window.$.fn.daterangepicker) {
        $('.date-range-picker').daterangepicker();
    }

    // Support for RTL layout
    document.body.classList.add('sidebar-rtl');
});
