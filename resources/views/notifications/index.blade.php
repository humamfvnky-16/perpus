@extends('layouts.app')
@section('title','Notifikasi')
@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Notifikasi</h1>
    <form method="POST" action="{{ route('notifications.readAll') }}">@csrf<button class="btn-secondary">Tandai Semua Dibaca</button></form>
</div>
<div class="card space-y-2">
    @forelse($items as $n)
        <div class="flex justify-between p-3 rounded-lg {{ $n->read_at ? '' : 'bg-primary-50 dark:bg-gray-700' }}">
            <div>
                <p class="text-sm">{{ $n->data['message'] ?? '' }}</p>
                <p class="text-xs text-gray-500">{{ $n->created_at?->diffForHumans() }}</p>
            </div>
            @if(!$n->read_at)
                <form method="POST" action="{{ route('notifications.read', $n->id) }}">@csrf<button class="text-primary-600 text-sm">Tandai</button></form>
            @endif
        </div>
    @empty
        <p class="text-gray-500 text-sm py-6 text-center">Tidak ada notifikasi.</p>
    @endforelse
</div>
@endsection
