<?php $__env->startSection('title','Pengembalian'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Pengembalian Buku</h1>
<form class="card mb-4 flex gap-3" method="get">
    <input name="code" value="<?php echo e(request('code')); ?>" placeholder="Kode peminjaman..." class="form-input flex-1">
    <input name="barcode" value="<?php echo e(request('barcode')); ?>" placeholder="Barcode buku..." class="form-input flex-1">
    <button class="btn-secondary">Cari</button>
</form>

<?php if(isset($tx) && $tx): ?>
<form method="POST" action="<?php echo e(route('returns.store')); ?>" class="card space-y-3"><?php echo csrf_field(); ?>
    <input type="hidden" name="borrow_transaction_id" value="<?php echo e($tx->id); ?>">
    <p><strong><?php echo e($tx->code); ?></strong> · <?php echo e($tx->member?->user?->name); ?> · <?php echo e($tx->book?->title); ?></p>
    <?php if($tx->isOverdue()): ?><p class="badge-red">Terlambat <?php echo e($tx->daysLate()); ?> hari</p><?php endif; ?>
    <div><label class="text-sm">Kondisi</label>
        <select name="condition" class="form-input">
            <option value="good">Baik</option><option value="damaged">Rusak</option><option value="lost">Hilang</option>
        </select>
    </div>
    <div><label class="text-sm">Catatan Kerusakan</label><textarea name="damage_notes" class="form-input"></textarea></div>
    <button class="btn-primary">Selesaikan Pengembalian</button>
</form>
<?php elseif(request()->hasAny(['code','barcode'])): ?>
    <div class="card badge-yellow inline-block">Transaksi tidak ditemukan atau sudah dikembalikan.</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/returns/create.blade.php ENDPATH**/ ?>