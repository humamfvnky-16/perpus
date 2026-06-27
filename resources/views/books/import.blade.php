@extends('layouts.app')
@section('title','Import Buku')
@section('content')
<h1 class="text-2xl font-bold mb-4">Import Buku dari Excel</h1>
<form method="POST" action="{{ route('books.import') }}" enctype="multipart/form-data" class="card space-y-3">@csrf
    <div><label class="text-sm">File Excel (.xlsx)</label><input type="file" name="file" accept=".xlsx,.csv" required class="form-input"></div>
    <p class="text-xs text-gray-500">Format kolom: isbn, title, subtitle, year_published, stock, category, publisher, language, pages, synopsis, keywords.</p>
    <button class="btn-primary">Upload &amp; Import</button>
</form>
@endsection
