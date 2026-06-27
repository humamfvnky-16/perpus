<?php $__env->startSection('title','Pengaturan'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Pengaturan Sistem</h1>
<form method="POST" action="<?php echo e(route('settings.update')); ?>" class="space-y-4"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <?php $__empty_1 = true; $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card">
            <h2 class="font-semibold uppercase text-sm text-gray-500 mb-3"><?php echo e($group); ?></h2>
            <div class="grid md:grid-cols-2 gap-4">
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <label class="text-sm"><?php echo e($s->label ?? $s->key); ?></label>
                    <input name="settings[<?php echo e($s->key); ?>]" value="<?php echo e($s->value); ?>" class="form-input">
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-gray-500">Tidak ada pengaturan.</p>
    <?php endif; ?>
    <button class="btn-primary">Simpan Pengaturan</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/settings/index.blade.php ENDPATH**/ ?>