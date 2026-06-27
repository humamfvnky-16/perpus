@extends('layouts.app')
@section('title', $user->name)
@section('content')
<div class="card max-w-2xl">
    <h1 class="text-xl font-bold">{{ $user->name }}</h1>
    <p class="text-sm text-gray-500 mb-3">{{ $user->email }}</p>
    <dl class="grid grid-cols-2 gap-2 text-sm">
        <dt class="text-gray-500">Role</dt><dd>{{ $user->getRoleNames()->join(', ') }}</dd>
        <dt class="text-gray-500">Aktif</dt><dd>{{ $user->is_active ? 'Ya' : 'Tidak' }}</dd>
        <dt class="text-gray-500">Login Terakhir</dt><dd>{{ $user->last_login_at?->format('d M Y H:i') ?? '-' }}</dd>
        <dt class="text-gray-500">IP Terakhir</dt><dd>{{ $user->last_login_ip ?? '-' }}</dd>
    </dl>
    <a href="{{ route('users.edit', $user) }}" class="btn-secondary mt-4 inline-block">Edit</a>
</div>
@endsection
