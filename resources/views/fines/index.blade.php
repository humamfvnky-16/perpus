@extends('layouts.app')
@section('title','Denda')
@section('content')
<h1 class="text-2xl font-bold mb-4">Denda</h1>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Anggota</th><th class="px-3 py-2 text-left">Tipe</th><th class="px-3 py-2 text-left">Jumlah</th><th class="px-3 py-2 text-left">Dibayar</th><th class="px-3 py-2 text-left">Status</th><th></th></tr></thead>
<tbody>
@forelse($rows as $f)
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2">{{ $f->member?->user?->name }}</td>
        <td class="px-3 py-2">{{ $f->type }}</td>
        <td class="px-3 py-2">Rp {{ number_format($f->amount,0,',','.') }}</td>
        <td class="px-3 py-2">Rp {{ number_format($f->paid_amount,0,',','.') }}</td>
        <td class="px-3 py-2">{{ $f->status }}</td>
        <td class="px-3 py-2 text-right"><a href="{{ route('fines.show', $f) }}" class="text-primary-600">Detail</a></td>
    </tr>
@empty
    <tr><td colspan="6" class="px-3 py-6 text-center text-gray-500">Tidak ada denda.</td></tr>
@endforelse
</tbody>
</table>
<div class="mt-4">{{ $rows->links() }}</div>
</div>
@endsection
