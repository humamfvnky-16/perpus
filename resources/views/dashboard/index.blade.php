@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-gauge-high',
    'title' => 'Dashboard',
    'desc'  => 'Ringkasan aktivitas perpustakaan terbaru.',
])

{{-- Welcome card --}}
<div class="card mb-6 bg-gradient-to-r from-primary-600 to-primary-800 text-white border-0 shadow-hover">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-sm opacity-90">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
            <h2 class="text-2xl font-bold mt-1">Selamat datang kembali, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-sm opacity-90 mt-1">Berikut ringkasan perpustakaan hari ini.</p>
        </div>
        @can('checkout.create')
        <a href="{{ route('checkouts.create') }}" class="btn-accent shadow-lg">
            <i class="fas fa-plus"></i> Checkout Cepat
        </a>
        @endcan
    </div>
</div>

{{-- ===================== Ringkasan Aktivitas (grafik 30 hari) ===================== --}}
<div class="grid lg:grid-cols-3 gap-4 mb-6">
    <div class="lg:col-span-2 card">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h2 class="font-bold text-lg">Grafik Aktivitas Buku</h2>
                <p class="text-xs text-slate-500">Dalam 30 hari terakhir</p>
            </div>
        </div>
        <canvas id="activity-chart" height="110"></canvas>
    </div>

    <div class="grid grid-cols-2 gap-4 content-start">
        <div class="rounded-2xl p-4 text-white shadow-soft bg-gradient-to-br from-amber-400 to-amber-600">
            <i class="fas fa-book text-xl opacity-90"></i>
            <p class="text-xs font-semibold uppercase tracking-wide opacity-90 mt-2">Total Judul Buku</p>
            <p class="text-lg font-bold mt-1 leading-tight">{{ number_format($digitalBooksCount) }} buku digital</p>
            <p class="text-sm opacity-90">{{ number_format($fisikBooksCount) }} buku fisik</p>
        </div>
        <div class="rounded-2xl p-4 text-white shadow-soft bg-gradient-to-br from-emerald-400 to-emerald-600">
            <i class="fas fa-list text-xl opacity-90"></i>
            <p class="text-xs font-semibold uppercase tracking-wide opacity-90 mt-2">Total Kategori Buku</p>
            <p class="text-2xl font-bold mt-1">{{ number_format($categoriesCount) }}</p>
        </div>
        <div class="rounded-2xl p-4 text-white shadow-soft bg-gradient-to-br from-primary-500 to-primary-800">
            <i class="fas fa-chart-simple text-xl opacity-90"></i>
            <p class="text-xs font-semibold uppercase tracking-wide opacity-90 mt-2">Aktivitas Buku Hari Ini</p>
            <p class="text-xs mt-1 leading-snug">
                {{ number_format($todayViews) }} dilihat<br>
                {{ number_format($todayReads) }} dibaca<br>
                {{ number_format($todayBorrows) }} dipinjam
            </p>
        </div>
        <div class="rounded-2xl p-4 text-white shadow-soft bg-gradient-to-br from-rose-400 to-rose-600">
            <i class="fas fa-user-plus text-xl opacity-90"></i>
            <p class="text-xs font-semibold uppercase tracking-wide opacity-90 mt-2">Akun Baru Hari Ini</p>
            <p class="text-2xl font-bold mt-1">{{ number_format($newAccountsToday) }}</p>
        </div>
        @can('report.view')
        <a href="{{ route('visitors.index') }}" class="rounded-2xl p-4 text-white shadow-soft bg-gradient-to-br from-sky-400 to-sky-600 block hover:opacity-90 transition">
            <i class="fas fa-user-clock text-xl opacity-90"></i>
            <p class="text-xs font-semibold uppercase tracking-wide opacity-90 mt-2">Riwayat Pengunjung</p>
            <p class="text-xs mt-1 leading-snug">
                {{ number_format($visitorsToday) }} hari ini<br>
                {{ number_format($visitorsMonth) }} bulan ini
            </p>
        </a>
        @endcan
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('activity-chart');
        if (!ctx || typeof Chart === 'undefined') return;
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($activityChart['labels']),
                datasets: [
                    {
                        label: 'Total buku digital yang dilihat',
                        data: @json($activityChart['views']),
                        borderColor: '#f43f5e', backgroundColor: 'rgba(244,63,94,0.15)',
                        tension: 0.4, fill: true, borderWidth: 2, pointRadius: 2,
                    },
                    {
                        label: 'Total buku digital yang dibaca',
                        data: @json($activityChart['reads']),
                        borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.1)',
                        tension: 0.4, fill: false, borderWidth: 2, pointRadius: 2,
                    },
                    {
                        label: 'Total buku fisik yang dipinjam',
                        data: @json($activityChart['borrows']),
                        borderColor: '#7c3aed', backgroundColor: 'rgba(124,58,237,0.1)',
                        tension: 0.4, fill: false, borderWidth: 2, pointRadius: 2,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top', labels: { boxWidth: 10, font: { size: 11 } } } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false }, ticks: { maxRotation: 90, minRotation: 90 } },
                }
            },
        });
    });
</script>

{{-- Kategori bacaan & Top lokasi baca --}}
<div class="grid lg:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <h2 class="font-bold text-lg mb-4">Kategori Bacaan</h2>
        <div class="overflow-x-auto -mx-6">
            <table class="table-pretty">
                <thead><tr><th class="w-12">No.</th><th>Kategori</th><th>Jumlah</th></tr></thead>
                <tbody>
                @forelse($categoryBreakdown as $i => $cat)
                    <tr>
                        <td>{{ $i + 1 }}.</td>
                        <td class="font-medium">{{ $cat->name }}</td>
                        <td>{{ number_format($cat->books_count) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-slate-500 py-8">Belum ada data.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <h2 class="font-bold text-lg mb-1">Top 10 Lokasi Baca Terbaik</h2>
        <p class="text-xs text-slate-500 mb-4">Dalam 30 hari terakhir</p>
        <canvas id="top-spots-chart" height="140"></canvas>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('top-spots-chart');
        if (!ctx || typeof Chart === 'undefined') return;
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($topSpots->pluck('name')),
                datasets: [
                    { label: 'Total Buku Dilihat',  data: @json($topSpots->pluck('views_count')),   backgroundColor: 'rgba(244,63,94,0.7)' },
                    { label: 'Total Buku Terbaca',  data: @json($topSpots->pluck('reads_count')),   backgroundColor: 'rgba(16,185,129,0.7)' },
                    { label: 'Total Buku Dipinjam', data: @json($topSpots->pluck('borrows_count')), backgroundColor: 'rgba(124,58,237,0.7)' },
                ],
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top', labels: { boxWidth: 10, font: { size: 11 } } } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false } },
                }
            },
        });
    });
</script>

{{-- Stat cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    @include('partials.stat-card', ['icon'=>'fa-book',          'label'=>'Total Buku',   'value'=>number_format($stats['total_books']), 'color'=>'primary'])
    @include('partials.stat-card', ['icon'=>'fa-tablet-screen-button','label'=>'E-Book','value'=>number_format($stats['total_ebooks']), 'color'=>'purple'])
    @include('partials.stat-card', ['icon'=>'fa-check-circle',   'label'=>'Tersedia',    'value'=>number_format($stats['available']),    'color'=>'green'])
    @include('partials.stat-card', ['icon'=>'fa-handshake',      'label'=>'Dipinjam',    'value'=>number_format($stats['borrowed']),     'color'=>'yellow'])
    @include('partials.stat-card', ['icon'=>'fa-users',          'label'=>'Anggota',     'value'=>number_format($stats['members']),      'color'=>'blue'])
    @include('partials.stat-card', ['icon'=>'fa-receipt',        'label'=>'Transaksi',   'value'=>number_format($stats['transactions']), 'color'=>'indigo'])
    @include('partials.stat-card', ['icon'=>'fa-triangle-exclamation','label'=>'Terlambat','value'=>number_format($stats['overdue']),    'color'=>'red'])
    @include('partials.stat-card', ['icon'=>'fa-money-bill-wave','label'=>'Denda Tertunggak','value'=>'Rp '.number_format($stats['fine_unpaid'],0,',','.'), 'color'=>'pink'])
</div>

<div class="grid lg:grid-cols-3 gap-6 mb-6">
    {{-- Chart peminjaman --}}
    <div class="card lg:col-span-2">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h2 class="font-bold text-lg">Peminjaman 14 Hari Terakhir</h2>
                <p class="text-xs text-slate-500">Tren peminjaman buku fisik</p>
            </div>
            <span class="badge-blue"><i class="fas fa-chart-line"></i> Live</span>
        </div>
        <canvas id="borrow-chart" height="100"></canvas>
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                const ctx = document.getElementById('borrow-chart');
                if (!ctx || typeof Chart === 'undefined') return;
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($chart->pluck('d')),
                        datasets: [{
                            label: 'Pinjaman',
                            data: @json($chart->pluck('c')),
                            borderColor: '#0b67a0',
                            backgroundColor: 'rgba(11,103,160,0.1)',
                            tension: 0.4, fill: true, borderWidth: 3,
                            pointBackgroundColor: '#0b67a0', pointRadius: 4, pointHoverRadius: 6,
                        }],
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { grid: { color: 'rgba(0,0,0,0.05)' } },
                            x: { grid: { display: false } },
                        }
                    },
                });
            });
        </script>
    </div>

    {{-- Top books --}}
    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-bold text-lg">Buku Populer</h2>
            <a href="{{ route('catalog.index', ['sort'=>'popular']) }}" class="text-xs text-primary-600 hover:underline">Lihat semua</a>
        </div>
        <ol class="space-y-3">
            @forelse($popular as $i => $b)
                <li class="flex items-start gap-3">
                    <span class="h-7 w-7 rounded-lg bg-primary-100 text-primary-700 flex items-center justify-center text-xs font-bold shrink-0">{{ $i+1 }}</span>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm truncate">{{ $b->title }}</p>
                        <p class="text-xs text-slate-500">
                            <span class="text-amber-500"><i class="fas fa-star"></i> {{ $b->rating_avg }}</span> ·
                            {{ $b->view_count }} dilihat
                        </p>
                    </div>
                </li>
            @empty
                <li class="text-sm text-slate-500 text-center py-4"><i class="fas fa-inbox"></i> Belum ada data</li>
            @endforelse
        </ol>
    </div>
</div>

{{-- Recent activity --}}
<div class="card">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="font-bold text-lg">Peminjaman Fisik Terbaru</h2>
            <p class="text-xs text-slate-500">10 transaksi terakhir</p>
        </div>
        @can('checkout.view')<a href="{{ route('checkouts.index') }}" class="btn-secondary"><i class="fas fa-list"></i> Semua Transaksi</a>@endcan
    </div>
    <div class="overflow-x-auto -mx-6">
        <table class="table-pretty">
            <thead>
                <tr><th>Kode</th><th>Anggota</th><th>Buku</th><th>Jatuh Tempo</th><th>Status</th></tr>
            </thead>
            <tbody>
            @forelse($recent as $t)
                <tr>
                    <td><span class="font-mono text-xs">{{ $t->code }}</span></td>
                    <td class="flex items-center gap-2">
                        <span class="h-8 w-8 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center text-xs font-bold">
                            {{ strtoupper(substr($t->user?->name ?? '?', 0, 1)) }}
                        </span>
                        <span class="font-medium">{{ $t->user?->name ?? '-' }}</span>
                    </td>
                    <td class="truncate max-w-xs">{{ $t->offlineBookCopies->pluck('offlineBook.title')->join(', ') }}</td>
                    <td><span class="text-xs">{{ $t->end_time?->locale('id')->translatedFormat('d M Y') }}</span></td>
                    <td>
                        @if($t->is_returned)<span class="badge-green"><i class="fas fa-check"></i> Kembali</span>
                        @elseif($t->isOverdue())<span class="badge-red"><i class="fas fa-triangle-exclamation"></i> Terlambat</span>
                        @else<span class="badge-yellow"><i class="fas fa-clock"></i> Aktif</span>@endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-slate-500 py-8"><i class="fas fa-inbox text-2xl mb-2 block"></i> Belum ada transaksi.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
