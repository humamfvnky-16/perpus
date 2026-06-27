@extends('layouts.app')
@section('title','Tambah Kategori DDC')
@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah Kategori DDC</h1>
<form method="POST" action="{{ route('ddc-categories.store') }}" class="card grid md:grid-cols-2 gap-3">@csrf
    <div><label class="text-sm">Kode (000, 100, ...)</label><input name="code" required class="form-input font-mono"></div>
    <div><label class="text-sm">Nama</label><input name="name" required class="form-input"></div>
    <div><label class="text-sm">Induk (opsional)</label>
        <select name="parent_id" class="form-input">
            <option value="">— tidak ada induk</option>
            @foreach($parents as $p)<option value="{{ $p->id }}">{{ $p->code }} — {{ $p->name }}</option>@endforeach
        </select>
    </div>
    <div><label class="text-sm">Urutan</label><input type="number" name="order" value="0" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Deskripsi</label><textarea name="description" class="form-input"></textarea></div>
    <div class="md:col-span-2"><button class="btn-primary">Simpan</button></div>
</form>
@endsection
