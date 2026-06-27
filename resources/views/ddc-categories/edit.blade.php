@extends('layouts.app')
@section('title','Edit Kategori DDC')
@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Kategori DDC</h1>
<form method="POST" action="{{ route('ddc-categories.update', $item) }}" class="card grid md:grid-cols-2 gap-3">@csrf @method('PUT')
    <div><label class="text-sm">Kode</label><input name="code" required value="{{ $item->code }}" class="form-input font-mono"></div>
    <div><label class="text-sm">Nama</label><input name="name" required value="{{ $item->name }}" class="form-input"></div>
    <div><label class="text-sm">Induk</label>
        <select name="parent_id" class="form-input">
            <option value="">— tidak ada induk</option>
            @foreach($parents as $p)<option value="{{ $p->id }}" @selected($item->parent_id == $p->id)>{{ $p->code }} — {{ $p->name }}</option>@endforeach
        </select>
    </div>
    <div><label class="text-sm">Urutan</label><input type="number" name="order" value="{{ $item->order }}" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Deskripsi</label><textarea name="description" class="form-input">{{ $item->description }}</textarea></div>
    <div class="md:col-span-2"><button class="btn-primary">Simpan</button></div>
</form>
@endsection
