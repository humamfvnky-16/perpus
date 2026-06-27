<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="card grid md:grid-cols-2 gap-4">@csrf
    @if($method !== 'POST') @method($method) @endif
    <div><label class="text-sm">ISBN</label><input name="isbn" required value="{{ old('isbn', $book->isbn ?? '') }}" class="form-input"></div>
    <div><label class="text-sm">Judul</label><input name="title" required value="{{ old('title', $book->title ?? '') }}" class="form-input"></div>
    <div><label class="text-sm">Subjudul</label><input name="subtitle" value="{{ old('subtitle', $book->subtitle ?? '') }}" class="form-input"></div>
    <div><label class="text-sm">Tahun Terbit</label><input type="number" name="year_published" value="{{ old('year_published', $book->year_published ?? '') }}" class="form-input"></div>
    <div><label class="text-sm">Kategori</label>
        <select name="book_category_id" class="form-input">
            <option value="">—</option>
            @foreach($categories as $c)<option value="{{ $c->id }}" @selected(old('book_category_id', $book->book_category_id ?? '') == $c->id)>{{ $c->name }}</option>@endforeach
        </select>
    </div>
    <div><label class="text-sm">Penerbit</label>
        <select name="publisher_id" class="form-input">
            <option value="">—</option>
            @foreach($publishers as $p)<option value="{{ $p->id }}" @selected(old('publisher_id', $book->publisher_id ?? '') == $p->id)>{{ $p->name }}</option>@endforeach
        </select>
    </div>
    <div><label class="text-sm">Rak</label>
        <select name="shelf_id" class="form-input">
            <option value="">—</option>
            @foreach($shelves as $s)<option value="{{ $s->id }}" @selected(old('shelf_id', $book->shelf_id ?? '') == $s->id)>{{ $s->code }} — {{ $s->name }}</option>@endforeach
        </select>
    </div>
    <div><label class="text-sm">Stok</label><input type="number" name="stock" required value="{{ old('stock', $book->stock ?? 1) }}" class="form-input"></div>
    <div><label class="text-sm">Bahasa</label><input name="language" value="{{ old('language', $book->language ?? 'id') }}" class="form-input"></div>
    <div><label class="text-sm">Halaman</label><input type="number" name="pages" value="{{ old('pages', $book->pages ?? '') }}" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Penulis (Ctrl/Cmd untuk multi)</label>
        <select name="authors[]" multiple class="form-input h-28">
            @foreach($authors as $a)<option value="{{ $a->id }}" @selected(isset($book) && $book->authors->contains($a->id))>{{ $a->name }}</option>@endforeach
        </select>
    </div>
    <div class="md:col-span-2"><label class="text-sm">Sinopsis</label><textarea name="synopsis" rows="4" class="form-input">{{ old('synopsis', $book->synopsis ?? '') }}</textarea></div>
    <div class="md:col-span-2"><label class="text-sm">Kata Kunci</label><input name="keywords" value="{{ old('keywords', $book->keywords ?? '') }}" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Cover</label><input type="file" name="cover" accept="image/*" class="form-input"></div>
    <div class="md:col-span-2 flex gap-2"><button class="btn-primary">Simpan</button><a href="{{ route('books.index') }}" class="btn-secondary">Batal</a></div>
</form>
