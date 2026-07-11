<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookActivityLog;
use App\Models\Ebook;
use App\Models\EbookBookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    public function read(Ebook $ebook)
    {
        abort_unless($this->canAccess($ebook), 403);
        $ebook->increment('view_count');
        BookActivityLog::logRead($ebook);
        $bookmark = EbookBookmark::firstOrCreate(
            ['user_id' => auth()->id(), 'ebook_id' => $ebook->id],
            ['page' => 1]
        );
        return view('ebooks.read', compact('ebook', 'bookmark'));
    }

    public function bookmark(Request $r, Ebook $ebook)
    {
        $data = $r->validate([
            'page' => 'required|integer|min:1',
            'note' => 'nullable|string|max:200',
        ]);
        EbookBookmark::updateOrCreate(
            ['user_id' => auth()->id(), 'ebook_id' => $ebook->id],
            $data
        );
        return response()->json(['ok' => true]);
    }

    public function download(Ebook $ebook)
    {
        abort_unless($ebook->downloadable && $this->canAccess($ebook), 403);
        $ebook->increment('download_count');
        return Storage::disk('public')->download($ebook->file_path);
    }

    public function track(Request $r, Ebook $ebook)
    {
        return response()->json(['ok' => true]);
    }

    public function create(Request $r) {
        $book = Book::findOrFail($r->query('book_id'));
        return view('ebooks.create', compact('book'));
    }
    public function store(Request $r) {
        $data = $r->validate([
            'book_id' => 'required|exists:books,id',
            'title'  => 'required|string|max:255',
            'format' => 'required|in:pdf,epub,docx,pptx,audio,video',
            'file'   => 'required|file|max:102400',
            'access' => 'required|in:public,member,staff',
            'downloadable' => 'boolean',
        ]);
        $path = $r->file('file')->store('ebooks', 'public');
        Ebook::create([
            'book_id'      => $data['book_id'],
            'title'        => $data['title'],
            'format'       => $data['format'],
            'access'       => $data['access'],
            'file_path'    => $path,
            'file_size'    => $r->file('file')->getSize(),
            'downloadable' => $r->boolean('downloadable'),
        ]);
        return redirect()->route('books.show', $data['book_id'])->with('toast', 'File digital diunggah.');
    }
    public function edit(Ebook $ebook)   { return view('ebooks.edit', compact('ebook')); }
    public function update(Request $r, Ebook $ebook) {
        $ebook->update($r->only(['title','format','access','downloadable']));
        return redirect()->route('books.show', $ebook->book_id)->with('toast', 'File digital diperbarui.');
    }
    public function destroy(Ebook $ebook) {
        $bookId = $ebook->book_id;
        $ebook->delete();
        return redirect()->route('books.show', $bookId)->with('toast', 'File digital dihapus.');
    }

    protected function canAccess(Ebook $e): bool
    {
        $u = auth()->user();
        // Petugas/admin perpustakaan dapat mengakses seluruh koleksi.
        if ($u?->hasAnyRole(['staff', 'admin', 'super_admin'])) {
            return true;
        }
        return match ($e->access) {
            'public' => true,
            'member' => (bool) ($u?->member),
            'staff'  => false,
        };
    }
}
