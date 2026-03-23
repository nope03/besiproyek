/* ═══════════════════════════════════════════════════════
   PT. MITRA ABADI METALINDO — Admin Panel JavaScript
═══════════════════════════════════════════════════════ */

// ── Sidebar toggle ────────────────────────────────────
const sidebar        = document.getElementById('adminSidebar');
const sidebarToggle  = document.getElementById('sidebarToggle');
const sidebarClose   = document.getElementById('sidebarClose');
const sidebarOverlay = document.getElementById('sidebarOverlay');

function openSidebar() {
    if (!sidebar) return;
    sidebar.classList.add('open');
    sidebarOverlay?.classList.add('show');
    document.body.style.overflow = 'hidden';
}
function closeSidebar() {
    if (!sidebar) return;
    sidebar.classList.remove('open');
    sidebarOverlay?.classList.remove('show');
    document.body.style.overflow = '';
}

sidebarToggle?.addEventListener('click', () => {
    sidebar?.classList.contains('open') ? closeSidebar() : openSidebar();
});
sidebarClose?.addEventListener('click', closeSidebar);
sidebarOverlay?.addEventListener('click', closeSidebar);

// Close on escape key
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeSidebar();
});

// ── Topbar date ───────────────────────────────────────
const dateEl = document.getElementById('topbarDate');
if (dateEl) {
    const now = new Date();
    const opts = { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' };
    dateEl.textContent = now.toLocaleDateString('id-ID', opts);
}

// ── Auto-dismiss flash alerts ─────────────────────────
const flash = document.getElementById('flashAlert');
if (flash) {
    setTimeout(() => {
        flash.style.transition = 'opacity 0.5s ease';
        flash.style.opacity = '0';
        setTimeout(() => flash.remove(), 500);
    }, 4000);
}

// ── Confirm delete buttons ────────────────────────────
document.querySelectorAll('[data-confirm]').forEach(el => {
    el.addEventListener('click', e => {
        if (!confirm(el.dataset.confirm)) e.preventDefault();
    });
});

// ── Active nav highlight on load ──────────────────────
const currentPath = window.location.pathname;
document.querySelectorAll('.sidebar-nav__item').forEach(link => {
    const href = link.getAttribute('href');
    if (href && href !== '#' && currentPath.startsWith(href) && href !== '/admin') {
        link.classList.add('active');
    }
});