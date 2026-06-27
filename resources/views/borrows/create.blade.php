@extends('layouts.app')
@section('title','Peminjaman Baru')
@section('content')
<h1 class="text-2xl font-bold mb-4">Peminjaman Baru</h1>
<form method="POST" action="{{ route('borrows.store') }}" class="card space-y-4">@csrf
    <div><label class="text-sm">Anggota</label>
        <select name="member_id" required class="form-input">
            <option value="">Pilih anggota...</option>
            @foreach($members as $m)<option value="{{ $m->id }}">{{ $m->member_no }} — {{ $m->user?->name }}</option>@endforeach
        </select>
    </div>
    <div><label class="text-sm">Buku</label>
        <select name="book_id" required class="form-input">
            <option value="">Pilih buku...</option>
            @foreach($books as $b)<option value="{{ $b->id }}">{{ $b->title }} ({{ $b->available }} tersedia)</option>@endforeach
        </select>
    </div>
    <div><label class="text-sm">Lama Pinjam (hari)</label><input type="number" name="days" value="{{ config('library.default_loan_days') }}" min="1" max="30" class="form-input"></div>
    <div><label class="text-sm">Catatan</label><textarea name="notes" class="form-input"></textarea></div>
    <button class="btn-primary">Simpan</button>
</form>
@endsection
