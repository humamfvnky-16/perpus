@extends('layouts.app')
@section('title', $book->title)
@section('content')
<div class="grid md:grid-cols-3 gap-6">
    <div class="card md:col-span-1">
        <div class="aspect-[3/4] bg-gray-200 dark:bg-gray-700 rounded-lg mb-4 flex items-center justify-center text-5xl">
            @if($book->cover)<img src="{{ asset('storage/'.$book->cover) }}" class="w-full h-full object-cover rounded-lg">@else 📕 @endif
        </div>
        <div class="space-y-1 text-sm">
            <div class="flex justify-between"><span>Rating</span><span class="text-yellow-500">★ {{ $book->rating_avg }} ({{ $book->rating_count }})</span></div>
            <div class="flex justify-between"><span>Tersedia</span><span class="badge-green">{{ $book->available }}/{{ $book->stock }}</span></div>
        </div>
        @auth
        <div class="mt-4 space-y-2">
            <form method="POST" action="{{ route('wishlist.toggle', $book) }}">@csrf<button class="btn-secondary w-full">♥ Wishlist</button></form>
            <form method="POST" action="{{ route('reservations.store') }}">@csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <button class="btn-primary w-full">Reservasi</button>
            </form>
        </div>
        @endauth
    </div>

    <div class="card md:col-span-2">
        <h1 class="text-2xl font-bold">{{ $book->title }}</h1>
        @if($book->subtitle)<p class="text-gray-500 mb-3">{{ $book->subtitle }}</p>@endif
        <dl class="grid grid-cols-2 gap-2 text-sm mb-4">
            <dt class="text-gray-500">ISBN</dt><dd class="font-mono">{{ $book->isbn }}</dd>
            <dt class="text-gray-500">Penulis</dt><dd>{{ $book->authors->pluck('name')->join(', ') ?: '-' }}</dd>
            <dt class="text-gray-500">Penerbit</dt><dd>{{ $book->publisher?->name ?? '-' }}</dd>
            <dt class="text-gray-500">Tahun</dt><dd>{{ $book->year_published }}</dd>
            <dt class="text-gray-500">Kategori</dt><dd>{{ $book->category?->name ?? '-' }}</dd>
            <dt class="text-gray-500">Rak</dt><dd>{{ $book->shelf?->code ?? '-' }}</dd>
            <dt class="text-gray-500">Bahasa</dt><dd>{{ $book->language }}</dd>
            <dt class="text-gray-500">Halaman</dt><dd>{{ $book->pages ?? '-' }}</dd>
        </dl>
        @if($book->synopsis)
        <h3 class="font-semibold mt-4 mb-2">Sinopsis</h3>
        <p class="text-sm whitespace-pre-line">{{ $book->synopsis }}</p>
        @endif

        <h3 class="font-semibold mt-6 mb-2">Ulasan</h3>
        @auth
        <form method="POST" action="{{ route('reviews.store', $book) }}" class="mb-4 space-y-2">@csrf
            <div class="flex gap-1">
                @for($i = 1; $i <= 5; $i++)
                    <label class="cursor-pointer"><input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required><span class="text-2xl peer-checked:text-yellow-500 text-gray-300">★</span></label>
                @endfor
            </div>
            <textarea name="content" placeholder="Bagikan pendapat Anda..." class="form-input"></textarea>
            <button class="btn-primary">Kirim Ulasan</button>
        </form>
        @endauth
        <div class="space-y-3">
            @forelse($book->reviews as $rv)
                <div class="border-l-4 border-primary-500 pl-3">
                    <div class="flex justify-between text-sm">
                        <strong>{{ $rv->user?->name }}</strong>
                        <span class="text-yellow-500">{{ str_repeat('★', $rv->rating) }}{{ str_repeat('☆', 5 - $rv->rating) }}</span>
                    </div>
                    <p class="text-sm mt-1">{{ $rv->content }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada ulasan. Jadilah yang pertama!</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
