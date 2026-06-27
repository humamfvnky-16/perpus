@extends('layouts.app')
@section('title','Backup Database')
@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Backup Database</h1>
    <form method="POST" action="{{ route('backups.run') }}">@csrf<button class="btn-primary">Buat Backup Sekarang</button></form>
</div>
<div class="card">
    <p class="text-sm text-gray-500">Fitur backup memerlukan paket <code>spatie/laravel-backup</code> dan konfigurasi storage. Lihat README.</p>
</div>
@endsection
