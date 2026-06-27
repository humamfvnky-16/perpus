@extends('layouts.app')
@section('title','Edit Penerbit')
@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Penerbit</h1>
<form method="POST" action="{{ route('publishers.update', $publisher) }}" class="card grid md:grid-cols-2 gap-3">@csrf @method('PUT')
    <div><label class="text-sm">Nama</label><input name="name" required value="{{ $publisher->name }}" class="form-input"></div>
    <div><label class="text-sm">Kota</label><input name="city" value="{{ $publisher->city }}" class="form-input"></div>
    <div><label class="text-sm">Negara</label><input name="country" value="{{ $publisher->country }}" class="form-input"></div>
    <div><label class="text-sm">Website</label><input name="website" type="url" value="{{ $publisher->website }}" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Alamat</label><textarea name="address" class="form-input">{{ $publisher->address }}</textarea></div>
    <div class="md:col-span-2"><button class="btn-primary">Simpan</button></div>
</form>
@endsection
