<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-6">Dashboard</h1>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <?php $cards = [
        ['Total Buku', $stats['total_books'], 'bg-primary-600'],
        ['E-Book', $stats['total_ebooks'], 'bg-purple-600'],
        ['Tersedia', $stats['available'], 'bg-green-600'],
        ['Dipinjam', $stats['borrowed'], 'bg-yellow-600'],
        ['Anggota', $stats['members'], 'bg-blue-600'],
        ['Transaksi', $stats['transactions'], 'bg-indigo-600'],
        ['Terlambat', $stats['overdue'], 'bg-red-600'],
        ['Denda Tertunggak', 'Rp '.number_format($stats['fine_unpaid'],0,',','.'), 'bg-pink-600'],
    ]; ?>
    <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label,$value,$color]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card">
            <div class="h-8 w-8 rounded-lg <?php echo e($color); ?> mb-3"></div>
            <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($label); ?></p>
            <p class="text-2xl font-bold mt-1"><?php echo e($value); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="grid md:grid-cols-3 gap-6 mb-6">
    <div class="card md:col-span-2">
        <h2 class="font-semibold mb-3">Peminjaman 14 Hari Terakhir</h2>
        <canvas id="borrow-chart" height="120"></canvas>
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                const ctx = document.getElementById('borrow-chart');
                if (!ctx || typeof Chart === 'undefined') return;
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: <?php echo json_encode($chart->pluck('d'), 15, 512) ?>,
                        datasets: [{ label: 'Pinjaman', data: <?php echo json_encode($chart->pluck('c'), 15, 512) ?>, borderColor: '#2563eb', tension: 0.3, fill: true, backgroundColor: 'rgba(37,99,235,0.1)' }],
                    },
                    options: { responsive: true, plugins: { legend: { display: false } } },
                });
            });
        </script>
    </div>
    <div class="card">
        <h2 class="font-semibold mb-3">Buku Populer</h2>
        <ul class="space-y-2 text-sm">
            <?php $__empty_1 = true; $__currentLoopData = $popular; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="flex justify-between"><span class="truncate pr-2"><?php echo e($b->title); ?></span><span class="badge-green shrink-0"><?php echo e($b->borrow_count); ?>x</span></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="text-gray-500">Belum ada data.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<div class="card">
    <h2 class="font-semibold mb-3">Aktivitas Terbaru</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/40">
                <tr><th class="px-3 py-2 text-left">Kode</th><th class="px-3 py-2 text-left">Anggota</th><th class="px-3 py-2 text-left">Buku</th><th class="px-3 py-2 text-left">Jatuh Tempo</th><th class="px-3 py-2 text-left">Status</th></tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $recent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="border-t border-gray-100 dark:border-gray-700">
                    <td class="px-3 py-2 font-mono"><?php echo e($t->code); ?></td>
                    <td class="px-3 py-2"><?php echo e($t->member?->user?->name ?? '-'); ?></td>
                    <td class="px-3 py-2 truncate max-w-xs"><?php echo e($t->book?->title); ?></td>
                    <td class="px-3 py-2"><?php echo e($t->due_at?->format('d M Y')); ?></td>
                    <td class="px-3 py-2">
                        <?php $bg = $t->status === 'active' ? 'badge-yellow' : ($t->status === 'returned' ? 'badge-green' : 'badge-red'); ?>
                        <span class="<?php echo e($bg); ?>"><?php echo e($t->status); ?></span>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="px-3 py-6 text-center text-gray-500">Belum ada transaksi.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/dashboard/index.blade.php ENDPATH**/ ?>