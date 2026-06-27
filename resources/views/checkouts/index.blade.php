@extends('layouts.app')
@section('title','Checkout Buku Fisik')
@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Checkout Buku Fisik</h1>
    @can('borrow.create')<a href="{{ route('checkouts.create') }}" class="btn-primary">+ Checkout Baru</a>@endcan
</div>
<form method="get" class="card mb-4 flex gap-3">
    <select name="status" class="form-input w-48">
        <option value="">Semua</option>
        <option value="active" @selected(request('status')==='active')>Aktif</option>
        <option value="returned" @selected(request('status')==='returned')>Sudah Kembali</option>
        <option value="overdue" @selected(request('status')==='overdue')>Terlambat</option>
    </select>
    <button class="btn-secondary">Filter</button>
</form>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr>
    <th class="px-3 py-2 text-left">Kode</th>
    <th class="px-3 py-2 text-left">Anggota</th>
    <th class="px-3 py-2 text-left">Reading Spot</th>
    <th class="px-3 py-2 text-left">Buku</th>
    <th class="px-3 py-2 text-left">Pinjam</th>
    <th class="px-3 py-2 text-left">Jatuh Tempo</th>
    <th class="px-3 py-2 text-left">Status</th>
    <th></th>
</tr></thead>
<tbody>
@forelse($rows as $c)
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2 font-mono">{{ $c->code }}</td>
        <td class="px-3 py-2">{{ $c->user?->name }}</td>
        <td class="px-3 py-2 text-xs">{{ $c->readingSpot?->name }}</td>
        <td class="px-3 py-2 text-xs">{{ $c->offlineBookCopies->pluck('offlineBook.title')->join(', ') }}</td>
        <td class="px-3 py-2">{{ $c->start_time?->format('d M Y') }}</td>
        <td class="px-3 py-2 {{ $c->isOverdue() ? 'text-red-600 font-semibold' : '' }}">{{ $c->end_time?->format('d M Y') }}</td>
        <td class="px-3 py-2">
            @if($c->is_returned)<span class="badge-green">kembali</span>
            @elseif($c->isOverdue())<span class="badge-red">terlambat</span>
            @else<span class="badge-yellow">aktif</span>@endif
        </td>
        <td class="px-3 py-2 text-right"><a href="{{ route('checkouts.show', $c) }}" class="text-primary-600">Detail</a></td>
    </tr>
@empty
    <tr><td colspan="8" class="px-3 py-6 text-center text-gray-500">Belum ada checkout.</td></tr>
@endforelse
</tbody>
</table>
<div class="mt-4">{{ $rows->links() }}</div>
</div>
@endsection
