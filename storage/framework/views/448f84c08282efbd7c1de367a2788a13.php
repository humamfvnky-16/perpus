<!doctype html>
<html><head><meta charset="utf-8"><title><?php echo e($title); ?></title>
<style>
    body { font-family: DejaVu Sans, Arial, sans-serif; padding: 24px; color: #1a1a1a; font-size: 12px; }
    h1 { font-size: 18px; margin: 0 0 4px 0; color: #4c1d95; }
    p { margin: 0 0 16px 0; color: #555555; font-size: 11px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #dddddd; padding: 8px; font-size: 11px; text-align: left; }
    thead th { background-color: #f3f3f6; color: #333333; font-weight: bold; }
    tbody tr:nth-child(even) { background-color: #fafafa; }
</style>
</head><body>
<h1><?php echo e($title); ?></h1>
<p>Dicetak: <?php echo e(now()->format('d M Y H:i')); ?></p>
<table><thead><tr><th>#</th><th>Detail</th><th>Info</th></tr></thead><tbody>
<?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr><td><?php echo e($i+1); ?></td><td><?php echo e($r->title ?? $r->offlineBookCopies?->pluck('offlineBook.title')->join(', ')); ?></td><td><?php echo e($r->view_count ?? ($r->end_time?->format('d M Y') ?? '')); ?></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody></table>
</body></html>
<?php /**PATH C:\laragon\www\web\Perpus\resources\views/reports/pdf.blade.php ENDPATH**/ ?>