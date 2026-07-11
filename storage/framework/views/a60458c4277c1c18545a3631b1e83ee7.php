<?php $__env->startSection('title','Detail Checkout'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-receipt',
    'title' => 'Detail Checkout',
    'desc'  => $checkout->code,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="card max-w-2xl">
    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3 text-sm">
        <div><dt class="text-slate-500 dark:text-slate-400">Anggota</dt><dd class="font-medium"><?php echo e($checkout->user?->name); ?></dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Reading Spot</dt><dd class="font-medium"><?php echo e($checkout->readingSpot?->name); ?></dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Petugas</dt><dd class="font-medium"><?php echo e($checkout->staff?->name ?? '-'); ?></dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Mulai</dt><dd class="font-medium"><?php echo e($checkout->start_time?->format('d M Y H:i')); ?></dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Jatuh Tempo</dt><dd class="font-medium <?php echo e($checkout->isOverdue() ? 'text-red-600 dark:text-red-400' : ''); ?>"><?php echo e($checkout->end_time?->format('d M Y H:i')); ?></dd></div>
        <div>
            <dt class="text-slate-500 dark:text-slate-400">Status</dt>
            <dd>
                <?php if($checkout->is_returned): ?><span class="badge-green"><i class="fas fa-check"></i> Sudah kembali</span>
                <?php else: ?><span class="badge-yellow"><i class="fas fa-clock"></i> Aktif</span><?php endif; ?>
            </dd>
        </div>
        <?php if($checkout->return_time): ?><div><dt class="text-slate-500 dark:text-slate-400">Dikembalikan</dt><dd class="font-medium"><?php echo e($checkout->return_time?->format('d M Y H:i')); ?></dd></div><?php endif; ?>
        <?php if($checkout->fine_amount > 0): ?><div><dt class="text-slate-500 dark:text-slate-400">Denda</dt><dd class="font-medium">Rp <?php echo e(number_format($checkout->fine_amount,0,',','.')); ?></dd></div><?php endif; ?>
    </dl>

    <h3 class="font-semibold mt-6 mb-2 text-slate-800 dark:text-slate-100">Buku yang Dipinjam</h3>
    <ul class="text-sm space-y-1">
        <?php $__currentLoopData = $checkout->offlineBookCopies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $copy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="p-2 rounded-lg bg-primary-50/70 dark:bg-slate-700/40">
                <strong><?php echo e($copy->offlineBook?->title); ?></strong>
                <span class="text-xs text-slate-500 dark:text-slate-400 font-mono">— <?php echo e($copy->catalog_code); ?></span>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <?php if(!$checkout->is_returned): ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('checkout.manage')): ?>
        <form method="POST" action="<?php echo e(route('checkouts.checkin', $checkout)); ?>" class="mt-6 space-y-3"><?php echo csrf_field(); ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kondisi</label>
                    <select name="condition" class="form-select mt-1">
                        <option value="good">Baik</option><option value="damaged">Rusak</option><option value="lost">Hilang</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Catatan Kerusakan</label>
                    <input name="damage_notes" class="form-input mt-1">
                </div>
            </div>
            <button class="btn-primary"><i class="fas fa-right-from-bracket"></i> Proses Pengembalian</button>
        </form>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/checkouts/show.blade.php ENDPATH**/ ?>