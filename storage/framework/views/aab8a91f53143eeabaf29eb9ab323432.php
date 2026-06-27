<?php $__env->startSection('title','Wishlist'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Wishlist Saya</h1>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('catalog.show', $b)); ?>" class="card hover:shadow-lg">
            <div class="aspect-[3/4] bg-gray-200 dark:bg-gray-700 rounded mb-2 flex items-center justify-center text-3xl">📕</div>
            <p class="font-medium text-sm line-clamp-2"><?php echo e($b->title); ?></p>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="col-span-4 text-gray-500 text-sm py-12 text-center">Belum ada buku di wishlist.</p>
    <?php endif; ?>
</div>
<div class="mt-4"><?php echo e($books->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/wishlist/index.blade.php ENDPATH**/ ?>