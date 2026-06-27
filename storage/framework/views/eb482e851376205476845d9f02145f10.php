<?php $__env->startSection('title','Laporan'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Laporan</h1>
<div class="grid md:grid-cols-2 gap-6">
    <div class="card">
        <div class="flex justify-between"><h2 class="font-semibold">Buku Populer</h2>
            <a href="<?php echo e(route('reports.pdf','popular')); ?>" class="text-primary-600 text-sm">Export PDF</a></div>
        <ol class="list-decimal pl-5 mt-2 text-sm space-y-1">
            <?php $__empty_1 = true; $__currentLoopData = $topBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><li><?php echo e($b->title); ?> <span class="text-gray-500">(<?php echo e($b->borrow_count); ?>x)</span></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><li class="text-gray-500">Tidak ada data.</li><?php endif; ?>
        </ol>
    </div>
    <div class="card">
        <div class="flex justify-between"><h2 class="font-semibold">Buku Terlambat</h2>
            <a href="<?php echo e(route('reports.pdf','overdue')); ?>" class="text-primary-600 text-sm">Export PDF</a></div>
        <ul class="text-sm mt-2 space-y-1">
            <?php $__empty_1 = true; $__currentLoopData = $overdue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><li><?php echo e($t->book?->title); ?> — <?php echo e($t->member?->user?->name); ?> <span class="text-red-600">(<?php echo e($t->daysLate()); ?> hari)</span></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><li class="text-gray-500">Tidak ada keterlambatan.</li><?php endif; ?>
        </ul>
    </div>
    <div class="card md:col-span-2">
        <h2 class="font-semibold">Anggota Aktif</h2>
        <ol class="list-decimal pl-5 mt-2 text-sm">
            <?php $__empty_1 = true; $__currentLoopData = $activeMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><li><?php echo e($m->member_no); ?> — <?php echo e($m->borrows_count); ?> transaksi</li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><li class="text-gray-500">Tidak ada data.</li><?php endif; ?>
        </ol>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/reports/index.blade.php ENDPATH**/ ?>