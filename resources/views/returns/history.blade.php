@extends('layouts.app')
@section('title','Riwayat Pengembalian')
@section('content')
<h1 class="text-2xl font-bold mb-4">Riwayat Pengembalian</h1>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Kode</th><th class="px-3 py-2 text-left">Anggota</th><th class="px-3 py-2 text-left">Buku</th><th class="px-3 py-2 text-left">Kembali</th><th class="px-3 py-2 text-left">Kondisi</th><th class="px-3 py-2 text-left">Denda</th></tr></thead>
<tbody>
@foreach($rows as $t)
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2 font-mono">{{ $t->code }}</td>
        <td class="px-3 py-2">{{ $t->member?->user?->name }}</td>
        <td class="px-3 py-2">{{ $t->book?->title }}</td>
        <td class="px-3 py-2">{{ $t->returned_at?->format('d M Y') }}</td>
        <td class="px-3 py-2">{{ $t->return_?->condition }}</td>
        <td class="px-3 py-2">Rp {{ number_format($t->return_?->fine_amount ?? 0, 0, ',', '.') }}</td>
    </tr>
@endforeach
</tbody>
</table>
<div class="mt-4">{{ $rows->links() }}</div>
</div>
@endsection
