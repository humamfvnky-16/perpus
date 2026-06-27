@extends('layouts.app')
@section('title','Rak')
@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Rak Buku</h1>
    <a href="{{ route('shelves.create') }}" class="btn-primary">+ Rak</a>
</div>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Kode</th><th class="px-3 py-2 text-left">Nama</th><th class="px-3 py-2 text-left">Lantai</th><th class="px-3 py-2 text-left">Ruang</th><th></th></tr></thead>
<tbody>
@foreach($items as $s)
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2 font-mono">{{ $s->code }}</td>
        <td class="px-3 py-2">{{ $s->name }}</td>
        <td class="px-3 py-2">{{ $s->floor }}</td>
        <td class="px-3 py-2">{{ $s->room }}</td>
        <td class="px-3 py-2 text-right">
            <a href="{{ route('shelves.edit', $s) }}" class="text-primary-600">Edit</a>
            <form action="{{ route('shelves.destroy', $s) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-red-600">Hapus</button></form>
        </td>
    </tr>
@endforeach
</tbody>
</table>
<div class="mt-4">{{ $items->links() }}</div>
</div>
@endsection
