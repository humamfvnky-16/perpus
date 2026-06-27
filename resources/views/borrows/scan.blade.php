@extends('layouts.app')
@section('title','Scan Barcode/QR')
@section('content')
<h1 class="text-2xl font-bold mb-4">Scan Barcode atau QR Code</h1>
<form action="{{ route('borrows.lookup') }}" method="POST" class="card space-y-3">@csrf
    <div>
        <label class="text-sm">Kode atau Barcode</label>
        <input name="code" autofocus class="form-input font-mono" placeholder="Arahkan scanner ke barcode buku/anggota...">
    </div>
    <p class="text-xs text-gray-500">Scanner barcode USB akan otomatis mengirim Enter setelah scan. Untuk QR, gunakan kamera HP via integrasi web API.</p>
    <button class="btn-primary">Cari</button>
</form>
@endsection
