<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>" x-data x-init="$store.theme.init()" :class="{ 'dark': $store.theme.dark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%F0%9F%93%9A%3C/text%3E%3C/svg%3E">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: {
                primary: { 50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a' }
            } } }
        }
    </script>
    <style type="text/tailwindcss">
        @layer components {
            .btn { @apply inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium transition focus:outline-none focus:ring-2 focus:ring-offset-2; }
            .btn-primary { @apply btn bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500; }
            .btn-secondary { @apply btn bg-gray-200 text-gray-900 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600; }
            .btn-danger { @apply btn bg-red-600 text-white hover:bg-red-700; }
            .card { @apply rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800; }
            .form-input { @apply block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100; }
            .badge { @apply inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium; }
            .badge-green { @apply badge bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200; }
            .badge-yellow { @apply badge bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200; }
            .badge-red { @apply badge bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200; }
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
                toggle() { this.open = !this.open; localStorage.setItem('sidebar', this.open ? 'open' : 'closed'); },
            });
            Alpine.data('toast', () => ({
                items: [],
                push(msg, type='info') { const id = Date.now()+Math.random(); this.items.push({id,msg,type}); setTimeout(() => this.dismiss(id), 4000); },
                dismiss(id) { this.items = this.items.filter(t => t.id !== id); },
            }));
        });
    </script>
</head>
<body class="min-h-screen antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100" x-data="{ ...toast() }">

<?php if(auth()->guard()->check()): ?>
<div class="flex">
    <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="flex-1 min-h-screen transition-all" :class="$store.sidebar.open ? 'md:ml-64' : 'md:ml-16'">
        <?php echo $__env->make('partials.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <main class="p-4 md:p-6">
            <?php echo $__env->make('partials.breadcrumb', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php if(session('toast')): ?>
                <div x-init="push(<?php echo \Illuminate\Support\Js::from(session('toast'))->toHtml() ?>, 'success')"></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="badge-red mb-3"><?php echo e($errors->first()); ?></div>
            <?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</div>
<?php else: ?>
    <?php echo $__env->yieldContent('content'); ?>
<?php endif; ?>

<?php echo $__env->make('partials.toast', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/layouts/app.blade.php ENDPATH**/ ?>