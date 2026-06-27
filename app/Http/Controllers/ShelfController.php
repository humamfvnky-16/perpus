<?php

namespace App\Http\Controllers;

use App\Models\Shelf;
use Illuminate\Http\Request;

class ShelfController extends Controller
{
    public function index()
    {
        $items = Shelf::orderBy('code')->paginate(30);
        return view('shelves.index', compact('items'));
    }
    public function create() { return view('shelves.create'); }
    public function store(Request $r)
    {
        $data = $r->validate([
            'code'  => 'required|string|max:20|unique:shelves,code',
            'name'  => 'required|string|max:100',
            'floor' => 'nullable|string|max:50',
            'room'  => 'nullable|string|max:50',
        ]);
        Shelf::create($data);
        return redirect()->route('shelves.index')->with('toast', 'Rak dibuat.');
    }
    public function edit(Shelf $shelf) { return view('shelves.edit', compact('shelf')); }
    public function update(Request $r, Shelf $shelf)
    {
        $data = $r->validate([
            'code'  => 'required|string|max:20|unique:shelves,code,'.$shelf->id,
            'name'  => 'required|string|max:100',
            'floor' => 'nullable|string|max:50',
            'room'  => 'nullable|string|max:50',
        ]);
        $shelf->update($data);
        return redirect()->route('shelves.index')->with('toast', 'Rak diperbarui.');
    }
    public function destroy(Shelf $shelf)
    {
        $shelf->delete();
        return back()->with('toast', 'Rak dihapus.');
    }
}
