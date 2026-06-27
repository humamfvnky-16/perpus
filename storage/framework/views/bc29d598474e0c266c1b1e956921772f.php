<?php $__env->startSection('title','Peminjaman'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Peminjaman</h1>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('borrow.create')): ?><a href="<?php echo e(route('borrows.create')); ?>" class="btn-primary">+ Peminjaman Baru</a><?php endif; ?>
</div>
<form class="card mb-4 flex gap-3" method="get">
    <select name="status" class="form-input w-48">
        <option value="">Semua status</option>
        <?php $__currentLoopData = ['active','returned','overdue','lost','damaged']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s); ?>" <?php if(request('status')===$s): echo 'selected'; endif; ?>><?php echo e($s); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <button class="btn-secondary">Filter</button>
</form>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Kode</th><th class="px-3 py-2 text-left">Anggota</th><th class="px-3 py-2 text-left">Buku</th><th class="px-3 py-2 text-left">Pinjam</th><th class="px-3 py-2 text-left">Jatuh Tempo</th><th class="px-3 py-2 text-left">Status</th><th></th></tr></thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2 font-mono"><?php echo e($t->code); ?></td>
        <td class="px-3 py-2"><?php echo e($t->member?->user?->name); ?></td>
        <td class="px-3 py-2"><?php echo e($t->book?->title); ?></td>
        <td class="px-3 py-2"><?php echo e($t->borrowed_at?->format('d M Y')); ?></td>
        <td class="px-3 py-2 <?php echo e($t->isOverdue() ? 'text-red-600 font-semibold' : ''); ?>"><?php echo e($t->due_at?->format('d M Y')); ?></td>
        <td class="px-3 py-2"><?php echo e($t->status); ?></td>
        <td class="px-3 py-2 text-right"><a href="<?php echo e(route('borrows.show', $t)); ?>" class="text-primary-600">Detail</a></td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="7" class="px-3 py-6 text-center text-gray-500">Belum ada transaksi.</td></tr>
<?php endif; ?>
</tbody>
</table>
<div class="mt-4"><?php echo e($rows->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/borrows/index.blade.php ENDPATH**/ ?>