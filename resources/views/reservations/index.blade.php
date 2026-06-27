@extends('layouts.app')
@section('title','Reservasi')
@section('content')
<h1 class="text-2xl font-bold mb-4">Reservasi Buku</h1>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Anggota</th><th class="px-3 py-2 text-left">Buku</th><th class="px-3 py-2 text-left">Antrean</th><th class="px-3 py-2 text-left">Reservasi</th><th class="px-3 py-2 text-left">Status</th><th></th></tr></thead>
<tbody>
@forelse($rows as $r)
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2">{{ $r->member?->user?->name }}</td>
        <td class="px-3 py-2">{{ $r->book?->title }}</td>
        <td class="px-3 py-2">#{{ $r->queue_position }}</td>
        <td class="px-3 py-2">{{ $r->reserved_at?->format('d M H:i') }}</td>
        <td class="px-3 py-2">{{ $r->status }}</td>
        <td class="px-3 py-2 text-right whitespace-nowrap">
            @if($r->status === 'pending')
                @can('reservation.verify')<form method="POST" action="{{ route('reservations.verify', $r) }}" class="inline">@csrf<button class="text-primary-600">Verifikasi</button></form>@endcan
                <form method="POST" action="{{ route('reservations.cancel', $r) }}" class="inline ml-2">@csrf<button class="text-red-600">Batalkan</button></form>
            @endif
        </td>
    </tr>
@empty
    <tr><td colspan="6" class="px-3 py-6 text-center text-gray-500">Belum ada reservasi.</td></tr>
@endforelse
</tbody>
</table>
<div class="mt-4">{{ $rows->links() }}</div>
</div>
@endsection
