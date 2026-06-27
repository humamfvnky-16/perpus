@extends('layouts.app')
@section('title','Edit E-Book')
@section('content')
<h1 class="text-2xl font-bold mb-4">Edit E-Book</h1>
<form method="POST" action="{{ route('ebooks.update', $ebook) }}" class="card space-y-3">@csrf @method('PATCH')
    <div><label class="text-sm">Judul</label><input name="title" required value="{{ $ebook->title }}" class="form-input"></div>
    <div><label class="text-sm">Format</label>
        <select name="format" class="form-input">
            @foreach(['pdf','epub','docx','pptx','audio','video'] as $f)<option value="{{ $f }}" @selected($ebook->format===$f)>{{ $f }}</option>@endforeach
        </select>
    </div>
    <div><label class="text-sm">Akses</label>
        <select name="access" class="form-input">
            <option value="public" @selected($ebook->access==='public')>Publik</option>
            <option value="member" @selected($ebook->access==='member')>Anggota</option>
            <option value="staff" @selected($ebook->access==='staff')>Staff</option>
        </select>
    </div>
    <label class="flex items-center gap-2"><input type="checkbox" name="downloadable" value="1" @checked($ebook->downloadable)> Boleh diunduh</label>
    <button class="btn-primary">Simpan</button>
</form>
@endsection
