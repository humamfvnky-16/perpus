@extends('layouts.app')
@section('title','QR Code Buku')
@section('content')
<div class="card max-w-md">
    <h1 class="text-xl font-bold mb-2">{{ $book->title }}</h1>
    <p class="text-sm text-gray-500 mb-4">ISBN: {{ $book->isbn }}</p>
    <div class="text-center p-6 border-2 border-dashed border-gray-300 rounded">
        <p class="font-mono">{{ $book->qr_code }}</p>
        <p class="text-xs mt-2 text-gray-500">Gunakan paket simplesoftwareio/simple-qrcode: <code>{!! '{!! QrCode::size(200)->generate($book->qr_code) !!}' !!}</code></p>
    </div>
    <button onclick="window.print()" class="btn-primary w-full mt-4">Cetak</button>
</div>
@endsection
