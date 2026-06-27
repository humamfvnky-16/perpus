@extends('layouts.app')
@section('title','Struk Peminjaman')
@section('content')
<div class="card max-w-md">
    <h1 class="text-xl font-bold mb-2 text-center">Struk Peminjaman</h1>
    <p class="text-sm text-gray-500 text-center mb-4 font-mono">{{ $tx->code }}</p>
    <dl class="text-sm space-y-1">
        <div class="flex justify-between"><dt>Anggota</dt><dd>{{ $tx->member?->user?->name }}</dd></div>
        <div class="flex justify-between"><dt>Buku</dt><dd>{{ $tx->book?->title }}</dd></div>
        <div class="flex justify-between"><dt>Tanggal Pinjam</dt><dd>{{ $tx->borrowed_at?->format('d M Y') }}</dd></div>
        <div class="flex justify-between"><dt>Jatuh Tempo</dt><dd>{{ $tx->due_at?->format('d M Y') }}</dd></div>
        <div class="flex justify-between"><dt>Petugas</dt><dd>{{ $tx->staff?->name ?? '-' }}</dd></div>
    </dl>
    <p class="text-xs text-center mt-4 text-gray-500">Mohon kembalikan buku tepat waktu untuk menghindari denda.</p>
    <button onclick="window.print()" class="btn-primary w-full mt-4">Cetak Struk</button>
</div>
@endsection
