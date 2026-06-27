<?php $__env->startSection('title', 'Manajemen Buku'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Manajemen Buku</h1>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('book.create')): ?><a href="<?php echo e(route('books.create')); ?>" class="btn-primary">+ Buku Baru</a><?php endif; ?>
</div>

<form class="card mb-4 flex flex-wrap gap-3" method="get">
    <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari judul/ISBN..." class="form-input flex-1 min-w-48">
    <select name="status" class="form-input w-40">
        <option value="">Semua status</option>
        <?php $__currentLoopData = ['available','borrowed','reserved','maintenance','lost']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s); ?>" <?php if(request('status')===$s): echo 'selected'; endif; ?>><?php echo e($s); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <button class="btn-secondary">Filter</button>
</form>

<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
    <thead class="bg-gray-50 dark:bg-gray-700/40">
        <tr><th class="px-3 py-2 text-left">Judul</th><th class="px-3 py-2 text-left">ISBN</th><th class="px-3 py-2 text-left">Kategori</th><th class="px-3 py-2 text-left">Stok</th><th class="px-3 py-2 text-left">Status</th><th></th></tr>
    </thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr class="border-t border-gray-100 dark:border-gray-700">
            <td class="px-3 py-2"><a href="<?php echo e(route('books.show', $b)); ?>" class="font-medium text-primary-600 hover:underline"><?php echo e($b->title); ?></a><br><span class="text-xs text-gray-500"><?php echo e($b->authors->pluck('name')->join(', ')); ?></span></td>
            <td class="px-3 py-2 font-mono"><?php echo e($b->isbn); ?></td>
            <td class="px-3 py-2"><?php echo e($b->category?->name); ?></td>
            <td class="px-3 py-2"><?php echo e($b->available); ?>/<?php echo e($b->stock); ?></td>
            <td class="px-3 py-2"><span class="badge-<?php echo e($b->status === 'available' ? 'green' : 'yellow'); ?>"><?php echo e($b->status); ?></span></td>
            <td class="px-3 py-2 text-right whitespace-nowrap">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('book.update')): ?><a href="<?php echo e(route('books.edit', $b)); ?>" class="text-primary-600">Edit</a><?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('book.delete')): ?>
                    <form action="<?php echo e(route('books.destroy', $b)); ?>" method="POST" class="inline ml-2" onsubmit="return confirm('Hapus buku ini?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="text-red-600">Hapus</button></form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="6" class="px-3 py-6 text-center text-gray-500">Belum ada data buku.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
<div class="mt-4"><?php echo e($books->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/books/index.blade.php ENDPATH**/ ?>