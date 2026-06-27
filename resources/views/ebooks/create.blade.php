@extends('layouts.app')
@section('title','Upload E-Book')
@section('content')
<h1 class="text-2xl font-bold mb-4">Upload E-Book</h1>
<form method="POST" action="{{ route('ebooks.store') }}" enctype="multipart/form-data" class="card space-y-3">@csrf
    <div><label class="text-sm">Judul</label><input name="title" required class="form-input"></div>
    <div><label class="text-sm">Format</label>
        <select name="format" class="form-input">
            @foreach(['pdf','epub','docx','pptx','audio','video'] as $f)<option value="{{ $f }}">{{ $f }}</option>@endforeach
        </select>
    </div>
    <div><label class="text-sm">Akses</label>
        <select name="access" class="form-input">
            <option value="public">Publik</option><option value="member">Anggota</option><option value="staff">Staff</option>
        </select>
    </div>
    <div><label class="text-sm">File</label><input type="file" name="file" required class="form-input"></div>
    <label class="flex items-center gap-2"><input type="checkbox" name="downloadable" value="1"> Boleh diunduh</label>
    <button class="btn-primary">Upload</button>
</form>
@endsection
