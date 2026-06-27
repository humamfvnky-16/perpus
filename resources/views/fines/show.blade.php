@extends('layouts.app')
@section('title','Detail Denda')
@section('content')
<div class="card max-w-xl">
    <h1 class="text-xl font-bold mb-3">Denda #{{ $fine->id }}</h1>
    <dl class="grid grid-cols-2 gap-2 text-sm">
        <dt class="text-gray-500">Anggota</dt><dd>{{ $fine->member?->user?->name }}</dd>
        <dt class="text-gray-500">Tipe</dt><dd>{{ $fine->type }}</dd>
        <dt class="text-gray-500">Jumlah</dt><dd>Rp {{ number_format($fine->amount,0,',','.') }}</dd>
        <dt class="text-gray-500">Dibayar</dt><dd>Rp {{ number_format($fine->paid_amount,0,',','.') }}</dd>
        <dt class="text-gray-500">Sisa</dt><dd>Rp {{ number_format($fine->remaining,0,',','.') }}</dd>
        <dt class="text-gray-500">Status</dt><dd>{{ $fine->status }}</dd>
    </dl>
    @if($fine->status !== 'paid' && $fine->status !== 'waived')
        @can('payment.record')
        <form method="POST" action="{{ route('fines.pay', $fine) }}" class="mt-4 flex gap-2">@csrf
            <input type="number" name="amount" max="{{ $fine->remaining }}" placeholder="Jumlah" class="form-input flex-1">
            <button class="btn-primary">Bayar</button>
        </form>
        @endcan
        @can('fine.waive')
        <form method="POST" action="{{ route('fines.waive', $fine) }}" class="mt-2">@csrf<button class="btn-secondary">Bebaskan Denda</button></form>
        @endcan
    @endif
</div>
@endsection
