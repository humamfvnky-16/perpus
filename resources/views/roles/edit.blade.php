@extends('layouts.app')
@section('title','Edit Role')
@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Role: {{ $role->name }}</h1>
<form method="POST" action="{{ route('roles.update', $role) }}" class="card space-y-3">@csrf @method('PUT')
    <div><label class="text-sm">Nama Role</label><input name="name" required value="{{ $role->name }}" class="form-input"></div>
    <div>
        <label class="text-sm block mb-2">Permissions</label>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-1">
            @foreach($permissions as $p)
                <label class="flex items-center gap-2 text-xs"><input type="checkbox" name="permissions[]" value="{{ $p->name }}" @checked($role->permissions->contains('name', $p->name))> {{ $p->name }}</label>
            @endforeach
        </div>
    </div>
    <button class="btn-primary">Simpan</button>
</form>
@endsection
