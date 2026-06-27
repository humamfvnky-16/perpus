@extends('layouts.app')
@section('title','Laporan')
@section('content')
<h1 class="text-2xl font-bold mb-4">Laporan</h1>
<div class="grid md:grid-cols-2 gap-6">
    <div class="card">
        <div class="flex justify-between"><h2 class="font-semibold">Buku Populer</h2>
            <a href="{{ route('reports.pdf','popular') }}" class="text-primary-600 text-sm">Export PDF</a></div>
        <ol class="list-decimal pl-5 mt-2 text-sm space-y-1">
            @forelse($topBooks as $b)<li>{{ $b->title }} <span class="text-gray-500">({{ $b->borrow_count }}x)</span></li>@empty<li class="text-gray-500">Tidak ada data.</li>@endforelse
        </ol>
    </div>
    <div class="card">
        <div class="flex justify-between"><h2 class="font-semibold">Buku Terlambat</h2>
            <a href="{{ route('reports.pdf','overdue') }}" class="text-primary-600 text-sm">Export PDF</a></div>
        <ul class="text-sm mt-2 space-y-1">
            @forelse($overdue as $t)<li>{{ $t->book?->title }} — {{ $t->member?->user?->name }} <span class="text-red-600">({{ $t->daysLate() }} hari)</span></li>@empty<li class="text-gray-500">Tidak ada keterlambatan.</li>@endforelse
        </ul>
    </div>
    <div class="card md:col-span-2">
        <h2 class="font-semibold">Anggota Aktif</h2>
        <ol class="list-decimal pl-5 mt-2 text-sm">
            @forelse($activeMembers as $m)<li>{{ $m->member_no }} — {{ $m->borrows_count }} transaksi</li>@empty<li class="text-gray-500">Tidak ada data.</li>@endforelse
        </ol>
    </div>
</div>
@endsection
