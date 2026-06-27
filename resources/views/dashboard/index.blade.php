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
        @can('borrow.create')
        <a href="{{ route('borrows.create') }}" class="btn-accent shadow-lg">
            <i class="fas fa-plus"></i> Peminjaman Cepat
        </a>
        @endcan
    </div>
</div>

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
                <p class="text-xs text-slate-500">Tren peminjaman buku digital &amp; fisik</p>
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
                            {{ $b->borrow_count }} pinjaman
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
            <h2 class="font-bold text-lg">Aktivitas Peminjaman Terbaru</h2>
            <p class="text-xs text-slate-500">10 transaksi terakhir</p>
        </div>
        @can('borrow.view')<a href="{{ route('borrows.index') }}" class="btn-secondary"><i class="fas fa-list"></i> Semua Transaksi</a>@endcan
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
                            {{ strtoupper(substr($t->member?->user?->name ?? '?', 0, 1)) }}
                        </span>
                        <span class="font-medium">{{ $t->member?->user?->name ?? '-' }}</span>
                    </td>
                    <td class="truncate max-w-xs">{{ $t->book?->title }}</td>
                    <td><span class="text-xs">{{ $t->due_at?->locale('id')->translatedFormat('d M Y') }}</span></td>
                    <td>
                        @if($t->status === 'active')<span class="badge-yellow"><i class="fas fa-clock"></i> Aktif</span>
                        @elseif($t->status === 'returned')<span class="badge-green"><i class="fas fa-check"></i> Kembali</span>
                        @else<span class="badge-red"><i class="fas fa-xmark"></i> {{ $t->status }}</span>@endif
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
