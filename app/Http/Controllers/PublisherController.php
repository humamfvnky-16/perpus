<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublisherController extends Controller
{
    public function index()
    {
        $items = Publisher::orderBy('name')->paginate(30);
        return view('publishers.index', compact('items'));
    }
    public function create() { return view('publishers.create'); }
    public function store(Request $r)
    {
        $data = $r->validate([
            'name'    => 'required|string|max:100',
            'address' => 'nullable|string',
            'city'    => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
            'website' => 'nullable|url',
        ]);
        $data['slug'] = Str::slug($data['name']);
        Publisher::create($data);
        return redirect()->route('publishers.index')->with('toast', 'Penerbit dibuat.');
    }
    public function edit(Publisher $publisher) { return view('publishers.edit', compact('publisher')); }
    public function update(Request $r, Publisher $publisher)
    {
        $data = $r->validate([
            'name'    => 'required|string|max:100',
            'address' => 'nullable|string',
            'city'    => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
            'website' => 'nullable|url',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $publisher->update($data);
        return redirect()->route('publishers.index')->with('toast', 'Penerbit diperbarui.');
    }
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        return back()->with('toast', 'Penerbit dihapus.');
    }
}
