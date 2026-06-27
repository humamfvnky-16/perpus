<?php $__env->startSection('title', $readingSpot->name); ?>
<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-start mb-4">
    <div>
        <h1 class="text-2xl font-bold"><?php echo e($readingSpot->name); ?></h1>
        <p class="text-sm text-gray-500"><?php echo e(ucfirst($readingSpot->type)); ?> · <?php echo e($readingSpot->city ?: '-'); ?></p>
    </div>
    <div class="space-x-2">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting.manage')): ?><a href="<?php echo e(route('app-profiles.edit', $readingSpot)); ?>" class="btn-secondary">Branding</a><?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting.manage')): ?><a href="<?php echo e(route('reading-spots.edit', $readingSpot)); ?>" class="btn-primary">Edit</a><?php endif; ?>
    </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
    <?php $cards = [
        ['Anggota', $stats['members'], 'bg-blue-600'],
        ['Buku Digital', $stats['books'], 'bg-primary-600'],
        ['Buku Fisik', $stats['offline_books'], 'bg-green-600'],
        ['Kopi Fisik', $stats['offline_copies'], 'bg-emerald-600'],
        ['Hold Aktif', $stats['active_holds'], 'bg-yellow-600'],
        ['Checkout', $stats['active_checkouts'], 'bg-purple-600'],
    ]; ?>
    <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label,$value,$color]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card text-center">
            <div class="h-6 w-6 rounded <?php echo e($color); ?> mx-auto mb-2"></div>
            <p class="text-xs text-gray-500"><?php echo e($label); ?></p>
            <p class="text-xl font-bold"><?php echo e($value); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <div class="card">
        <h2 class="font-semibold mb-3">Informasi</h2>
        <dl class="text-sm space-y-1">
            <div class="flex justify-between"><dt class="text-gray-500">Slug</dt><dd class="font-mono"><?php echo e($readingSpot->slug); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">NPSN</dt><dd><?php echo e($readingSpot->npsn ?: '-'); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Telepon</dt><dd><?php echo e($readingSpot->phone ?: '-'); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Email</dt><dd><?php echo e($readingSpot->email ?: '-'); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Status</dt><dd><?php echo e($readingSpot->is_active ? 'Aktif' : 'Nonaktif'); ?></dd></div>
        </dl>
        <?php if($readingSpot->address): ?>
            <hr class="my-3 border-gray-200 dark:border-gray-700">
            <p class="text-sm"><?php echo e($readingSpot->address); ?></p>
        <?php endif; ?>
    </div>
    <div class="card">
        <h2 class="font-semibold mb-3">Aturan Peminjaman</h2>
        <?php $cs = $readingSpot->checkoutSetting; ?>
        <?php if($cs): ?>
        <dl class="text-sm space-y-1">
            <div class="flex justify-between"><dt class="text-gray-500">Lama pinjam</dt><dd><?php echo e($cs->loan_days); ?> hari</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Maks per anggota</dt><dd><?php echo e($cs->max_books); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Denda harian</dt><dd>Rp <?php echo e(number_format($cs->daily_fine,0,',','.')); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Denda kerusakan</dt><dd>Rp <?php echo e(number_format($cs->damage_fine,0,',','.')); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Denda hilang</dt><dd>Rp <?php echo e(number_format($cs->lost_fine,0,',','.')); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Hold expires</dt><dd><?php echo e($cs->hold_expires_hours); ?> jam</dd></div>
        </dl>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/reading-spots/show.blade.php ENDPATH**/ ?>