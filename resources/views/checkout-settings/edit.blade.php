@extends('layouts.app')
@section('title','Setting Durasi Peminjaman')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-clock',
    'title' => 'Setting Durasi Peminjaman — '.$readingSpot->name,
    'desc'  => 'Atur lama pinjam, batas jumlah buku, dan denda untuk lokasi baca ini.',
])

<form method="POST" action="{{ route('checkout-settings.update', $readingSpot) }}">
    @csrf @method('PUT')

    <div class="card mb-6">
        <h2 class="font-bold text-lg mb-4">Durasi &amp; Batas Peminjaman</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Lama Pinjam (hari)</label>
                <input type="number" name="loan_days" min="1" max="365" required value="{{ $setting->loan_days ?? 7 }}" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Maks. Buku Dipinjam / Anggota</label>
                <input type="number" name="max_books" min="1" max="50" required value="{{ $setting->max_books ?? 3 }}" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Batas Perpanjangan</label>
                <input type="number" name="renew_limit" min="0" max="10" required value="{{ $setting->renew_limit ?? 1 }}" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Masa Berlaku Hold/Antrean (jam)</label>
                <input type="number" name="hold_expires_hours" min="1" max="720" required value="{{ $setting->hold_expires_hours ?? 24 }}" class="form-input mt-1">
            </div>
        </div>
    </div>

    <div class="card mb-6">
        <h2 class="font-bold text-lg mb-4">Denda</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Denda Harian (Rp)</label>
                <input type="number" name="daily_fine" min="0" required value="{{ $setting->daily_fine ?? 0 }}" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Denda Rusak (Rp)</label>
                <input type="number" name="damage_fine" min="0" required value="{{ $setting->damage_fine ?? 0 }}" class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Denda Hilang (Rp)</label>
                <input type="number" name="lost_fine" min="0" required value="{{ $setting->lost_fine ?? 0 }}" class="form-input mt-1">
            </div>
        </div>
    </div>

    <div class="flex flex-wrap gap-2">
        <button class="btn-primary"><i class="fas fa-save"></i> Simpan Pengaturan</button>
    </div>
</form>
@endsection
