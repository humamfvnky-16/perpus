@extends('layouts.app')
@section('title','Penulis')
@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Penulis</h1>
    <a href="{{ route('authors.create') }}" class="btn-primary">+ Penulis</a>
</div>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Nama</th><th class="px-3 py-2 text-left">Nationality</th><th></th></tr></thead>
<tbody>
@foreach($items as $a)
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2">{{ $a->name }}</td>
        <td class="px-3 py-2">{{ $a->nationality }}</td>
        <td class="px-3 py-2 text-right">
            <a href="{{ route('authors.edit', $a) }}" class="text-primary-600">Edit</a>
            <form action="{{ route('authors.destroy', $a) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-red-600">Hapus</button></form>
        </td>
    </tr>
@endforeach
</tbody>
</table>
<div class="mt-4">{{ $items->links() }}</div>
</div>
@endsection
