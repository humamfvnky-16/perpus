@extends('layouts.app')
@section('title', 'Edit Anggota')
@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Anggota</h1>
<form method="POST" action="{{ route('members.update', $member) }}" class="card grid md:grid-cols-2 gap-4">@csrf @method('PUT')
    <div><label class="text-sm">Kelas</label><input name="class" value="{{ $member->class }}" class="form-input"></div>
    <div><label class="text-sm">Jurusan</label><input name="major" value="{{ $member->major }}" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Alamat</label><textarea name="address" class="form-input" rows="2">{{ $member->address }}</textarea></div>
    <div><label class="text-sm">Berlaku Hingga</label><input type="date" name="expires_at" value="{{ $member->expires_at?->format('Y-m-d') }}" class="form-input"></div>
    <div><label class="text-sm">Aktif</label>
        <select name="is_active" class="form-input">
            <option value="1" @selected($member->is_active)>Aktif</option>
            <option value="0" @selected(!$member->is_active)>Nonaktif</option>
        </select>
    </div>
    <div class="md:col-span-2"><button class="btn-primary">Simpan</button></div>
</form>
@endsection
