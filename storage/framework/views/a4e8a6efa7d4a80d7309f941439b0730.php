<?php $__env->startSection('title','Denda'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Denda</h1>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Anggota</th><th class="px-3 py-2 text-left">Tipe</th><th class="px-3 py-2 text-left">Jumlah</th><th class="px-3 py-2 text-left">Dibayar</th><th class="px-3 py-2 text-left">Status</th><th></th></tr></thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2"><?php echo e($f->member?->user?->name); ?></td>
        <td class="px-3 py-2"><?php echo e($f->type); ?></td>
        <td class="px-3 py-2">Rp <?php echo e(number_format($f->amount,0,',','.')); ?></td>
        <td class="px-3 py-2">Rp <?php echo e(number_format($f->paid_amount,0,',','.')); ?></td>
        <td class="px-3 py-2"><?php echo e($f->status); ?></td>
        <td class="px-3 py-2 text-right"><a href="<?php echo e(route('fines.show', $f)); ?>" class="text-primary-600">Detail</a></td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="6" class="px-3 py-6 text-center text-gray-500">Tidak ada denda.</td></tr>
<?php endif; ?>
</tbody>
</table>
<div class="mt-4"><?php echo e($rows->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/fines/index.blade.php ENDPATH**/ ?>