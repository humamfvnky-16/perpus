<aside
    class="fixed inset-y-0 left-0 z-30 hidden md:flex flex-col bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-all duration-200"
    :class="$store.sidebar.open ? 'w-64' : 'w-16'">
    <div class="flex items-center h-16 px-4 border-b border-gray-200 dark:border-gray-700">
        <span class="text-primary-600 font-bold text-xl" x-show="$store.sidebar.open">PerpusDigital</span>
        <span class="text-primary-600 font-bold text-xl" x-show="!$store.sidebar.open" x-cloak>P</span>
    </div>
    <nav class="flex-1 overflow-y-auto py-4 space-y-1 text-sm">
        <?php
            $sections = [
                'Utama' => [
                    ['route' => 'dashboard',         'label' => 'Dashboard',    'icon' => 'M3 12l2-2 7-7 7 7 2 2v8a2 2 0 01-2 2h-3v-6h-4v6H5a2 2 0 01-2-2v-8z'],
                    ['route' => 'catalog.index',     'label' => 'Katalog',      'icon' => 'M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z'],
                ],
                'Multi-Tenant' => [
                    ['route' => 'reading-spots.index','label' => 'Reading Spots','icon' => 'M5 9l7-6 7 6v11a2 2 0 01-2 2h-3v-7H10v7H7a2 2 0 01-2-2V9z'],
                    ['route' => 'ddc-categories.index','label' => 'DDC',         'icon' => 'M4 6h16M4 12h16M4 18h7'],
                ],
                'Koleksi' => [
                    ['route' => 'books.index',          'label' => 'Buku Digital','icon' => 'M12 6v13M12 6c-2-1-4-1-6 0v13c2-1 4-1 6 0m0-13c2-1 4-1 6 0v13c-2-1-4-1-6 0', 'perm' => 'book.view'],
                    ['route' => 'offline-books.index',  'label' => 'Buku Fisik',  'icon' => 'M3 5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm5 4h8M8 13h8M8 17h5', 'perm' => 'book.view'],
                    ['route' => 'ebooks.index',         'label' => 'E-Book',      'icon' => 'M9 4v16m6-16v16M3 6h2m12 0h2M3 18h2m12 0h2', 'perm' => 'ebook.view'],
                ],
                'Sirkulasi' => [
                    ['route' => 'members.index',     'label' => 'Anggota',      'icon' => 'M17 20h5v-2a3 3 0 00-5-2M9 11a4 4 0 100-8 4 4 0 000 8z', 'perm' => 'member.view'],
                    ['route' => 'borrows.index',     'label' => 'Peminjaman',   'icon' => 'M3 8h13a5 5 0 010 10h-3M3 8l4-4M3 8l4 4', 'perm' => 'borrow.view'],
                    ['route' => 'returns.create',    'label' => 'Pengembalian', 'icon' => 'M21 8h-13a5 5 0 000 10h3M21 8l-4-4M21 8l-4 4', 'perm' => 'borrow.return'],
                    ['route' => 'checkouts.index',   'label' => 'Checkout Fisik','icon' => 'M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['route' => 'holds.index',       'label' => 'Hold',         'icon' => 'M10 9v6m4-6v6M5 5h14v14H5z'],
                    ['route' => 'reservations.index','label' => 'Reservasi',    'icon' => 'M5 13l4 4L19 7'],
                    ['route' => 'fines.index',       'label' => 'Denda',        'icon' => 'M12 8c-2 0-3 1-3 2s1 2 3 2 3 1 3 2-1 2-3 2m0-8v8m0-8V6m0 10v2', 'perm' => 'fine.view'],
                ],
                'Personal' => [
                    ['route' => 'wishlist.index',    'label' => 'Wishlist',     'icon' => 'M4 6a4 4 0 016-3l2 1 2-1a4 4 0 016 3c0 6-8 12-8 12S4 12 4 6z'],
                ],
                'Admin' => [
                    ['route' => 'reports.index',     'label' => 'Laporan',      'icon' => 'M9 19V9a2 2 0 012-2h2a2 2 0 012 2v10M5 19V13a2 2 0 012-2h2M19 19v-6a2 2 0 00-2-2h-2', 'perm' => 'report.view'],
                    ['route' => 'settings.index',    'label' => 'Pengaturan',   'icon' => 'M10 4a2 2 0 014 0c.5 2 3 2 3.5 0a2 2 0 012.5 2.5c-2 .5-2 3 0 3.5a2 2 0 01-2.5 2.5c-.5-2-3-2-3.5 0a2 2 0 01-4 0c-.5-2-3-2-3.5 0a2 2 0 01-2.5-2.5c2-.5 2-3 0-3.5A2 2 0 016.5 4c.5 2 3 2 3.5 0z', 'perm' => 'setting.manage'],
                ],
            ];
        ?>
        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section => $links): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="px-4 pt-3 text-[10px] font-semibold uppercase text-gray-400 tracking-wider" x-show="$store.sidebar.open" x-cloak><?php echo e($section); ?></div>
            <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(empty($l['perm']) || auth()->user()->can($l['perm'])): ?>
                    <a href="<?php echo e(\Illuminate\Support\Facades\Route::has($l['route']) ? route($l['route']) : '#'); ?>"
                       class="flex items-center gap-3 px-4 py-2 mx-2 rounded-lg hover:bg-primary-50 dark:hover:bg-gray-700 <?php echo e(request()->routeIs($l['route']) ? 'bg-primary-100 text-primary-700 dark:bg-gray-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-200'); ?>">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($l['icon']); ?>"/></svg>
                        <span x-show="$store.sidebar.open" x-cloak><?php echo e($l['label']); ?></span>
                    </a>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>
</aside>
<?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>