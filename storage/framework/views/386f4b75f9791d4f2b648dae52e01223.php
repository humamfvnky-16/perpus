<?php $__env->startSection('title','Upload File Digital'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-cloud-arrow-up',
    'title' => 'Upload File Digital',
    'desc'  => 'Tambahkan file digital untuk: '.$book->title,
    'actions' => [
        ['url' => route('books.show', $book), 'label' => 'Kembali', 'class' => 'btn-secondary', 'icon' => 'fa-arrow-left'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<form method="POST" action="<?php echo e(route('ebooks.store')); ?>" enctype="multipart/form-data" class="card grid grid-cols-1 md:grid-cols-2 gap-4"><?php echo csrf_field(); ?>
    <input type="hidden" name="book_id" value="<?php echo e($book->id); ?>">
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Judul</label>
        <input name="title" required value="<?php echo e(old('title', $book->title)); ?>" class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Format</label>
        <select name="format" class="form-select mt-1">
            <?php $__currentLoopData = ['pdf','epub','docx','pptx','audio','video']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($f); ?>"><?php echo e($f); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Akses</label>
        <select name="access" class="form-select mt-1">
            <option value="public">Publik</option><option value="member">Anggota</option><option value="staff">Staff</option>
        </select>
    </div>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">File</label>
        <input type="file" name="file" required class="form-input mt-1">
    </div>
    <label class="flex items-center gap-2 md:col-span-2 text-sm text-slate-700 dark:text-slate-200">
        <input type="checkbox" name="downloadable" value="1" class="rounded border-slate-300 text-primary-600 focus:ring-primary-500"> Boleh diunduh
    </label>
    <div class="md:col-span-2 flex flex-wrap gap-2 pt-2 border-t border-slate-100 dark:border-slate-700">
        <button class="btn-primary"><i class="fas fa-upload"></i> Upload</button>
        <a href="<?php echo e(route('books.show', $book)); ?>" class="btn-secondary">Batal</a>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/ebooks/create.blade.php ENDPATH**/ ?>