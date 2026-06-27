@extends('layouts.app')
@section('title','Tambah Kategori')
@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah Kategori</h1>
<form method="POST" action="{{ route('categories.store') }}" class="card space-y-3">@csrf
    <div><label class="text-sm">Nama</label><input name="name" required class="form-input"></div>
    <div><label class="text-sm">Kode Dewey</label><input name="dewey_code" class="form-input"></div>
    <div><label class="text-sm">Deskripsi</label><textarea name="description" class="form-input"></textarea></div>
    <button class="btn-primary">Simpan</button>
</form>
@endsection
