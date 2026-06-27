@extends('layouts.app')
@section('title', $readingSpot->name)
@section('content')
<div class="flex justify-between items-start mb-4">
    <div>
        <h1 class="text-2xl font-bold">{{ $readingSpot->name }}</h1>
        <p class="text-sm text-gray-500">{{ ucfirst($readingSpot->type) }} · {{ $readingSpot->city ?: '-' }}</p>
    </div>
    <div class="space-x-2">
        @can('setting.manage')<a href="{{ route('app-profiles.edit', $readingSpot) }}" class="btn-secondary">Branding</a>@endcan
        @can('setting.manage')<a href="{{ route('reading-spots.edit', $readingSpot) }}" class="btn-primary">Edit</a>@endcan
    </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
    @php $cards = [
        ['Anggota', $stats['members'], 'bg-blue-600'],
        ['Buku Digital', $stats['books'], 'bg-primary-600'],
        ['Buku Fisik', $stats['offline_books'], 'bg-green-600'],
        ['Kopi Fisik', $stats['offline_copies'], 'bg-emerald-600'],
        ['Hold Aktif', $stats['active_holds'], 'bg-yellow-600'],
        ['Checkout', $stats['active_checkouts'], 'bg-purple-600'],
    ]; @endphp
    @foreach($cards as [$label,$value,$color])
        <div class="card text-center">
            <div class="h-6 w-6 rounded {{ $color }} mx-auto mb-2"></div>
            <p class="text-xs text-gray-500">{{ $label }}</p>
            <p class="text-xl font-bold">{{ $value }}</p>
        </div>
    @endforeach
</div>

<div class="grid md:grid-cols-2 gap-6">
    <div class="card">
        <h2 class="font-semibold mb-3">Informasi</h2>
        <dl class="text-sm space-y-1">
            <div class="flex justify-between"><dt class="text-gray-500">Slug</dt><dd class="font-mono">{{ $readingSpot->slug }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">NPSN</dt><dd>{{ $readingSpot->npsn ?: '-' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Telepon</dt><dd>{{ $readingSpot->phone ?: '-' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Email</dt><dd>{{ $readingSpot->email ?: '-' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Status</dt><dd>{{ $readingSpot->is_active ? 'Aktif' : 'Nonaktif' }}</dd></div>
        </dl>
        @if($readingSpot->address)
            <hr class="my-3 border-gray-200 dark:border-gray-700">
            <p class="text-sm">{{ $readingSpot->address }}</p>
        @endif
    </div>
    <div class="card">
        <h2 class="font-semibold mb-3">Aturan Peminjaman</h2>
        @php $cs = $readingSpot->checkoutSetting; @endphp
        @if($cs)
        <dl class="text-sm space-y-1">
            <div class="flex justify-between"><dt class="text-gray-500">Lama pinjam</dt><dd>{{ $cs->loan_days }} hari</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Maks per anggota</dt><dd>{{ $cs->max_books }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Denda harian</dt><dd>Rp {{ number_format($cs->daily_fine,0,',','.') }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Denda kerusakan</dt><dd>Rp {{ number_format($cs->damage_fine,0,',','.') }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Denda hilang</dt><dd>Rp {{ number_format($cs->lost_fine,0,',','.') }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Hold expires</dt><dd>{{ $cs->hold_expires_hours }} jam</dd></div>
        </dl>
        @endif
    </div>
</div>
@endsection
