<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $r, Book $book)
    {
        $data = $r->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'content' => 'nullable|string|max:1000',
        ]);
        Review::updateOrCreate(
            ['user_id' => auth()->id(), 'book_id' => $book->id],
            $data
        );
        $book->recalcRating();
        return back()->with('toast', 'Ulasan disimpan.');
    }

    public function update(Request $r, Review $review)
    {
        $this->authorize('update', $review);
        $data = $r->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'content' => 'nullable|string|max:1000',
        ]);
        $review->update($data);
        $review->book->recalcRating();
        return back()->with('toast', 'Ulasan diperbarui.');
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        $book = $review->book;
        $review->delete();
        $book?->recalcRating();
        return back()->with('toast', 'Ulasan dihapus.');
    }

    public function like(Review $review)
    {
        $review->increment('likes');
        return back();
    }

    public function report(Review $review)
    {
        $review->update(['is_reported' => true]);
        return back()->with('toast', 'Ulasan dilaporkan.');
    }
}
