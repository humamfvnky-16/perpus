<header class="sticky top-0 z-20 flex items-center justify-between gap-4 h-16 px-4 md:px-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <button @click="$store.sidebar.toggle()" class="hidden md:inline-flex p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>

    <form action="<?php echo e(route('catalog.index')); ?>" method="get" class="flex-1 max-w-xl">
        <div class="relative">
            <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari judul, ISBN, atau penulis..." class="form-input pl-10 rounded-full">
            <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
    </form>

    <button @click="$store.theme.toggle()" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
        <svg x-show="!$store.theme.dark" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9 9 0 0012 21a9 9 0 008.354-5.646z"/></svg>
        <svg x-show="$store.theme.dark" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15-6.36l-.7.7M6.34 17.66l-.7.7m12.72 0l-.7-.7M6.34 6.34l-.7-.7M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
    </button>

    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
            <span class="hidden md:inline text-sm font-medium"><?php echo e(auth()->user()->name); ?></span>
            <span class="h-8 w-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-sm font-semibold"><?php echo e(substr(auth()->user()->name, 0, 1)); ?></span>
        </button>
        <div x-show="open" x-cloak @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-48 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-lg py-1">
            <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">Profil</a>
            <form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?>
                <button class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">Keluar</button>
            </form>
        </div>
    </div>
</header>
<?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/partials/topbar.blade.php ENDPATH**/ ?>