<?php

namespace App\Http\Controllers;

use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookCategoryController extends Controller
{
    public function index()
    {
        $items = BookCategory::withCount('books')->orderBy('name')->paginate(30);
        return view('categories.index', compact('items'));
    }
    public function create() { return view('categories.create'); }
    public function store(Request $r)
    {
        $data = $r->validate([
            'name'        => 'required|string|max:100|unique:book_categories,name',
            'dewey_code'  => 'nullable|string|max:10',
            'description' => 'nullable|string',
        ]);
        $data['slug'] = Str::slug($data['name']);
        BookCategory::create($data);
        return redirect()->route('categories.index')->with('toast', 'Kategori dibuat.');
    }
    public function edit(BookCategory $category) { return view('categories.edit', compact('category')); }
    public function update(Request $r, BookCategory $category)
    {
        $data = $r->validate([
            'name'        => 'required|string|max:100',
            'dewey_code'  => 'nullable|string|max:10',
            'description' => 'nullable|string',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $category->update($data);
        return redirect()->route('categories.index')->with('toast', 'Kategori diperbarui.');
    }
    public function destroy(BookCategory $category)
    {
        $category->delete();
        return back()->with('toast', 'Kategori dihapus.');
    }
}
