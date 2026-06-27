<?php $__env->startSection('title','Tambah Kategori DDC'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Tambah Kategori DDC</h1>
<form method="POST" action="<?php echo e(route('ddc-categories.store')); ?>" class="card grid md:grid-cols-2 gap-3"><?php echo csrf_field(); ?>
    <div><label class="text-sm">Kode (000, 100, ...)</label><input name="code" required class="form-input font-mono"></div>
    <div><label class="text-sm">Nama</label><input name="name" required class="form-input"></div>
    <div><label class="text-sm">Induk (opsional)</label>
        <select name="parent_id" class="form-input">
            <option value="">— tidak ada induk</option>
            <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p->id); ?>"><?php echo e($p->code); ?> — <?php echo e($p->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div><label class="text-sm">Urutan</label><input type="number" name="order" value="0" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Deskripsi</label><textarea name="description" class="form-input"></textarea></div>
    <div class="md:col-span-2"><button class="btn-primary">Simpan</button></div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/ddc-categories/create.blade.php ENDPATH**/ ?>