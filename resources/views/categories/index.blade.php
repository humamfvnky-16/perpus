@extends('layouts.app')
@section('title','Kategori')
@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Kategori Buku</h1>
    <a href="{{ route('categories.create') }}" class="btn-primary">+ Kategori</a>
</div>
<div class="card">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Nama</th><th class="px-3 py-2 text-left">Dewey</th><th class="px-3 py-2 text-left">Jumlah Buku</th><th></th></tr></thead>
<tbody>
@foreach($items as $c)
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2">{{ $c->name }}</td>
        <td class="px-3 py-2">{{ $c->dewey_code }}</td>
        <td class="px-3 py-2">{{ $c->books_count ?? 0 }}</td>
        <td class="px-3 py-2 text-right">
            <a href="{{ route('categories.edit', $c) }}" class="text-primary-600">Edit</a>
            <form action="{{ route('categories.destroy', $c) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-red-600">Hapus</button></form>
        </td>
    </tr>
@endforeach
</tbody>
</table>
</div>
@endsection
