@extends('layouts.app')
@section('title','Edit Rak')
@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Rak</h1>
<form method="POST" action="{{ route('shelves.update', $shelf) }}" class="card grid md:grid-cols-2 gap-3">@csrf @method('PUT')
    <div><label class="text-sm">Kode</label><input name="code" required value="{{ $shelf->code }}" class="form-input"></div>
    <div><label class="text-sm">Nama</label><input name="name" required value="{{ $shelf->name }}" class="form-input"></div>
    <div><label class="text-sm">Lantai</label><input name="floor" value="{{ $shelf->floor }}" class="form-input"></div>
    <div><label class="text-sm">Ruang</label><input name="room" value="{{ $shelf->room }}" class="form-input"></div>
    <div class="md:col-span-2"><button class="btn-primary">Simpan</button></div>
</form>
@endsection
