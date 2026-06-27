@extends('layouts.app')
@section('title','Edit Kategori')
@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Kategori</h1>
<form method="POST" action="{{ route('categories.update', $category) }}" class="card space-y-3">@csrf @method('PUT')
    <div><label class="text-sm">Nama</label><input name="name" required value="{{ $category->name }}" class="form-input"></div>
    <div><label class="text-sm">Kode Dewey</label><input name="dewey_code" value="{{ $category->dewey_code }}" class="form-input"></div>
    <div><label class="text-sm">Deskripsi</label><textarea name="description" class="form-input">{{ $category->description }}</textarea></div>
    <button class="btn-primary">Simpan</button>
</form>
@endsection
