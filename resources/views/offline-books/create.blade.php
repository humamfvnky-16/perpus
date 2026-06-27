@extends('layouts.app')
@section('title','Tambah Buku Fisik')
@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah Buku Fisik</h1>
@include('offline-books._form', ['action' => route('offline-books.store'), 'method' => 'POST'])
@endsection
