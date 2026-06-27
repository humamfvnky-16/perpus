@extends('layouts.app')
@section('title','Tambah Rak')
@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah Rak</h1>
<form method="POST" action="{{ route('shelves.store') }}" class="card grid md:grid-cols-2 gap-3">@csrf
    <div><label class="text-sm">Kode</label><input name="code" required class="form-input"></div>
    <div><label class="text-sm">Nama</label><input name="name" required class="form-input"></div>
    <div><label class="text-sm">Lantai</label><input name="floor" class="form-input"></div>
    <div><label class="text-sm">Ruang</label><input name="room" class="form-input"></div>
    <div class="md:col-span-2"><button class="btn-primary">Simpan</button></div>
</form>
@endsection
