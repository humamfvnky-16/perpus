@extends('layouts.app')
@section('title', 'Anggota')
@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Manajemen Anggota</h1>
    @can('member.create')<a href="{{ route('members.create') }}" class="btn-primary">+ Anggota Baru</a>@endcan
</div>
<form class="card mb-4 flex gap-3" method="get">
    <input name="q" value="{{ request('q') }}" placeholder="Nama / NIS / email..." class="form-input flex-1">
    <select name="type" class="form-input w-40">
        <option value="">Semua</option>
        <option value="student" @selected(request('type')==='student')>Siswa</option>
        <option value="teacher" @selected(request('type')==='teacher')>Guru</option>
        <option value="public"  @selected(request('type')==='public')>Umum</option>
    </select>
    <button class="btn-secondary">Cari</button>
</form>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr>
    <th class="px-3 py-2 text-left">No</th><th class="px-3 py-2 text-left">Nama</th><th class="px-3 py-2 text-left">NIS/NIP</th><th class="px-3 py-2 text-left">Tipe</th><th class="px-3 py-2 text-left">Aktif</th><th></th>
</tr></thead>
<tbody>
@forelse($members as $m)
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2 font-mono">{{ $m->member_no }}</td>
        <td class="px-3 py-2">{{ $m->user?->name }}<br><span class="text-xs text-gray-500">{{ $m->user?->email }}</span></td>
        <td class="px-3 py-2">{{ $m->nis_nip }}</td>
        <td class="px-3 py-2">{{ $m->type }}</td>
        <td class="px-3 py-2">@if($m->is_active)<span class="badge-green">aktif</span>@else<span class="badge-red">tidak</span>@endif</td>
        <td class="px-3 py-2 text-right"><a href="{{ route('members.show', $m) }}" class="text-primary-600">Detail</a></td>
    </tr>
@empty
    <tr><td colspan="6" class="px-3 py-6 text-center text-gray-500">Belum ada anggota.</td></tr>
@endforelse
</tbody>
</table>
<div class="mt-4">{{ $members->links() }}</div>
</div>
@endsection
