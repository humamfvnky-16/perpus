@extends('layouts.app')
@section('title','Penerbit')
@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Penerbit</h1>
    <a href="{{ route('publishers.create') }}" class="btn-primary">+ Penerbit</a>
</div>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Nama</th><th class="px-3 py-2 text-left">Kota</th><th class="px-3 py-2 text-left">Website</th><th></th></tr></thead>
<tbody>
@foreach($items as $p)
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2">{{ $p->name }}</td>
        <td class="px-3 py-2">{{ $p->city }}</td>
        <td class="px-3 py-2 text-xs">{{ $p->website }}</td>
        <td class="px-3 py-2 text-right">
            <a href="{{ route('publishers.edit', $p) }}" class="text-primary-600">Edit</a>
            <form action="{{ route('publishers.destroy', $p) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-red-600">Hapus</button></form>
        </td>
    </tr>
@endforeach
</tbody>
</table>
<div class="mt-4">{{ $items->links() }}</div>
</div>
@endsection
