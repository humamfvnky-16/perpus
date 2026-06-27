@extends('layouts.app')
@section('title', 'Profil')
@section('content')
<h1 class="text-2xl font-bold mb-4">Profil Saya</h1>

<div class="grid md:grid-cols-2 gap-6">
    <div class="card">
        <h2 class="font-semibold mb-3">Informasi Akun</h2>
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-3">@csrf @method('PATCH')
            <div><label class="text-sm">Nama</label><input name="name" value="{{ old('name', auth()->user()->name) }}" required class="form-input"></div>
            <div><label class="text-sm">Email</label><input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="form-input"></div>
            <div><label class="text-sm">No. HP</label><input name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="form-input"></div>
            <button class="btn-primary">Simpan</button>
        </form>
    </div>

    <div class="card">
        <h2 class="font-semibold mb-3">Ubah Password</h2>
        <form method="POST" action="{{ route('profile.password') }}" class="space-y-3">@csrf @method('PATCH')
            <div><label class="text-sm">Password Saat Ini</label><input type="password" name="current_password" required class="form-input"></div>
            <div><label class="text-sm">Password Baru</label><input type="password" name="password" required class="form-input"></div>
            <div><label class="text-sm">Konfirmasi</label><input type="password" name="password_confirmation" required class="form-input"></div>
            <button class="btn-primary">Update Password</button>
        </form>
    </div>
</div>
@endsection
