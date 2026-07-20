<!doctype html>
<html><head><meta charset="utf-8"><title><?php echo e($title); ?></title>
<style>
    body { font-family: DejaVu Sans, Arial, sans-serif; padding: 24px; color: #1a1a1a; font-size: 12px; }
    h1 { font-size: 18px; margin: 0 0 4px 0; color: #4c1d95; }
    h2 { font-size: 13px; margin: 24px 0 10px 0; color: #4c1d95; }
    p { margin: 0 0 16px 0; color: #555555; font-size: 11px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #dddddd; padding: 6px 8px; font-size: 11px; text-align: left; }
    thead th { background-color: #f3f3f6; color: #333333; font-weight: bold; }
    tbody tr:nth-child(even) { background-color: #fafafa; }
    .summary { width: 100%; margin-bottom: 8px; }
    .summary td { border: none; padding: 10px 14px; }
    .summary .box { background-color: #f5f3ff; border-radius: 6px; }
    .summary .label { font-size: 10px; color: #6d28d9; text-transform: uppercase; }
    .summary .value { font-size: 20px; font-weight: bold; color: #4c1d95; }
    .bar-row td { border: none; padding: 4px 0; vertical-align: middle; }
    .bar-label { width: 70px; font-size: 10px; color: #555; }
    .bar-track { background-color: #f0f0f0; }
    .bar-fill { background-color: #7c3aed; height: 12px; }
    .bar-value { width: 40px; font-size: 10px; text-align: right; color: #333; }
    .text-right { text-align: right; }
</style>
</head><body>

<h1><?php echo e($title); ?></h1>
<p><?php echo e($appProfile->app_name ?? config('app.name')); ?> — Dicetak: <?php echo e(now()->format('d M Y H:i')); ?></p>

<table class="summary">
    <tr>
        <td class="box" width="50%">
            <div class="label">Pengunjung Hari Ini</div>
            <div class="value"><?php echo e(number_format($todayCount)); ?></div>
        </td>
        <td class="box" width="50%">
            <div class="label">Pengunjung Bulan Ini</div>
            <div class="value"><?php echo e(number_format($monthCount)); ?></div>
        </td>
    </tr>
</table>

<h2>Grafik Pengunjung 12 Bulan Terakhir</h2>
<?php $maxMonthly = max(1, $monthlyChart->max('total')); ?>
<table>
<?php $__currentLoopData = $monthlyChart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr class="bar-row">
        <td class="bar-label"><?php echo e($m['label']); ?></td>
        <td class="bar-track">
            <div class="bar-fill" style="width: <?php echo e(round(($m['total'] / $maxMonthly) * 100, 1)); ?>%;"></div>
        </td>
        <td class="bar-value"><?php echo e(number_format($m['total'])); ?></td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<h2>Trafik Kunjungan 30 Hari Terakhir</h2>
<table>
    <thead><tr><th>#</th><th>Tanggal</th><th class="text-right">Jumlah Pengunjung</th></tr></thead>
    <tbody>
    <?php $__currentLoopData = $dailyCounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($i + 1); ?></td>
            <td><?php echo e(\Illuminate\Support\Carbon::parse($row['date'])->locale('id')->translatedFormat('d F Y')); ?></td>
            <td class="text-right"><?php echo e(number_format($row['total'])); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

</body></html>
<?php /**PATH C:\laragon\www\web\Perpus\resources\views/visitors/pdf.blade.php ENDPATH**/ ?>