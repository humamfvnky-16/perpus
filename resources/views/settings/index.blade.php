@extends('layouts.app')
@section('title','Pengaturan')
@section('content')
<h1 class="text-2xl font-bold mb-4">Pengaturan Sistem</h1>
<form method="POST" action="{{ route('settings.update') }}" class="space-y-4">@csrf @method('PUT')
    @forelse($settings as $group => $items)
        <div class="card">
            <h2 class="font-semibold uppercase text-sm text-gray-500 mb-3">{{ $group }}</h2>
            <div class="grid md:grid-cols-2 gap-4">
                @foreach($items as $s)
                <div>
                    <label class="text-sm">{{ $s->label ?? $s->key }}</label>
                    <input name="settings[{{ $s->key }}]" value="{{ $s->value }}" class="form-input">
                </div>
                @endforeach
            </div>
        </div>
    @empty
        <p class="text-gray-500">Tidak ada pengaturan.</p>
    @endforelse
    <button class="btn-primary">Simpan Pengaturan</button>
</form>
@endsection
