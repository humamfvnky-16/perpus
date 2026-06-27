@extends('layouts.app')
@section('title', 'Edit Buku')
@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Buku</h1>
@include('books._form', ['action' => route('books.update', $book), 'method' => 'PUT'])
@endsection
