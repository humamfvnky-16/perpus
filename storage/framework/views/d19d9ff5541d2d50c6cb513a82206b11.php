<?php
    $segments = collect(request()->segments());
    $items = $segments->map(function ($seg, $i) use ($segments) {
        return [
            'label' => ucfirst(str_replace('-', ' ', $seg)),
            'url'   => url(implode('/', $segments->slice(0, $i+1)->all())),
        ];
    });
?>
<?php if($items->isNotEmpty()): ?>
<nav class="text-sm text-gray-500 dark:text-gray-400 mb-4">
    <a href="<?php echo e(url('/')); ?>" class="hover:underline">Home</a>
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="mx-1">/</span>
        <?php if($loop->last): ?> <span class="text-gray-900 dark:text-gray-100"><?php echo e($it['label']); ?></span>
        <?php else: ?> <a href="<?php echo e($it['url']); ?>" class="hover:underline"><?php echo e($it['label']); ?></a> <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</nav>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/partials/breadcrumb.blade.php ENDPATH**/ ?>