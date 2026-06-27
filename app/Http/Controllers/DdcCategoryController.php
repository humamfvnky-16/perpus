<?php

namespace App\Http\Controllers;

use App\Models\DdcCategory;
use Illuminate\Http\Request;

class DdcCategoryController extends Controller
{
    public function index()
    {
        $items = DdcCategory::with('parent')->orderBy('code')->paginate(50);
        return view('ddc-categories.index', compact('items'));
    }

    public function create()
    {
        return view('ddc-categories.create', ['parents' => DdcCategory::orderBy('code')->get()]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'code'        => 'required|string|max:10|unique:ddc_categories,code',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:ddc_categories,id',
            'order'       => 'nullable|integer',
        ]);
        DdcCategory::create($data);
        return redirect()->route('ddc-categories.index')->with('toast', 'Kategori DDC dibuat.');
    }

    public function edit(DdcCategory $ddcCategory)
    {
        return view('ddc-categories.edit', [
            'item' => $ddcCategory,
            'parents' => DdcCategory::where('id', '!=', $ddcCategory->id)->orderBy('code')->get(),
        ]);
    }

    public function update(Request $r, DdcCategory $ddcCategory)
    {
        $data = $r->validate([
            'code'        => 'required|string|max:10|unique:ddc_categories,code,'.$ddcCategory->id,
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:ddc_categories,id',
            'order'       => 'nullable|integer',
        ]);
        $ddcCategory->update($data);
        return redirect()->route('ddc-categories.index')->with('toast', 'Kategori DDC diperbarui.');
    }

    public function destroy(DdcCategory $ddcCategory)
    {
        $ddcCategory->delete();
        return back()->with('toast', 'Kategori DDC dihapus.');
    }
}
