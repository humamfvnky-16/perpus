@extends('layouts.app')
@section('title','E-Book')
@section('content')
<h1 class="text-2xl font-bold mb-4">Koleksi E-Book</h1>
<form class="card mb-4 flex gap-3" method="get">
    <input name="q" value="{{ request('q') }}" placeholder="Cari e-book..." class="form-input flex-1">
    <select name="format" class="form-input w-36">
        <option value="">Semua</option>
        @foreach(['pdf','epub','docx','pptx','audio','video'] as $f)<option value="{{ $f }}" @selected(request('format')===$f)>{{ $f }}</option>@endforeach
    </select>
    <button class="btn-secondary">Filter</button>
</form>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @forelse($items as $e)
        <a href="{{ route('ebooks.read', $e) }}" class="card hover:shadow-lg">
            <div class="text-center text-3xl mb-2">📘</div>
            <p class="font-medium text-sm line-clamp-2">{{ $e->title }}</p>
            <p class="text-xs text-gray-500 uppercase">{{ $e->format }}</p>
            <p class="text-xs text-gray-500">{{ $e->view_count }} pembaca</p>
        </a>
    @empty
        <p class="col-span-4 text-gray-500 text-sm py-12 text-center">Belum ada e-book.</p>
    @endforelse
</div>
<div class="mt-4">{{ $items->links() }}</div>
@endsection
