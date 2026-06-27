@extends('layouts.app')
@section('title','Edit Reading Spot')
@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Reading Spot</h1>
<form method="POST" action="{{ route('reading-spots.update', $spot) }}" enctype="multipart/form-data" class="card grid md:grid-cols-2 gap-4">@csrf @method('PUT')
    <div><label class="text-sm">Nama</label><input name="name" required value="{{ $spot->name }}" class="form-input"></div>
    <div><label class="text-sm">Tipe</label>
        <select name="type" class="form-input">
            @foreach(['school'=>'Sekolah','library'=>'Perpustakaan','community'=>'Komunitas','public'=>'Umum'] as $v=>$t)
                <option value="{{ $v }}" @selected($spot->type===$v)>{{ $t }}</option>
            @endforeach
        </select>
    </div>
    <div><label class="text-sm">NPSN</label><input name="npsn" value="{{ $spot->npsn }}" class="form-input"></div>
    <div><label class="text-sm">Kota</label><input name="city" value="{{ $spot->city }}" class="form-input"></div>
    <div><label class="text-sm">Provinsi</label><input name="province" value="{{ $spot->province }}" class="form-input"></div>
    <div><label class="text-sm">Telepon</label><input name="phone" value="{{ $spot->phone }}" class="form-input"></div>
    <div><label class="text-sm">Email</label><input type="email" name="email" value="{{ $spot->email }}" class="form-input"></div>
    <div><label class="text-sm">Status</label>
        <select name="is_active" class="form-input">
            <option value="1" @selected($spot->is_active)>Aktif</option>
            <option value="0" @selected(!$spot->is_active)>Nonaktif</option>
        </select>
    </div>
    <div class="md:col-span-2"><label class="text-sm">Alamat</label><textarea name="address" class="form-input">{{ $spot->address }}</textarea></div>
    <div class="md:col-span-2"><label class="text-sm">Deskripsi</label><textarea name="description" class="form-input" rows="3">{{ $spot->description }}</textarea></div>
    <div class="md:col-span-2"><label class="text-sm">Logo baru</label><input type="file" name="logo" accept="image/*" class="form-input"></div>
    <div class="md:col-span-2 flex gap-2"><button class="btn-primary">Simpan</button><a href="{{ route('reading-spots.show', $spot) }}" class="btn-secondary">Batal</a></div>
</form>
@endsection
