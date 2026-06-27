@extends('layouts.app')
@section('title','Import Anggota')
@section('content')
<h1 class="text-2xl font-bold mb-4">Import Anggota dari Excel</h1>
<form method="POST" action="{{ route('members.import') }}" enctype="multipart/form-data" class="card space-y-3">@csrf
    <div><label class="text-sm">File Excel (.xlsx)</label><input type="file" name="file" accept=".xlsx,.csv" required class="form-input"></div>
    <p class="text-xs text-gray-500">Format: name, email, password, nis_nip, type, class, major.</p>
    <button class="btn-primary">Upload &amp; Import</button>
</form>
@endsection
