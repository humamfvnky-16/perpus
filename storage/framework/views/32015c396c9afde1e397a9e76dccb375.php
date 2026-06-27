<?php $__env->startSection('title','E-Book'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Koleksi E-Book</h1>
<form class="card mb-4 flex gap-3" method="get">
    <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari e-book..." class="form-input flex-1">
    <select name="format" class="form-input w-36">
        <option value="">Semua</option>
        <?php $__currentLoopData = ['pdf','epub','docx','pptx','audio','video']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($f); ?>" <?php if(request('format')===$f): echo 'selected'; endif; ?>><?php echo e($f); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <button class="btn-secondary">Filter</button>
</form>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('ebooks.read', $e)); ?>" class="card hover:shadow-lg">
            <div class="text-center text-3xl mb-2">📘</div>
            <p class="font-medium text-sm line-clamp-2"><?php echo e($e->title); ?></p>
            <p class="text-xs text-gray-500 uppercase"><?php echo e($e->format); ?></p>
            <p class="text-xs text-gray-500"><?php echo e($e->view_count); ?> pembaca</p>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="col-span-4 text-gray-500 text-sm py-12 text-center">Belum ada e-book.</p>
    <?php endif; ?>
</div>
<div class="mt-4"><?php echo e($items->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/ebooks/index.blade.php ENDPATH**/ ?>