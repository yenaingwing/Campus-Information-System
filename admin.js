document.addEventListener('DOMContentLoaded', () => {
  const sidebar = document.getElementById('adminSidebar');
  const overlay = document.getElementById('sidebarOverlay');
  const toggle = document.querySelector('.sidebar-toggle');
  const close = () => { sidebar?.classList.remove('open'); overlay?.classList.remove('show'); };
  toggle?.addEventListener('click', () => { sidebar?.classList.toggle('open'); overlay?.classList.toggle('show'); });
  overlay?.addEventListener('click', close);
});
