@extends('layouts.app')
@section('title', $member->user?->name)
@section('content')
<div class="grid md:grid-cols-3 gap-6">
    <div class="card">
        <h2 class="text-xl font-bold">{{ $member->user?->name }}</h2>
        <p class="text-sm text-gray-500">{{ $member->member_no }} · {{ $member->type }}</p>
        <hr class="my-3 border-gray-200 dark:border-gray-700">
        <dl class="text-sm space-y-1">
            <div class="flex justify-between"><dt class="text-gray-500">NIS/NIP</dt><dd>{{ $member->nis_nip ?: '-' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Kelas/Jurusan</dt><dd>{{ trim($member->class.' '.$member->major) ?: '-' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Bergabung</dt><dd>{{ $member->joined_at?->format('d M Y') }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Berlaku Hingga</dt><dd>{{ $member->expires_at?->format('d M Y') }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Pinjaman Aktif</dt><dd>{{ $member->active_borrow_count }}/{{ config('library.max_per_member') }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Denda Tertunggak</dt><dd>Rp {{ number_format($member->unpaid_fine_total, 0, ',', '.') }}</dd></div>
        </dl>
        @can('member.update')<a href="{{ route('members.edit', $member) }}" class="btn-secondary w-full mt-4 block text-center">Edit</a>@endcan
    </div>
    <div class="card md:col-span-2 overflow-x-auto">
        <h3 class="font-semibold mb-3">Riwayat Peminjaman</h3>
        <table class="min-w-full text-sm">
            <thead><tr class="bg-gray-50 dark:bg-gray-700/40"><th class="text-left px-2 py-1">Kode</th><th class="text-left px-2 py-1">Buku</th><th class="text-left px-2 py-1">Pinjam</th><th class="text-left px-2 py-1">Jatuh Tempo</th><th class="text-left px-2 py-1">Status</th></tr></thead>
            <tbody>
            @forelse($member->borrows->take(20) as $t)
                <tr class="border-t border-gray-100 dark:border-gray-700">
                    <td class="px-2 py-1 font-mono">{{ $t->code }}</td>
                    <td class="px-2 py-1">{{ $t->book?->title }}</td>
                    <td class="px-2 py-1">{{ $t->borrowed_at?->format('d M Y') }}</td>
                    <td class="px-2 py-1">{{ $t->due_at?->format('d M Y') }}</td>
                    <td class="px-2 py-1">{{ $t->status }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-2 py-3 text-center text-gray-500">Belum ada riwayat.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
