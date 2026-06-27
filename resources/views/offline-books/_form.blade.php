<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="card grid md:grid-cols-2 gap-4">@csrf
    @if($method !== 'POST') @method($method) @endif
    <div><label class="text-sm">Reading Spot</label>
        <select name="reading_spot_id" required class="form-input">
            @foreach($spots as $s)<option value="{{ $s->id }}" @selected(old('reading_spot_id', $book->reading_spot_id ?? '') == $s->id)>{{ $s->name }}</option>@endforeach
        </select>
    </div>
    <div><label class="text-sm">ISBN</label><input name="isbn" value="{{ old('isbn', $book->isbn ?? '') }}" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Judul</label><input name="title" required value="{{ old('title', $book->title ?? '') }}" class="form-input"></div>
    <div><label class="text-sm">Subjudul</label><input name="subtitle" value="{{ old('subtitle', $book->subtitle ?? '') }}" class="form-input"></div>
    <div><label class="text-sm">Tahun</label><input type="number" name="year_published" value="{{ old('year_published', $book->year_published ?? '') }}" class="form-input"></div>
    <div><label class="text-sm">Penerbit</label>
        <select name="publisher_id" class="form-input">
            <option value="">—</option>
            @foreach($publishers as $p)<option value="{{ $p->id }}" @selected(old('publisher_id', $book->publisher_id ?? '') == $p->id)>{{ $p->name }}</option>@endforeach
        </select>
    </div>
    <div><label class="text-sm">DDC</label>
        <select name="ddc_category_id" class="form-input">
            <option value="">—</option>
            @foreach($ddcs as $d)<option value="{{ $d->id }}" @selected(old('ddc_category_id', $book->ddc_category_id ?? '') == $d->id)>{{ $d->code }} — {{ $d->name }}</option>@endforeach
        </select>
    </div>
    <div><label class="text-sm">Bahasa</label><input name="language" value="{{ old('language', $book->language ?? 'id') }}" class="form-input"></div>
    <div><label class="text-sm">Halaman</label><input type="number" name="pages" value="{{ old('pages', $book->pages ?? '') }}" class="form-input"></div>
    <div><label class="text-sm">Sumber</label>
        <select name="source" class="form-input">
            <option value="purchase" @selected(old('source', $book->source ?? '')==='purchase')>Pembelian</option>
            <option value="donation" @selected(old('source', $book->source ?? '')==='donation')>Donasi</option>
            <option value="exchange" @selected(old('source', $book->source ?? '')==='exchange')>Tukar</option>
            <option value="other"    @selected(old('source', $book->source ?? '')==='other')>Lainnya</option>
        </select>
    </div>
    @if(!isset($book))
    <div><label class="text-sm">Jumlah Kopi Awal</label><input type="number" name="initial_copies" value="1" min="1" max="100" required class="form-input"></div>
    @endif
    <div class="md:col-span-2"><label class="text-sm">Penulis (Ctrl/Cmd untuk multi)</label>
        <select name="authors[]" multiple class="form-input h-28">
            @foreach($authors as $a)<option value="{{ $a->id }}" @selected(isset($book) && $book->authors->contains($a->id))>{{ $a->name }}</option>@endforeach
        </select>
    </div>
    <div class="md:col-span-2"><label class="text-sm">Kategori</label>
        <select name="categories[]" multiple class="form-input h-24">
            @foreach($categories as $c)<option value="{{ $c->id }}" @selected(isset($book) && $book->categories->contains($c->id))>{{ $c->name }}</option>@endforeach
        </select>
    </div>
    <div class="md:col-span-2"><label class="text-sm">Sinopsis</label><textarea name="synopsis" rows="3" class="form-input">{{ old('synopsis', $book->synopsis ?? '') }}</textarea></div>
    <div class="md:col-span-2"><label class="text-sm">Kata Kunci</label><input name="keywords" value="{{ old('keywords', $book->keywords ?? '') }}" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Cover</label><input type="file" name="cover" accept="image/*" class="form-input"></div>
    <div class="md:col-span-2 flex gap-2"><button class="btn-primary">Simpan</button><a href="{{ route('offline-books.index') }}" class="btn-secondary">Batal</a></div>
</form>
