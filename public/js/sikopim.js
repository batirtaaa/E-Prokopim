// SIKOPIM JavaScript
document.addEventListener('DOMContentLoaded', function () {

    // ─────────────────────────────
    // Password Toggle
    // ─────────────────────────────
    document.querySelectorAll('[data-toggle-password]').forEach(btn => {
        btn.addEventListener('click', function () {
            const target = document.querySelector(this.dataset.togglePassword);
            if (!target) return;
            const isText = target.type === 'text';
            target.type = isText ? 'password' : 'text';
            this.innerHTML = isText
                ? `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>`
                : `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>`;
        });
    });

    // ─────────────────────────────
    // Modal Controls
    // ─────────────────────────────
    document.querySelectorAll('[data-modal-open]').forEach(btn => {
        btn.addEventListener('click', function () {
            const modal = document.querySelector(this.dataset.modalOpen);
            if (modal) modal.classList.add('active');
        });
    });

    document.querySelectorAll('[data-modal-close], .modal-overlay').forEach(el => {
        el.addEventListener('click', function (e) {
            if (e.target === this || this.hasAttribute('data-modal-close')) {
                const overlay = this.closest('.modal-overlay') || document.querySelector(this.dataset.modalClose);
                if (overlay) overlay.classList.remove('active');
            }
        });
    });

    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', e => e.stopPropagation());
    });

    // ─────────────────────────────
    // Settings Tabs
    // ─────────────────────────────
    const settingsTabItems = document.querySelectorAll('.settings-tab-item[data-tab]');
    if (settingsTabItems.length > 0) {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab') || settingsTabItems[0]?.dataset.tab;

        settingsTabItems.forEach(item => {
            if (item.dataset.tab === activeTab) {
                item.classList.add('active');
            }

            item.addEventListener('click', function () {
                settingsTabItems.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                document.querySelectorAll('.settings-panel').forEach(p => p.classList.remove('active'));
                const panel = document.querySelector('#panel-' + this.dataset.tab);
                if (panel) panel.classList.add('active');

                // Update URL
                const url = new URL(window.location);
                url.searchParams.set('tab', this.dataset.tab);
                history.pushState({}, '', url);
            });
        });

        // Show active panel
        const activePanel = document.querySelector('#panel-' + activeTab);
        if (activePanel) activePanel.classList.add('active');
    }

    // ─────────────────────────────
    // Dropdown Menus
    // ─────────────────────────────
    document.querySelectorAll('[data-dropdown]').forEach(trigger => {
        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            const menu = document.querySelector(this.dataset.dropdown);
            if (!menu) return;
            const isOpen = menu.classList.contains('show');
            // Close all
            document.querySelectorAll('.dropdown-menu.show').forEach(m => m.classList.remove('show'));
            if (!isOpen) menu.classList.add('show');
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown-menu.show').forEach(m => m.classList.remove('show'));
    });

    // ─────────────────────────────
    // Auto-dismiss Toasts/Alerts
    // ─────────────────────────────
    document.querySelectorAll('.toast, .alert[data-auto-dismiss]').forEach(el => {
        setTimeout(() => {
            el.style.opacity = '0';
            el.style.transition = 'opacity 0.5s ease';
            setTimeout(() => el.remove(), 500);
        }, 4000);
    });

    // ─────────────────────────────
    // Form Delete Confirmation
    // ─────────────────────────────
    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', function (e) {
            if (!confirm(this.dataset.confirm || 'Apakah Anda yakin?')) {
                e.preventDefault();
            }
        });
    });

    // ─────────────────────────────
    // Dynamic Select (Penugasan filter)
    // ─────────────────────────────
    const roleFilter = document.getElementById('role-filter');
    if (roleFilter) {
        roleFilter.addEventListener('change', function () {
            const form = this.closest('form');
            if (form) form.submit();
        });
    }
});
