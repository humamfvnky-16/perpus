<?php $__env->startSection('title','Detail Denda'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-money-bill-wave',
    'title' => 'Detail Denda',
    'desc'  => 'Denda #' . $fine->id,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="card max-w-xl">
    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3 text-sm">
        <div><dt class="text-slate-500 dark:text-slate-400">Anggota</dt><dd class="font-medium"><?php echo e($fine->user?->name); ?></dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Tipe</dt><dd class="font-medium"><?php echo e($fine->type); ?></dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Jumlah</dt><dd class="font-medium">Rp <?php echo e(number_format($fine->amount,0,',','.')); ?></dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Dibayar</dt><dd class="font-medium">Rp <?php echo e(number_format($fine->paid_amount,0,',','.')); ?></dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Sisa</dt><dd class="font-medium">Rp <?php echo e(number_format($fine->remaining,0,',','.')); ?></dd></div>
        <div>
            <dt class="text-slate-500 dark:text-slate-400">Status</dt>
            <dd>
                <?php if($fine->status === 'paid'): ?><span class="badge-green"><i class="fas fa-check"></i> <?php echo e($fine->status); ?></span>
                <?php elseif($fine->status === 'waived'): ?><span class="badge-blue"><i class="fas fa-hand"></i> <?php echo e($fine->status); ?></span>
                <?php elseif($fine->status === 'partial'): ?><span class="badge-yellow"><i class="fas fa-clock"></i> <?php echo e($fine->status); ?></span>
                <?php else: ?><span class="badge-red"><i class="fas fa-triangle-exclamation"></i> <?php echo e($fine->status); ?></span><?php endif; ?>
            </dd>
        </div>
    </dl>
    <?php if($fine->status !== 'paid' && $fine->status !== 'waived'): ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payment.record')): ?>
        <form method="POST" action="<?php echo e(route('fines.pay', $fine)); ?>" class="mt-6 flex flex-wrap gap-2"><?php echo csrf_field(); ?>
            <input type="number" name="amount" max="<?php echo e($fine->remaining); ?>" placeholder="Jumlah" class="form-input flex-1 min-w-[10rem]">
            <button class="btn-primary"><i class="fas fa-money-bill"></i> Bayar</button>
        </form>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('fine.waive')): ?>
        <form method="POST" action="<?php echo e(route('fines.waive', $fine)); ?>" class="mt-3"><?php echo csrf_field(); ?><button class="btn-secondary"><i class="fas fa-hand"></i> Bebaskan Denda</button></form>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/fines/show.blade.php ENDPATH**/ ?>