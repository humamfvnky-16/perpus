@extends('layouts.app')
@section('title','Reset Password')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 p-4">
    <div class="card w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4">Reset Password</h1>
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">@csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div><label class="text-sm">Email</label><input type="email" name="email" required class="form-input"></div>
            <div><label class="text-sm">Password Baru</label><input type="password" name="password" required class="form-input"></div>
            <div><label class="text-sm">Konfirmasi</label><input type="password" name="password_confirmation" required class="form-input"></div>
            <button class="btn-primary w-full">Reset Password</button>
        </form>
    </div>
</div>
@endsection
