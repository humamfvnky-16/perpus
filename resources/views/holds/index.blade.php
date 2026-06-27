@extends('layouts.app')
@section('title','Hold / Penangguhan')
@section('content')
<h1 class="text-2xl font-bold mb-4">Hold / Penangguhan Buku Fisik</h1>
<form method="get" class="card mb-4 flex gap-3">
    <select name="status" class="form-input w-48">
        <option value="">Semua status</option>
        @foreach(['active','fulfilled','cancelled','expired'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ $s }}</option>@endforeach
    </select>
    <button class="btn-secondary">Filter</button>
</form>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr>
    <th class="px-3 py-2 text-left">Anggota</th>
    <th class="px-3 py-2 text-left">Reading Spot</th>
    <th class="px-3 py-2 text-left">Buku</th>
    <th class="px-3 py-2 text-left">Hold</th>
    <th class="px-3 py-2 text-left">Kedaluwarsa</th>
    <th class="px-3 py-2 text-left">Status</th>
    <th></th>
</tr></thead>
<tbody>
@forelse($rows as $h)
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2">{{ $h->user?->name }}</td>
        <td class="px-3 py-2 text-xs">{{ $h->readingSpot?->name }}</td>
        <td class="px-3 py-2 text-xs">{{ $h->offlineBookCopies->pluck('offlineBook.title')->join(', ') }}</td>
        <td class="px-3 py-2">{{ $h->hold_at?->format('d M H:i') }}</td>
        <td class="px-3 py-2">{{ $h->expires_at?->format('d M H:i') }}</td>
        <td class="px-3 py-2">{{ $h->status }}</td>
        <td class="px-3 py-2 text-right whitespace-nowrap">
            @if($h->status === 'active')
                @can('borrow.return')<form method="POST" action="{{ route('holds.fulfill', $h) }}" class="inline">@csrf<button class="text-primary-600">Checkout</button></form>@endcan
                <form method="POST" action="{{ route('holds.cancel', $h) }}" class="inline ml-2">@csrf<button class="text-red-600">Batalkan</button></form>
            @endif
        </td>
    </tr>
@empty
    <tr><td colspan="7" class="px-3 py-6 text-center text-gray-500">Belum ada hold.</td></tr>
@endforelse
</tbody>
</table>
<div class="mt-4">{{ $rows->links() }}</div>
</div>
@endsection
