@extends('layouts.app')
@section('title', $ebook->title)
@section('content')
<div class="flex items-center justify-between mb-3">
    <h1 class="text-xl font-bold">{{ $ebook->title }}</h1>
    <a href="{{ route('ebooks.index') }}" class="btn-secondary">Kembali</a>
</div>
<div class="card">
    @if($ebook->format === 'pdf')
        <iframe src="{{ asset('storage/'.$ebook->file_path) }}" class="w-full h-[80vh] rounded border"></iframe>
    @elseif($ebook->format === 'audio')
        <audio controls class="w-full"><source src="{{ asset('storage/'.$ebook->file_path) }}"></audio>
    @elseif($ebook->format === 'video')
        <video controls class="w-full rounded"><source src="{{ asset('storage/'.$ebook->file_path) }}"></video>
    @else
        <a href="{{ asset('storage/'.$ebook->file_path) }}" class="btn-primary">Buka File ({{ strtoupper($ebook->format) }})</a>
    @endif
</div>
@endsection
