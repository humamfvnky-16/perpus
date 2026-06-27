@extends('layouts.app')
@section('title','Detail Peminjaman')
@section('content')
<div class="card max-w-2xl">
    <h1 class="text-xl font-bold mb-3">{{ $tx->code }}</h1>
    <dl class="grid grid-cols-2 gap-2 text-sm">
        <dt class="text-gray-500">Anggota</dt><dd>{{ $tx->member?->user?->name }}</dd>
        <dt class="text-gray-500">Buku</dt><dd>{{ $tx->book?->title }}</dd>
        <dt class="text-gray-500">Petugas</dt><dd>{{ $tx->staff?->name ?? '-' }}</dd>
        <dt class="text-gray-500">Tanggal Pinjam</dt><dd>{{ $tx->borrowed_at?->format('d M Y') }}</dd>
        <dt class="text-gray-500">Jatuh Tempo</dt><dd class="{{ $tx->isOverdue() ? 'text-red-600 font-semibold' : '' }}">{{ $tx->due_at?->format('d M Y') }}</dd>
        <dt class="text-gray-500">Status</dt><dd>{{ $tx->status }}</dd>
        <dt class="text-gray-500">Diperpanjang</dt><dd>{{ $tx->renew_count }}x</dd>
        @if($tx->fine)<dt class="text-gray-500">Denda</dt><dd>Rp {{ number_format($tx->fine->amount, 0, ',', '.') }} ({{ $tx->fine->status }})</dd>@endif
    </dl>
    @if($tx->status === 'active')
        <div class="flex gap-2 mt-4">
            @can('renew', $tx)<form method="POST" action="{{ route('borrows.renew', $tx) }}">@csrf<button class="btn-secondary">Perpanjang</button></form>@endcan
            @can('return', $tx)<a href="{{ route('returns.create', ['code' => $tx->code]) }}" class="btn-primary">Proses Pengembalian</a>@endcan
        </div>
    @endif
</div>
@endsection
