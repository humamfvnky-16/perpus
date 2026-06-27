<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookApiController extends Controller
{
    public function index(Request $r)
    {
        $books = Book::with(['authors','category','publisher'])
            ->search($r->q)
            ->when($r->category, fn($q) => $q->where('book_category_id', $r->category))
            ->paginate(20);
        return BookResource::collection($books);
    }

    public function show(Book $book)
    {
        return new BookResource($book->load(['authors','category','publisher']));
    }
}
