@extends('layouts.app')
@section('title','Lupa Password')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 p-4">
    <div class="card w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4">Lupa Password</h1>
        @if(session('status'))<div class="badge-green mb-3 block">{{ session('status') }}</div>@endif
        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">@csrf
            <div><label class="text-sm">Email</label><input type="email" name="email" required class="form-input"></div>
            <button class="btn-primary w-full">Kirim Link Reset</button>
        </form>
        <p class="mt-4 text-sm text-center"><a href="{{ route('login') }}" class="text-primary-600 hover:underline">Kembali ke login</a></p>
    </div>
</div>
@endsection
