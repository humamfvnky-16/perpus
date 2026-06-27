@extends('layouts.app')
@section('title', 'Manajemen Buku')
@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Manajemen Buku</h1>
    @can('book.create')<a href="{{ route('books.create') }}" class="btn-primary">+ Buku Baru</a>@endcan
</div>

<form class="card mb-4 flex flex-wrap gap-3" method="get">
    <input name="q" value="{{ request('q') }}" placeholder="Cari judul/ISBN..." class="form-input flex-1 min-w-48">
    <select name="status" class="form-input w-40">
        <option value="">Semua status</option>
        @foreach(['available','borrowed','reserved','maintenance','lost'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ $s }}</option>@endforeach
    </select>
    <button class="btn-secondary">Filter</button>
</form>

<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
    <thead class="bg-gray-50 dark:bg-gray-700/40">
        <tr><th class="px-3 py-2 text-left">Judul</th><th class="px-3 py-2 text-left">ISBN</th><th class="px-3 py-2 text-left">Kategori</th><th class="px-3 py-2 text-left">Stok</th><th class="px-3 py-2 text-left">Status</th><th></th></tr>
    </thead>
    <tbody>
    @forelse($books as $b)
        <tr class="border-t border-gray-100 dark:border-gray-700">
            <td class="px-3 py-2"><a href="{{ route('books.show', $b) }}" class="font-medium text-primary-600 hover:underline">{{ $b->title }}</a><br><span class="text-xs text-gray-500">{{ $b->authors->pluck('name')->join(', ') }}</span></td>
            <td class="px-3 py-2 font-mono">{{ $b->isbn }}</td>
            <td class="px-3 py-2">{{ $b->category?->name }}</td>
            <td class="px-3 py-2">{{ $b->available }}/{{ $b->stock }}</td>
            <td class="px-3 py-2"><span class="badge-{{ $b->status === 'available' ? 'green' : 'yellow' }}">{{ $b->status }}</span></td>
            <td class="px-3 py-2 text-right whitespace-nowrap">
                @can('book.update')<a href="{{ route('books.edit', $b) }}" class="text-primary-600">Edit</a>@endcan
                @can('book.delete')
                    <form action="{{ route('books.destroy', $b) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Hapus buku ini?')">@csrf @method('DELETE')<button class="text-red-600">Hapus</button></form>
                @endcan
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="px-3 py-6 text-center text-gray-500">Belum ada data buku.</td></tr>
    @endforelse
    </tbody>
</table>
<div class="mt-4">{{ $books->links() }}</div>
</div>
@endsection
