<?php $__env->startSection('title','Riwayat Pengunjung'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-user-clock',
    'title' => 'Riwayat Pengunjung',
    'desc'  => 'Riwayat kunjungan pada laman perpustakaan.',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Pengunjung</th>
                <th>Halaman</th>
                <th>IP</th>
                <th>User Agent</th>
            </tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="whitespace-nowrap"><?php echo e($l->created_at?->format('d M Y H:i:s')); ?></td>
                <td><?php echo e($l->user?->name ?? 'Tamu'); ?></td>
                <td class="font-mono text-xs"><?php echo e($l->path); ?></td>
                <td class="font-mono text-xs"><?php echo e($l->ip_address); ?></td>
                <td class="text-xs text-slate-500 truncate max-w-xs block" title="<?php echo e($l->user_agent); ?>"><?php echo e($l->user_agent); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" class="text-center text-slate-500 py-10">
                    <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                    Belum ada data.
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <div class="mt-4 px-2"><?php echo e($logs->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/visitors/index.blade.php ENDPATH**/ ?>