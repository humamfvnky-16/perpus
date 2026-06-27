<?php $__env->startSection('title', config('app.name')); ?>
<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-primary-50 to-white dark:from-gray-900 dark:to-gray-800">
    <header class="container mx-auto px-4 py-6 flex justify-between items-center">
        <a href="/" class="text-xl font-bold text-primary-600">PerpusDigital</a>
        <div class="space-x-2">
            <a href="<?php echo e(route('catalog.index')); ?>" class="btn-secondary">Katalog</a>
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('dashboard')); ?>" class="btn-primary">Dashboard</a>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="btn-primary">Masuk</a>
            <?php endif; ?>
        </div>
    </header>
    <main class="container mx-auto px-4 py-16 text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-4">Perpustakaan Modern di Genggaman Anda</h2>
        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mb-8">Koleksi buku fisik &amp; digital, pinjam-kembali otomatis, reservasi antrean, dan reader e-book langsung dari browser.</p>
        <div class="flex justify-center gap-3">
            <a href="<?php echo e(route('catalog.index')); ?>" class="btn-primary">Jelajahi Katalog</a>
            <?php if(auth()->guard()->guest()): ?> <a href="<?php echo e(route('register')); ?>" class="btn-secondary">Daftar Anggota</a> <?php endif; ?>
        </div>

        <div class="grid md:grid-cols-3 gap-4 mt-16 text-left">
            <div class="card"><h3 class="font-semibold mb-2">Koleksi Lengkap</h3><p class="text-sm text-gray-500 dark:text-gray-400">Cari berdasarkan judul, ISBN, penulis, kategori, dan rak. Filter dan sorting cepat.</p></div>
            <div class="card"><h3 class="font-semibold mb-2">E-Book Reader</h3><p class="text-sm text-gray-500 dark:text-gray-400">Baca PDF/EPUB langsung dari browser dengan bookmark otomatis dan watermark pengguna.</p></div>
            <div class="card"><h3 class="font-semibold mb-2">Reservasi &amp; Antrean</h3><p class="text-sm text-gray-500 dark:text-gray-400">Buku habis? Reservasi dan dapat notifikasi saat tersedia.</p></div>
        </div>
    </main>
    <footer class="container mx-auto px-4 py-6 text-center text-sm text-gray-500">&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?></footer>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/welcome.blade.php ENDPATH**/ ?>