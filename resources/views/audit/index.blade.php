@extends('layouts.app')
@section('title','Audit Log')
@section('content')
<h1 class="text-2xl font-bold mb-4">Audit Log</h1>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Waktu</th><th class="px-3 py-2 text-left">User</th><th class="px-3 py-2 text-left">Aksi</th><th class="px-3 py-2 text-left">IP</th></tr></thead>
<tbody>
@foreach($logs as $l)
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2">{{ $l->created_at?->format('d M Y H:i:s') }}</td>
        <td class="px-3 py-2">{{ $l->user?->name ?? '-' }}</td>
        <td class="px-3 py-2 font-mono text-xs">{{ $l->action }}</td>
        <td class="px-3 py-2 font-mono text-xs">{{ $l->ip_address }}</td>
    </tr>
@endforeach
</tbody>
</table>
<div class="mt-4">{{ $logs->links() }}</div>
</div>
@endsection
