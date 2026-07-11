<?php $__env->startSection('title','Edit File Digital'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-pen',
    'title' => 'Edit File Digital',
    'desc'  => 'Perbarui data file digital: '.$ebook->title,
    'actions' => [
        ['url' => route('books.show', $ebook->book_id), 'label' => 'Kembali', 'class' => 'btn-secondary', 'icon' => 'fa-arrow-left'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<form method="POST" action="<?php echo e(route('ebooks.update', $ebook)); ?>" class="card grid grid-cols-1 md:grid-cols-2 gap-4"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Judul</label>
        <input name="title" required value="<?php echo e($ebook->title); ?>" class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Format</label>
        <select name="format" class="form-select mt-1">
            <?php $__currentLoopData = ['pdf','epub','docx','pptx','audio','video']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($f); ?>" <?php if($ebook->format===$f): echo 'selected'; endif; ?>><?php echo e($f); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Akses</label>
        <select name="access" class="form-select mt-1">
            <option value="public" <?php if($ebook->access==='public'): echo 'selected'; endif; ?>>Publik</option>
            <option value="member" <?php if($ebook->access==='member'): echo 'selected'; endif; ?>>Anggota</option>
            <option value="staff" <?php if($ebook->access==='staff'): echo 'selected'; endif; ?>>Staff</option>
        </select>
    </div>
    <label class="flex items-center gap-2 md:col-span-2 text-sm text-slate-700 dark:text-slate-200">
        <input type="checkbox" name="downloadable" value="1" <?php if($ebook->downloadable): echo 'checked'; endif; ?> class="rounded border-slate-300 text-primary-600 focus:ring-primary-500"> Boleh diunduh
    </label>
    <div class="md:col-span-2 flex flex-wrap gap-2 pt-2 border-t border-slate-100 dark:border-slate-700">
        <button class="btn-primary"><i class="fas fa-floppy-disk"></i> Simpan</button>
        <a href="<?php echo e(route('books.show', $ebook->book_id)); ?>" class="btn-secondary">Batal</a>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/ebooks/edit.blade.php ENDPATH**/ ?>