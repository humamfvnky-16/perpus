@extends('layouts.app')
@section('title','Checkout Baru')
@section('content')
<h1 class="text-2xl font-bold mb-4">Checkout Buku Fisik</h1>
<form method="POST" action="{{ route('checkouts.store') }}" class="card space-y-4" x-data="{ copies: [] }">@csrf
    <div><label class="text-sm">Anggota</label>
        <select name="user_id" required class="form-input">
            <option value="">Pilih anggota...</option>
            @foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>@endforeach
        </select>
    </div>
    <div><label class="text-sm">Reading Spot</label>
        <select name="reading_spot_id" required class="form-input">
            <option value="">Pilih lokasi...</option>
            @foreach($spots as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach
        </select>
    </div>
    <div>
        <label class="text-sm">Scan / Tambah Kopi (catalog_code atau barcode)</label>
        <div class="flex gap-2">
            <input type="text" id="copy-input" placeholder="Tempelkan barcode/catalog code..." class="form-input flex-1"
                   @keyup.enter.prevent="
                       fetch('{{ route('checkouts.lookupCopy') }}?code=' + $event.target.value, { headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }})
                           .then(r => r.json())
                           .then(d => { if (d && d.id && !copies.find(c => c.id===d.id)) copies.push(d); $event.target.value=''; });
                   ">
        </div>
        <div class="mt-2 space-y-1">
            <template x-for="c in copies" :key="c.id">
                <div class="flex justify-between items-center p-2 bg-gray-50 dark:bg-gray-700 rounded">
                    <span class="text-sm" x-text="(c.offline_book?.title || 'Buku') + ' — ' + c.catalog_code"></span>
                    <button type="button" @click="copies = copies.filter(x => x.id !== c.id)" class="text-red-600 text-sm">×</button>
                    <input type="hidden" name="copy_ids[]" :value="c.id">
                </div>
            </template>
            <p x-show="copies.length === 0" class="text-xs text-gray-500 italic">Belum ada kopi dipilih.</p>
        </div>
    </div>
    <div><label class="text-sm">Lama Pinjam (hari, default sesuai CheckoutSetting)</label><input type="number" name="days" min="1" max="30" class="form-input"></div>
    <button class="btn-primary" :disabled="copies.length === 0" :class="{ 'opacity-50': copies.length === 0 }">Simpan Checkout</button>
</form>
@endsection
