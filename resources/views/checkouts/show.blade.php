@extends('layouts.app')
@section('title','Detail Checkout')
@section('content')
<div class="card max-w-2xl">
    <h1 class="text-xl font-bold mb-3">{{ $checkout->code }}</h1>
    <dl class="grid grid-cols-2 gap-2 text-sm">
        <dt class="text-gray-500">Anggota</dt><dd>{{ $checkout->user?->name }}</dd>
        <dt class="text-gray-500">Reading Spot</dt><dd>{{ $checkout->readingSpot?->name }}</dd>
        <dt class="text-gray-500">Petugas</dt><dd>{{ $checkout->staff?->name ?? '-' }}</dd>
        <dt class="text-gray-500">Mulai</dt><dd>{{ $checkout->start_time?->format('d M Y H:i') }}</dd>
        <dt class="text-gray-500">Jatuh Tempo</dt><dd class="{{ $checkout->isOverdue() ? 'text-red-600 font-semibold' : '' }}">{{ $checkout->end_time?->format('d M Y H:i') }}</dd>
        <dt class="text-gray-500">Status</dt><dd>{{ $checkout->is_returned ? 'Sudah kembali' : 'Aktif' }}</dd>
        @if($checkout->return_time)<dt class="text-gray-500">Dikembalikan</dt><dd>{{ $checkout->return_time?->format('d M Y H:i') }}</dd>@endif
        @if($checkout->fine_amount > 0)<dt class="text-gray-500">Denda</dt><dd>Rp {{ number_format($checkout->fine_amount,0,',','.') }}</dd>@endif
    </dl>

    <h3 class="font-semibold mt-4 mb-2">Buku yang Dipinjam</h3>
    <ul class="text-sm space-y-1">
        @foreach($checkout->offlineBookCopies as $copy)
            <li class="p-2 bg-gray-50 dark:bg-gray-700 rounded">
                <strong>{{ $copy->offlineBook?->title }}</strong>
                <span class="text-xs text-gray-500 font-mono">— {{ $copy->catalog_code }}</span>
            </li>
        @endforeach
    </ul>

    @if(!$checkout->is_returned)
        @can('borrow.return')
        <form method="POST" action="{{ route('checkouts.checkin', $checkout) }}" class="mt-4">@csrf
            <button class="btn-primary">Proses Pengembalian</button>
        </form>
        @endcan
    @endif
</div>
@endsection
