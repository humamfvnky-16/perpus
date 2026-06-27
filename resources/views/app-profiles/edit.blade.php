@extends('layouts.app')
@section('title','Profil Aplikasi')
@section('content')
<h1 class="text-2xl font-bold mb-4">Profil & Branding — {{ $readingSpot->name }}</h1>
<form method="POST" action="{{ route('app-profiles.update', $readingSpot) }}" enctype="multipart/form-data" class="card grid md:grid-cols-2 gap-4">@csrf @method('PUT')
    <div><label class="text-sm">Nama Aplikasi</label><input name="app_name" required value="{{ $profile->app_name }}" class="form-input"></div>
    <div><label class="text-sm">Email Kontak</label><input type="email" name="contact_email" value="{{ $profile->contact_email }}" class="form-input"></div>
    <div><label class="text-sm">Telepon Kontak</label><input name="contact_phone" value="{{ $profile->contact_phone }}" class="form-input"></div>
    <div><label class="text-sm">Warna Utama</label><input type="color" name="primary_color" value="{{ $profile->primary_color }}" class="form-input h-10"></div>
    <div><label class="text-sm">Warna Sekunder</label><input type="color" name="secondary_color" value="{{ $profile->secondary_color }}" class="form-input h-10"></div>
    <div><label class="text-sm">Logo</label><input type="file" name="logo" accept="image/*" class="form-input"></div>
    <div><label class="text-sm">Favicon</label><input type="file" name="favicon" class="form-input"></div>
    <div><label class="text-sm">Facebook</label><input name="facebook" value="{{ $profile->facebook }}" class="form-input"></div>
    <div><label class="text-sm">Instagram</label><input name="instagram" value="{{ $profile->instagram }}" class="form-input"></div>
    <div><label class="text-sm">Twitter</label><input name="twitter" value="{{ $profile->twitter }}" class="form-input"></div>
    <div><label class="text-sm">YouTube</label><input name="youtube" value="{{ $profile->youtube }}" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Tentang</label><textarea name="about" class="form-input" rows="3">{{ $profile->about }}</textarea></div>
    <div class="md:col-span-2"><label class="text-sm">Syarat & Ketentuan</label><textarea name="terms" class="form-input" rows="4">{{ $profile->terms }}</textarea></div>
    <div class="md:col-span-2"><label class="text-sm">Kebijakan Privasi</label><textarea name="privacy_policy" class="form-input" rows="4">{{ $profile->privacy_policy }}</textarea></div>
    <div class="md:col-span-2"><button class="btn-primary">Simpan Profil</button></div>
</form>
@endsection
