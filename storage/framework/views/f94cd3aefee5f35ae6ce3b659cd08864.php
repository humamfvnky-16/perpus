<?php $__env->startSection('title','Reservasi'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Reservasi Buku</h1>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Anggota</th><th class="px-3 py-2 text-left">Buku</th><th class="px-3 py-2 text-left">Antrean</th><th class="px-3 py-2 text-left">Reservasi</th><th class="px-3 py-2 text-left">Status</th><th></th></tr></thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2"><?php echo e($r->member?->user?->name); ?></td>
        <td class="px-3 py-2"><?php echo e($r->book?->title); ?></td>
        <td class="px-3 py-2">#<?php echo e($r->queue_position); ?></td>
        <td class="px-3 py-2"><?php echo e($r->reserved_at?->format('d M H:i')); ?></td>
        <td class="px-3 py-2"><?php echo e($r->status); ?></td>
        <td class="px-3 py-2 text-right whitespace-nowrap">
            <?php if($r->status === 'pending'): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('reservation.verify')): ?><form method="POST" action="<?php echo e(route('reservations.verify', $r)); ?>" class="inline"><?php echo csrf_field(); ?><button class="text-primary-600">Verifikasi</button></form><?php endif; ?>
                <form method="POST" action="<?php echo e(route('reservations.cancel', $r)); ?>" class="inline ml-2"><?php echo csrf_field(); ?><button class="text-red-600">Batalkan</button></form>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="6" class="px-3 py-6 text-center text-gray-500">Belum ada reservasi.</td></tr>
<?php endif; ?>
</tbody>
</table>
<div class="mt-4"><?php echo e($rows->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/reservations/index.blade.php ENDPATH**/ ?>