@extends('layouts.app')
@section('title','Buku Fisik')
@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Manajemen Buku Fisik</h1>
    @can('book.create')<a href="{{ route('offline-books.create') }}" class="btn-primary">+ Buku Fisik</a>@endcan
</div>
<form method="get" class="card mb-4 flex flex-wrap gap-3">
    <input name="q" value="{{ request('q') }}" placeholder="Cari judul/ISBN..." class="form-input flex-1 min-w-48">
    <select name="reading_spot" class="form-input w-48">
        <option value="">Semua Reading Spot</option>
        @foreach($spots as $s)<option value="{{ $s->id }}" @selected(request('reading_spot')==$s->id)>{{ $s->name }}</option>@endforeach
    </select>
    <button class="btn-secondary">Filter</button>
</form>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr>
    <th class="px-3 py-2 text-left">Judul</th>
    <th class="px-3 py-2 text-left">DDC</th>
    <th class="px-3 py-2 text-left">Reading Spot</th>
    <th class="px-3 py-2 text-left">Kopi</th>
    <th class="px-3 py-2 text-left">Sumber</th>
    <th></th>
</tr></thead>
<tbody>
@forelse($items as $b)
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2">
            <a href="{{ route('offline-books.show', $b) }}" class="font-medium text-primary-600 hover:underline">{{ $b->title }}</a>
            <br><span class="text-xs text-gray-500">{{ $b->authors->pluck('name')->join(', ') }}</span>
        </td>
        <td class="px-3 py-2 font-mono text-xs">{{ $b->ddcCategory?->code }}</td>
        <td class="px-3 py-2 text-xs">{{ $b->readingSpot?->name }}</td>
        <td class="px-3 py-2">{{ $b->copies_count ?? $b->copies()->count() }}</td>
        <td class="px-3 py-2">{{ $b->source }}</td>
        <td class="px-3 py-2 text-right whitespace-nowrap">
            @can('book.update')<a href="{{ route('offline-books.edit', $b) }}" class="text-primary-600">Edit</a>@endcan
            @can('book.delete')
                <form action="{{ route('offline-books.destroy', $b) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Hapus buku ini & semua kopinya?')">@csrf @method('DELETE')<button class="text-red-600">Hapus</button></form>
            @endcan
        </td>
    </tr>
@empty
    <tr><td colspan="6" class="px-3 py-6 text-center text-gray-500">Belum ada buku fisik.</td></tr>
@endforelse
</tbody>
</table>
<div class="mt-4">{{ $items->links() }}</div>
</div>
@endsection
