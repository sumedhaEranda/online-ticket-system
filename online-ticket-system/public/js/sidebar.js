/* robust sidebar toggle — runs after DOM, preserves state in localStorage */
(function () {
  function ready(fn) {
    if (document.readyState !== 'loading') {
      fn();
    } else {
      document.addEventListener('DOMContentLoaded', fn);
    }
  }

  ready(function () {
    var sidebar = document.getElementById('appSidebar');
    var btn = document.getElementById('toggleSidebar');
    if (!sidebar || !btn) return;
    var icon = btn.querySelector('i');

    // initialize from storage
    var collapsed = localStorage.getItem('sidebar-collapsed') === '1';
    if (collapsed) {
      sidebar.classList.add('collapsed');
      if (icon) { icon.classList.remove('bi-chevron-left'); icon.classList.add('bi-chevron-right'); }
    }

    btn.addEventListener('click', function (e) {
      e.preventDefault();
      var isCollapsed = sidebar.classList.toggle('collapsed');
      if (icon) {
        icon.classList.toggle('bi-chevron-left', !isCollapsed);
        icon.classList.toggle('bi-chevron-right', isCollapsed);
      }
      localStorage.setItem('sidebar-collapsed', isCollapsed ? '1' : '0');
    });
  });
})();