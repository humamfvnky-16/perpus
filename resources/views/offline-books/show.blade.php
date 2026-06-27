@extends('layouts.app')
@section('title', $book->title)
@section('content')
<div class="grid md:grid-cols-3 gap-6">
    <div class="card md:col-span-1">
        <div class="aspect-[3/4] bg-gray-200 dark:bg-gray-700 rounded-lg mb-4 flex items-center justify-center text-5xl">
            @if($book->cover)<img src="{{ asset('storage/'.$book->cover) }}" class="w-full h-full object-cover rounded-lg">@else 📕 @endif
        </div>
        <dl class="text-sm space-y-1">
            <div class="flex justify-between"><dt class="text-gray-500">ISBN</dt><dd class="font-mono">{{ $book->isbn ?: '-' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Penerbit</dt><dd>{{ $book->publisher?->name ?? '-' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Tahun</dt><dd>{{ $book->year_published }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">DDC</dt><dd>{{ $book->ddcCategory?->code }} {{ $book->ddcCategory?->name }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Sumber</dt><dd>{{ $book->source }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Reading Spot</dt><dd>{{ $book->readingSpot?->name }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Total Kopi</dt><dd>{{ $book->copies->count() }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Tersedia</dt><dd class="badge-green">{{ $book->availableCopiesCount() }}</dd></div>
        </dl>
        @can('book.update')
        <hr class="my-3 border-gray-200 dark:border-gray-700">
        <form method="POST" action="{{ route('offline-books.addCopy', $book) }}" class="space-y-2">@csrf
            <p class="text-sm font-semibold">Tambah Kopi Baru</p>
            <div class="flex gap-2">
                <input type="number" name="count" value="1" min="1" max="100" class="form-input">
                <select name="condition" class="form-input">
                    <option value="new">Baru</option><option value="good">Baik</option>
                </select>
            </div>
            <button class="btn-secondary w-full">Tambah Kopi</button>
        </form>
        @endcan
    </div>

    <div class="card md:col-span-2">
        <h1 class="text-2xl font-bold">{{ $book->title }}</h1>
        <p class="text-gray-500 mb-3">{{ $book->subtitle }}</p>
        <p class="text-sm text-gray-500">Penulis: {{ $book->authors->pluck('name')->join(', ') ?: '-' }}</p>
        <p class="text-sm text-gray-500">Kategori: {{ $book->categories->pluck('name')->join(', ') ?: '-' }}</p>
        @if($book->synopsis)
            <h3 class="font-semibold mt-4 mb-2">Sinopsis</h3>
            <p class="text-sm">{{ $book->synopsis }}</p>
        @endif

        <h3 class="font-semibold mt-6 mb-3">Daftar Kopi Fisik</h3>
        <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
        <thead class="bg-gray-50 dark:bg-gray-700/40"><tr>
            <th class="px-3 py-2 text-left">Kode Katalog</th>
            <th class="px-3 py-2 text-left">Barcode</th>
            <th class="px-3 py-2 text-left">Rak</th>
            <th class="px-3 py-2 text-left">Kondisi</th>
            <th class="px-3 py-2 text-left">Status</th>
        </tr></thead>
        <tbody>
        @forelse($book->copies as $c)
            <tr class="border-t border-gray-100 dark:border-gray-700">
                <td class="px-3 py-2 font-mono text-xs">{{ $c->catalog_code }}</td>
                <td class="px-3 py-2 font-mono text-xs">{{ $c->barcode }}</td>
                <td class="px-3 py-2">{{ $c->shelf?->code }}</td>
                <td class="px-3 py-2">{{ $c->condition }}</td>
                <td class="px-3 py-2">@if($c->isAvailable())<span class="badge-green">tersedia</span>@else<span class="badge-yellow">dipinjam</span>@endif</td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-gray-500 py-3">Belum ada kopi.</td></tr>
        @endforelse
        </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
