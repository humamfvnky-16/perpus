@extends('layouts.app')
@section('title','Role & Permission')
@section('content')
<h1 class="text-2xl font-bold mb-4">Role & Permission</h1>
<div class="card">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Role</th><th class="px-3 py-2 text-left">Permissions</th></tr></thead>
<tbody>
@foreach($roles as $r)
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2 font-semibold">{{ $r->name }}</td>
        <td class="px-3 py-2 text-xs text-gray-500">{{ $r->permissions->pluck('name')->join(', ') }}</td>
    </tr>
@endforeach
</tbody>
</table>
</div>
@endsection
