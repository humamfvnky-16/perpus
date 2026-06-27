@extends('layouts.app')
@section('title','Tambah Penulis')
@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah Penulis</h1>
<form method="POST" action="{{ route('authors.store') }}" class="card space-y-3">@csrf
    <div><label class="text-sm">Nama</label><input name="name" required class="form-input"></div>
    <div><label class="text-sm">Nationality</label><input name="nationality" class="form-input"></div>
    <div><label class="text-sm">Bio</label><textarea name="bio" class="form-input"></textarea></div>
    <button class="btn-primary">Simpan</button>
</form>
@endsection
