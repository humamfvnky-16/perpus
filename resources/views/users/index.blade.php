@extends('layouts.app')
@section('title','Manajemen User')
@section('content')
<h1 class="text-2xl font-bold mb-4">Manajemen User</h1>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Nama</th><th class="px-3 py-2 text-left">Email</th><th class="px-3 py-2 text-left">Role</th><th class="px-3 py-2 text-left">Aktif</th><th></th></tr></thead>
<tbody>
@foreach($users as $u)
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2">{{ $u->name }}</td>
        <td class="px-3 py-2">{{ $u->email }}</td>
        <td class="px-3 py-2">{{ $u->getRoleNames()->join(', ') }}</td>
        <td class="px-3 py-2">@if($u->is_active)<span class="badge-green">aktif</span>@else<span class="badge-red">nonaktif</span>@endif</td>
        <td class="px-3 py-2 text-right">
            <form method="POST" action="{{ route('users.toggleActive', $u) }}" class="inline">@csrf<button class="text-primary-600">{{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button></form>
        </td>
    </tr>
@endforeach
</tbody>
</table>
<div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection
