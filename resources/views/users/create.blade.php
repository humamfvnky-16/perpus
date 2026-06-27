@extends('layouts.app')
@section('title','Tambah User')
@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah User</h1>
<form method="POST" action="{{ route('users.store') }}" class="card space-y-3">@csrf
    <div><label class="text-sm">Nama</label><input name="name" required class="form-input"></div>
    <div><label class="text-sm">Email</label><input type="email" name="email" required class="form-input"></div>
    <div><label class="text-sm">Password</label><input type="password" name="password" required class="form-input"></div>
    <div><label class="text-sm">Role</label>
        <select name="role" class="form-input" required>
            @foreach($roles as $r)<option value="{{ $r->name }}">{{ $r->name }}</option>@endforeach
        </select>
    </div>
    <button class="btn-primary">Simpan</button>
</form>
@endsection
