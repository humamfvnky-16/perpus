<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthorController extends Controller
{
    public function index()
    {
        $items = Author::orderBy('name')->paginate(30);
        return view('authors.index', compact('items'));
    }
    public function create() { return view('authors.create'); }
    public function store(Request $r)
    {
        $data = $r->validate([
            'name'        => 'required|string|max:100',
            'bio'         => 'nullable|string',
            'nationality' => 'nullable|string|max:50',
        ]);
        $data['slug'] = Str::slug($data['name']);
        Author::create($data);
        return redirect()->route('authors.index')->with('toast', 'Penulis dibuat.');
    }
    public function edit(Author $author) { return view('authors.edit', compact('author')); }
    public function update(Request $r, Author $author)
    {
        $data = $r->validate([
            'name'        => 'required|string|max:100',
            'bio'         => 'nullable|string',
            'nationality' => 'nullable|string|max:50',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $author->update($data);
        return redirect()->route('authors.index')->with('toast', 'Penulis diperbarui.');
    }
    public function destroy(Author $author)
    {
        $author->delete();
        return back()->with('toast', 'Penulis dihapus.');
    }
}
