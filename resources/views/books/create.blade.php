@extends('layouts.app')
@section('title', 'Tambah Buku')
@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah Buku</h1>
@include('books._form', ['action' => route('books.store'), 'method' => 'POST'])
@endsection
