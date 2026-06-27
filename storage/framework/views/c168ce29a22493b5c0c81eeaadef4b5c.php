<?php $__env->startSection('title','Reading Spots'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Reading Spots / Titik Baca</h1>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting.manage')): ?><a href="<?php echo e(route('reading-spots.create')); ?>" class="btn-primary">+ Reading Spot</a><?php endif; ?>
</div>
<form method="get" class="card mb-4 flex flex-wrap gap-3">
    <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Nama..." class="form-input flex-1 min-w-48">
    <select name="type" class="form-input w-40">
        <option value="">Semua tipe</option>
        <?php $__currentLoopData = ['school','library','community','public']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($t); ?>" <?php if(request('type')===$t): echo 'selected'; endif; ?>><?php echo e($t); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <button class="btn-secondary">Filter</button>
</form>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
<?php $__empty_1 = true; $__currentLoopData = $spots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <a href="<?php echo e(route('reading-spots.show', $s)); ?>" class="card hover:shadow-lg transition">
        <div class="flex items-center gap-3 mb-3">
            <div class="h-12 w-12 rounded-lg bg-primary-600 text-white flex items-center justify-center font-bold">
                <?php echo e(substr($s->name, 0, 1)); ?>

            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold truncate"><?php echo e($s->name); ?></h3>
                <p class="text-xs text-gray-500"><?php echo e(ucfirst($s->type)); ?> · <?php echo e($s->city ?: '-'); ?></p>
            </div>
            <?php if($s->is_active): ?><span class="badge-green">aktif</span><?php else: ?><span class="badge-red">nonaktif</span><?php endif; ?>
        </div>
        <div class="grid grid-cols-3 text-center text-xs gap-1">
            <div><p class="font-bold text-base"><?php echo e($s->members_count); ?></p><p class="text-gray-500">Anggota</p></div>
            <div><p class="font-bold text-base"><?php echo e($s->books_count); ?></p><p class="text-gray-500">Digital</p></div>
            <div><p class="font-bold text-base"><?php echo e($s->offline_books_count); ?></p><p class="text-gray-500">Fisik</p></div>
        </div>
    </a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="text-gray-500 col-span-3 text-center py-12">Belum ada Reading Spot.</p>
<?php endif; ?>
</div>
<div class="mt-4"><?php echo e($spots->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/reading-spots/index.blade.php ENDPATH**/ ?>