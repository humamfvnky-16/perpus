@extends('layouts.app')
@section('title','Wishlist')
@section('content')
<h1 class="text-2xl font-bold mb-4">Wishlist Saya</h1>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @forelse($books as $b)
        <a href="{{ route('catalog.show', $b) }}" class="card hover:shadow-lg">
            <div class="aspect-[3/4] bg-gray-200 dark:bg-gray-700 rounded mb-2 flex items-center justify-center text-3xl">📕</div>
            <p class="font-medium text-sm line-clamp-2">{{ $b->title }}</p>
        </a>
    @empty
        <p class="col-span-4 text-gray-500 text-sm py-12 text-center">Belum ada buku di wishlist.</p>
    @endforelse
</div>
<div class="mt-4">{{ $books->links() }}</div>
@endsection
