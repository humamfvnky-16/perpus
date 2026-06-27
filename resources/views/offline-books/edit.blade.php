@extends('layouts.app')
@section('title','Edit Buku Fisik')
@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Buku Fisik</h1>
@include('offline-books._form', ['action' => route('offline-books.update', $book), 'method' => 'PUT'])
@endsection
