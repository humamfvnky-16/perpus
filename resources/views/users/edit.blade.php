@extends('layouts.app')
@section('title','Edit User')
@section('content')
<h1 class="text-2xl font-bold mb-4">Edit User: {{ $user->name }}</h1>
<form method="POST" action="{{ route('users.update', $user) }}" class="card space-y-3">@csrf @method('PUT')
    <div><label class="text-sm">Nama</label><input name="name" required value="{{ $user->name }}" class="form-input"></div>
    <button class="btn-primary">Simpan</button>
</form>

<form method="POST" action="{{ route('users.syncRoles', $user) }}" class="card mt-4 space-y-3">@csrf
    <h2 class="font-semibold">Role</h2>
    @foreach($roles as $r)
        <label class="flex items-center gap-2"><input type="checkbox" name="roles[]" value="{{ $r->name }}" @checked($user->hasRole($r->name))> {{ $r->name }}</label>
    @endforeach
    <button class="btn-primary">Update Role</button>
</form>
@endsection
