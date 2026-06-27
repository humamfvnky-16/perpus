<!doctype html>
<html lang="{{ app()->getLocale() }}" x-data x-init="$store.theme.init()" :class="{ 'dark': $store.theme.dark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%F0%9F%93%9A%3C/text%3E%3C/svg%3E">

    {{-- Font Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome (ala proyek lama) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Tailwind via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui'] },
                    colors: {
                        primary: {
                            50:'#eef7fc', 100:'#d4ecf7', 200:'#a8d9ef', 300:'#7cc6e7', 400:'#4eb1dc',
                            500:'#2196c4', 600:'#0b67a0', 700:'#085380', 800:'#063e60', 900:'#042a40'
                        },
                        accent: { 500:'#f59e0b', 600:'#d97706' }
                    },
                    boxShadow: {
                        soft: '0 2px 8px rgba(11,103,160,0.08)',
                        hover: '0 8px 24px rgba(11,103,160,0.15)',
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer base {
            html { font-family: 'Inter', system-ui, sans-serif; -webkit-font-smoothing: antialiased; }
            body { @apply bg-slate-50 text-slate-800 dark:bg-slate-900 dark:text-slate-100; }
            [x-cloak] { display: none !important; }
        }
        @layer components {
            .btn { @apply inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2; }
            .btn-primary { @apply btn bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500 shadow-soft; }
            .btn-secondary { @apply btn bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-100 dark:border-slate-700 dark:hover:bg-slate-700; }
            .btn-danger { @apply btn bg-red-600 text-white hover:bg-red-700; }
            .btn-accent { @apply btn bg-accent-500 text-white hover:bg-accent-600; }
            .card { @apply rounded-xl bg-white p-6 shadow-soft border border-slate-100 dark:bg-slate-800 dark:border-slate-700; }
            .card-tight { @apply rounded-xl bg-white p-4 shadow-soft border border-slate-100 dark:bg-slate-800 dark:border-slate-700; }
            .form-input, .form-select, .form-textarea {
                @apply block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100;
            }
            .badge { @apply inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold; }
            .badge-green  { @apply badge bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300; }
            .badge-yellow { @apply badge bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300; }
            .badge-red    { @apply badge bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300; }
            .badge-blue   { @apply badge bg-primary-100 text-primary-700 dark:bg-primary-900/40 dark:text-primary-300; }
            .badge-gray   { @apply badge bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300; }
            .table-pretty { @apply min-w-full text-sm; }
            .table-pretty thead { @apply bg-slate-50 dark:bg-slate-700/40; }
            .table-pretty th { @apply px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300; }
            .table-pretty td { @apply px-4 py-3 border-t border-slate-100 dark:border-slate-700; }
            .table-pretty tbody tr { @apply hover:bg-slate-50 dark:hover:bg-slate-700/30 transition; }
            .skeleton { @apply animate-pulse rounded bg-slate-200 dark:bg-slate-700; }
        }
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/[email protected]/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                dark: localStorage.getItem('theme') === 'dark',
                toggle() { this.dark = !this.dark; localStorage.setItem('theme', this.dark ? 'dark' : 'light'); document.documentElement.classList.toggle('dark', this.dark); },
                init() { document.documentElement.classList.toggle('dark', this.dark); },
            });
            Alpine.store('sidebar', {
                open: localStorage.getItem('sidebar') !== 'closed',
                mobileOpen: false,
                toggle() { this.open = !this.open; localStorage.setItem('sidebar', this.open ? 'open' : 'closed'); },
                toggleMobile() { this.mobileOpen = !this.mobileOpen; },
            });
            Alpine.data('toast', () => ({
                items: [],
                push(msg, type='info') {
                    const id = Date.now()+Math.random();
                    const icon = type==='success' ? 'check-circle' : type==='error' ? 'exclamation-circle' : 'info-circle';
                    this.items.push({id, msg, type, icon});
                    setTimeout(() => this.dismiss(id), 4000);
                },
                dismiss(id) { this.items = this.items.filter(t => t.id !== id); },
            }));
        });
    </script>
</head>
<body class="min-h-screen antialiased" x-data="{ ...toast() }">

@auth
<div class="flex">
    @include('partials.sidebar')
    {{-- Mobile sidebar overlay --}}
    <div x-show="$store.sidebar.mobileOpen" x-cloak
         @click="$store.sidebar.mobileOpen = false"
         x-transition.opacity
         class="md:hidden fixed inset-0 bg-black/50 z-30"></div>

    <div class="flex-1 min-h-screen transition-all" :class="$store.sidebar.open ? 'md:ml-64' : 'md:ml-16'">
        @include('partials.topbar')
        <main class="p-4 md:p-6 max-w-screen-2xl mx-auto">
            @include('partials.breadcrumb')
            @if (session('toast'))
                <div x-init="push(@js(session('toast')), 'success')"></div>
            @endif
            @if ($errors->any())
                <div class="card mb-4 border-l-4 border-red-500">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-red-500 mt-0.5"></i>
                        <div>
                            <p class="font-semibold text-red-700 dark:text-red-300">Terjadi kesalahan:</p>
                            <ul class="mt-1 list-disc list-inside text-sm text-red-600 dark:text-red-400">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @yield('content')
        </main>
        @include('partials.footer')
    </div>
</div>
@else
    @yield('content')
@endauth

@include('partials.toast')
</body>
</html>
