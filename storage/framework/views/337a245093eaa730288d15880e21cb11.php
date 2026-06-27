<?php $__env->startSection('title', 'Katalog'); ?>
<?php $__env->startSection('content'); ?>
<?php if(auth()->guard()->guest()): ?>
<div class="bg-primary-600 text-white p-3 mb-4 rounded-lg flex justify-between items-center">
    <span class="text-sm">Anda belum login. Daftar gratis untuk meminjam buku.</span>
    <a href="<?php echo e(route('login')); ?>" class="bg-white text-primary-600 px-3 py-1 rounded text-sm font-medium">Masuk</a>
</div>
<?php endif; ?>
<h1 class="text-2xl font-bold mb-4">Katalog Buku</h1>

<form method="get" class="card mb-6 grid md:grid-cols-5 gap-3">
    <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari..." class="form-input md:col-span-2">
    <select name="category" class="form-input">
        <option value="">Semua Kategori</option>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>" <?php if(request('category')==$c->id): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <select name="sort" class="form-input">
        <option value="title">A-Z</option>
        <option value="newest" <?php if(request('sort')==='newest'): echo 'selected'; endif; ?>>Terbaru</option>
        <option value="popular" <?php if(request('sort')==='popular'): echo 'selected'; endif; ?>>Populer</option>
    </select>
    <button class="btn-primary">Terapkan</button>
</form>

<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
    <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('catalog.show', $b)); ?>" class="card hover:shadow-lg transition">
            <div class="aspect-[3/4] bg-gray-200 dark:bg-gray-700 rounded mb-2 flex items-center justify-center text-3xl">
                <?php if($b->cover): ?><img src="<?php echo e(asset('storage/'.$b->cover)); ?>" class="w-full h-full object-cover rounded"><?php else: ?> 📕 <?php endif; ?>
            </div>
            <p class="font-medium text-sm line-clamp-2"><?php echo e($b->title); ?></p>
            <p class="text-xs text-gray-500 mt-1"><?php echo e($b->authors->pluck('name')->join(', ')); ?></p>
            <p class="text-xs mt-1"><span class="text-yellow-500">★ <?php echo e($b->rating_avg); ?></span> · <span class="badge-green"><?php echo e($b->available); ?>/<?php echo e($b->stock); ?></span></p>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="col-span-6 text-gray-500 text-sm py-12 text-center">Tidak ada buku ditemukan.</p>
    <?php endif; ?>
</div>
<div class="mt-6"><?php echo e($books->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/catalog/index.blade.php ENDPATH**/ ?>