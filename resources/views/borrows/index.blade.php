@extends('layouts.app')
@section('title','Peminjaman')
@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Peminjaman</h1>
    @can('borrow.create')<a href="{{ route('borrows.create') }}" class="btn-primary">+ Peminjaman Baru</a>@endcan
</div>
<form class="card mb-4 flex gap-3" method="get">
    <select name="status" class="form-input w-48">
        <option value="">Semua status</option>
        @foreach(['active','returned','overdue','lost','damaged'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ $s }}</option>@endforeach
    </select>
    <button class="btn-secondary">Filter</button>
</form>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Kode</th><th class="px-3 py-2 text-left">Anggota</th><th class="px-3 py-2 text-left">Buku</th><th class="px-3 py-2 text-left">Pinjam</th><th class="px-3 py-2 text-left">Jatuh Tempo</th><th class="px-3 py-2 text-left">Status</th><th></th></tr></thead>
<tbody>
@forelse($rows as $t)
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2 font-mono">{{ $t->code }}</td>
        <td class="px-3 py-2">{{ $t->member?->user?->name }}</td>
        <td class="px-3 py-2">{{ $t->book?->title }}</td>
        <td class="px-3 py-2">{{ $t->borrowed_at?->format('d M Y') }}</td>
        <td class="px-3 py-2 {{ $t->isOverdue() ? 'text-red-600 font-semibold' : '' }}">{{ $t->due_at?->format('d M Y') }}</td>
        <td class="px-3 py-2">{{ $t->status }}</td>
        <td class="px-3 py-2 text-right"><a href="{{ route('borrows.show', $t) }}" class="text-primary-600">Detail</a></td>
    </tr>
@empty
    <tr><td colspan="7" class="px-3 py-6 text-center text-gray-500">Belum ada transaksi.</td></tr>
@endforelse
</tbody>
</table>
<div class="mt-4">{{ $rows->links() }}</div>
</div>
@endsection
