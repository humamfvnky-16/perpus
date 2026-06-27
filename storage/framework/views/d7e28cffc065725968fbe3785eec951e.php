<!doctype html>
<html><head><meta charset="utf-8"><title><?php echo e($title); ?></title>
<style>body{font-family:DejaVu Sans,Arial;padding:20px}h1{font-size:18px}table{width:100%;border-collapse:collapse}td,th{border:1px solid #ccc;padding:6px;font-size:11px;text-align:left}</style>
</head><body>
<h1><?php echo e($title); ?></h1>
<p>Dicetak: <?php echo e(now()->format('d M Y H:i')); ?></p>
<table><thead><tr><th>#</th><th>Detail</th><th>Info</th></tr></thead><tbody>
<?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr><td><?php echo e($i+1); ?></td><td><?php echo e($r->title ?? $r->book?->title); ?></td><td><?php echo e($r->borrow_count ?? ($r->due_at?->format('d M Y') ?? '')); ?></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody></table>
</body></html>
<?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/reports/pdf.blade.php ENDPATH**/ ?>