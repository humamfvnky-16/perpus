@extends('layouts.app')
@section('title','Struk Pembayaran Denda')
@section('content')
<div class="card max-w-md">
    <h1 class="text-xl font-bold mb-2 text-center">Struk Pembayaran Denda</h1>
    <p class="text-sm text-gray-500 text-center mb-4">{{ $fine->updated_at?->format('d M Y H:i') }}</p>
    <dl class="text-sm space-y-1">
        <div class="flex justify-between"><dt>Anggota</dt><dd>{{ $fine->member?->user?->name }}</dd></div>
        <div class="flex justify-between"><dt>Tipe Denda</dt><dd>{{ $fine->type }}</dd></div>
        <div class="flex justify-between"><dt>Jumlah Denda</dt><dd>Rp {{ number_format($fine->amount,0,',','.') }}</dd></div>
        <div class="flex justify-between"><dt>Dibayar</dt><dd>Rp {{ number_format($fine->paid_amount,0,',','.') }}</dd></div>
        <div class="flex justify-between font-bold border-t pt-1 mt-1"><dt>Status</dt><dd>{{ $fine->status }}</dd></div>
    </dl>
    <button onclick="window.print()" class="btn-primary w-full mt-4">Cetak Struk</button>
</div>
@endsection
