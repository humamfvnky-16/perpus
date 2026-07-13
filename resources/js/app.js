import './bootstrap';
import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.Chart = Chart;

document.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        dark: localStorage.getItem('theme') === 'dark',
        toggle() {
            this.dark = !this.dark;
            localStorage.setItem('theme', this.dark ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', this.dark);
        },
        init() { document.documentElement.classList.toggle('dark', this.dark); },
    });

    Alpine.store('sidebar', {
        open: localStorage.getItem('sidebar') !== 'closed',
        mobileOpen: false,
        toggle() {
            this.open = !this.open;
            localStorage.setItem('sidebar', this.open ? 'open' : 'closed');
        },
        toggleMobile() { this.mobileOpen = !this.mobileOpen; },
    });

    Alpine.data('toast', () => ({
        items: [],
        push(msg, type = 'info') {
            const id = Date.now() + Math.random();
            const icon = type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle';
            this.items.push({ id, msg, type, icon });
            setTimeout(() => this.dismiss(id), 4000);
        },
        dismiss(id) { this.items = this.items.filter(t => t.id !== id); },
    }));
});

Alpine.start();
