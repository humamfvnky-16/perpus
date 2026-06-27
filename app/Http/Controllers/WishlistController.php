<?php

namespace App\Http\Controllers;

use App\Models\Book;

class WishlistController extends Controller
{
    public function index()
    {
        $books = auth()->user()->wishlist()->with('authors')->paginate(20);
        return view('wishlist.index', compact('books'));
    }

    public function toggle(Book $book)
    {
        $user = auth()->user();
        if ($user->wishlist()->where('book_id', $book->id)->exists()) {
            $user->wishlist()->detach($book->id);
            $msg = 'Dihapus dari wishlist.';
        } else {
            $user->wishlist()->attach($book->id);
            $msg = 'Ditambahkan ke wishlist.';
        }
        return back()->with('toast', $msg);
    }

    public function destroy(Book $book)
    {
        auth()->user()->wishlist()->detach($book->id);
        return back()->with('toast', 'Dihapus dari wishlist.');
    }
}
