@extends('layouts.app')
@section('title', '404 — Tidak Ditemukan')
@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-primary-600">404</h1>
        <p class="text-lg text-gray-600 dark:text-gray-300 mt-2">Halaman tidak ditemukan.</p>
        <a href="{{ url('/') }}" class="btn-primary mt-6 inline-block">Kembali ke Beranda</a>
    </div>
</div>
@endsection
