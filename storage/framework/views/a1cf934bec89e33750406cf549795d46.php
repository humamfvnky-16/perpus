<?php $__env->startSection('title','Detail Kunjungan'); ?>
<?php $__env->startSection('content'); ?>

<div class="container mx-auto px-4 py-8">

    <?php echo $__env->make('partials.page-header', [
        'icon'  => 'fa-calendar-day',
        'title' => 'Detail Kunjungan',
        'desc'  => \Illuminate\Support\Carbon::parse($date)->locale('id')->translatedFormat('l, d F Y'),
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="mb-4">
        <a href="<?php echo e(route('visitors.history')); ?>" class="text-sm text-primary-600 hover:underline">
            <i class="fas fa-arrow-left"></i> Kembali ke Histori Kunjungan
        </a>
    </div>

    <div class="rounded-2xl p-5 text-white shadow-soft bg-gradient-to-br from-primary-500 to-primary-800 mb-6 max-w-xs">
        <i class="fas fa-users text-xl opacity-90"></i>
        <p class="text-xs font-semibold uppercase tracking-wide opacity-90 mt-2">Total Pengunjung</p>
        <p class="text-2xl font-bold mt-1"><?php echo e(number_format($total)); ?></p>
    </div>

    <div class="card mb-6">
        <h2 class="font-bold text-lg mb-4">Sebaran Kunjungan per Jam</h2>
        <canvas id="hourly-chart" height="90"></canvas>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('hourly-chart');
        if (!ctx || typeof Chart === 'undefined') return;
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($hourlyCounts->map(fn($h) => sprintf('%02d:00', $h['hour'])), 512) ?>,
                datasets: [{
                    label: 'Jumlah Pengunjung',
                    data: <?php echo json_encode($hourlyCounts->pluck('total'), 15, 512) ?>,
                    backgroundColor: 'rgba(124,58,237,0.7)',
                    borderRadius: 4,
                }],
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false } },
                },
            },
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/visitors/history-show.blade.php ENDPATH**/ ?>