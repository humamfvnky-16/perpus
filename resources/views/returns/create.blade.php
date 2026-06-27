@extends('layouts.app')
@section('title','Pengembalian')
@section('content')
<h1 class="text-2xl font-bold mb-4">Pengembalian Buku</h1>
<form class="card mb-4 flex gap-3" method="get">
    <input name="code" value="{{ request('code') }}" placeholder="Kode peminjaman..." class="form-input flex-1">
    <input name="barcode" value="{{ request('barcode') }}" placeholder="Barcode buku..." class="form-input flex-1">
    <button class="btn-secondary">Cari</button>
</form>

@if(isset($tx) && $tx)
<form method="POST" action="{{ route('returns.store') }}" class="card space-y-3">@csrf
    <input type="hidden" name="borrow_transaction_id" value="{{ $tx->id }}">
    <p><strong>{{ $tx->code }}</strong> · {{ $tx->member?->user?->name }} · {{ $tx->book?->title }}</p>
    @if($tx->isOverdue())<p class="badge-red">Terlambat {{ $tx->daysLate() }} hari</p>@endif
    <div><label class="text-sm">Kondisi</label>
        <select name="condition" class="form-input">
            <option value="good">Baik</option><option value="damaged">Rusak</option><option value="lost">Hilang</option>
        </select>
    </div>
    <div><label class="text-sm">Catatan Kerusakan</label><textarea name="damage_notes" class="form-input"></textarea></div>
    <button class="btn-primary">Selesaikan Pengembalian</button>
</form>
@elseif(request()->hasAny(['code','barcode']))
    <div class="card badge-yellow inline-block">Transaksi tidak ditemukan atau sudah dikembalikan.</div>
@endif
@endsection
