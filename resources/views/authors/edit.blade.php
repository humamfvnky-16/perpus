@extends('layouts.app')
@section('title','Edit Penulis')
@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Penulis</h1>
<form method="POST" action="{{ route('authors.update', $author) }}" class="card space-y-3">@csrf @method('PUT')
    <div><label class="text-sm">Nama</label><input name="name" required value="{{ $author->name }}" class="form-input"></div>
    <div><label class="text-sm">Nationality</label><input name="nationality" value="{{ $author->nationality }}" class="form-input"></div>
    <div><label class="text-sm">Bio</label><textarea name="bio" class="form-input">{{ $author->bio }}</textarea></div>
    <button class="btn-primary">Simpan</button>
</form>
@endsection
