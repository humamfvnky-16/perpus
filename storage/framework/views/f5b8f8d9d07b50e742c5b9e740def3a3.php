<?php $__env->startSection('title', 'Anggota'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Manajemen Anggota</h1>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('member.create')): ?><a href="<?php echo e(route('members.create')); ?>" class="btn-primary">+ Anggota Baru</a><?php endif; ?>
</div>
<form class="card mb-4 flex gap-3" method="get">
    <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Nama / NIS / email..." class="form-input flex-1">
    <select name="type" class="form-input w-40">
        <option value="">Semua</option>
        <option value="student" <?php if(request('type')==='student'): echo 'selected'; endif; ?>>Siswa</option>
        <option value="teacher" <?php if(request('type')==='teacher'): echo 'selected'; endif; ?>>Guru</option>
        <option value="public"  <?php if(request('type')==='public'): echo 'selected'; endif; ?>>Umum</option>
    </select>
    <button class="btn-secondary">Cari</button>
</form>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr>
    <th class="px-3 py-2 text-left">No</th><th class="px-3 py-2 text-left">Nama</th><th class="px-3 py-2 text-left">NIS/NIP</th><th class="px-3 py-2 text-left">Tipe</th><th class="px-3 py-2 text-left">Aktif</th><th></th>
</tr></thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2 font-mono"><?php echo e($m->member_no); ?></td>
        <td class="px-3 py-2"><?php echo e($m->user?->name); ?><br><span class="text-xs text-gray-500"><?php echo e($m->user?->email); ?></span></td>
        <td class="px-3 py-2"><?php echo e($m->nis_nip); ?></td>
        <td class="px-3 py-2"><?php echo e($m->type); ?></td>
        <td class="px-3 py-2"><?php if($m->is_active): ?><span class="badge-green">aktif</span><?php else: ?><span class="badge-red">tidak</span><?php endif; ?></td>
        <td class="px-3 py-2 text-right"><a href="<?php echo e(route('members.show', $m)); ?>" class="text-primary-600">Detail</a></td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="6" class="px-3 py-6 text-center text-gray-500">Belum ada anggota.</td></tr>
<?php endif; ?>
</tbody>
</table>
<div class="mt-4"><?php echo e($members->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/members/index.blade.php ENDPATH**/ ?>