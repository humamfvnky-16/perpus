@extends('layouts.app')
@section('title','Riwayat Pengunjung')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-user-clock',
    'title' => 'Riwayat Pengunjung',
    'desc'  => 'Riwayat kunjungan pada laman perpustakaan.',
])

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Pengunjung</th>
                <th>Halaman</th>
                <th>IP</th>
                <th>User Agent</th>
            </tr>
        </thead>
        <tbody>
        @forelse($logs as $l)
            <tr>
                <td class="whitespace-nowrap">{{ $l->created_at?->format('d M Y H:i:s') }}</td>
                <td>{{ $l->user?->name ?? 'Tamu' }}</td>
                <td class="font-mono text-xs">{{ $l->path }}</td>
                <td class="font-mono text-xs">{{ $l->ip_address }}</td>
                <td class="text-xs text-slate-500 truncate max-w-xs block" title="{{ $l->user_agent }}">{{ $l->user_agent }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-slate-500 py-10">
                    <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                    Belum ada data.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-4 px-2">{{ $logs->links() }}</div>
</div>
@endsection
