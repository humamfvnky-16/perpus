@extends('layouts.app')
@section('title', 'Daftar')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 p-4">
    <div class="card w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4">Daftar Anggota</h1>
        @if($errors->any())<div class="badge-red mb-3 block">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('register') }}" class="space-y-3">@csrf
            <div><label class="text-sm">Nama Lengkap</label><input name="name" required value="{{ old('name') }}" class="form-input"></div>
            <div><label class="text-sm">Email</label><input type="email" name="email" required value="{{ old('email') }}" class="form-input"></div>
            <div><label class="text-sm">Password</label><input type="password" name="password" required class="form-input"></div>
            <div><label class="text-sm">Konfirmasi Password</label><input type="password" name="password_confirmation" required class="form-input"></div>
            <div><label class="text-sm">Saya adalah</label>
                <select name="type" class="form-input">
                    <option value="student">Siswa</option>
                    <option value="teacher">Guru</option>
                    <option value="public">Umum</option>
                </select>
            </div>
            <button class="btn-primary w-full">Daftar</button>
        </form>
        <p class="mt-4 text-sm text-center">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary-600 hover:underline">Masuk</a></p>
    </div>
</div>
@endsection
