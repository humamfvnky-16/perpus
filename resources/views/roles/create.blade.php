@extends('layouts.app')
@section('title','Tambah Role')
@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah Role</h1>
<form method="POST" action="{{ route('roles.store') }}" class="card space-y-3">@csrf
    <div><label class="text-sm">Nama Role</label><input name="name" required class="form-input"></div>
    <div>
        <label class="text-sm block mb-2">Permissions</label>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-1">
            @foreach($permissions as $p)
                <label class="flex items-center gap-2 text-xs"><input type="checkbox" name="permissions[]" value="{{ $p->name }}"> {{ $p->name }}</label>
            @endforeach
        </div>
    </div>
    <button class="btn-primary">Simpan</button>
</form>
@endsection
