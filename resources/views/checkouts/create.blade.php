@extends('layouts.app')
@section('title','Checkout Baru')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-door-open',
    'title' => 'Checkout Buku Fisik',
    'desc'  => 'Catat peminjaman buku fisik di reading spot.',
])

<div class="max-w-3xl space-y-5" x-data="checkoutCopyPicker()">
    <form method="POST" action="{{ route('checkouts.store') }}" class="space-y-5">@csrf

        {{-- Detail peminjam --}}
        <div class="card form-section">
            <h2 class="form-section-title"><i class="fas fa-user"></i> Detail Peminjam</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="form-label"><i class="fas fa-id-card text-primary-500 text-xs"></i> Anggota</label>
                    <select name="user_id" required class="form-select">
                        <option value="">Pilih anggota...</option>
                        @foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label"><i class="fas fa-map-location-dot text-primary-500 text-xs"></i> Reading Spot</label>
                    <select name="reading_spot_id" required class="form-select">
                        <option value="">Pilih lokasi...</option>
                        @foreach($spots as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Pilih kopi buku --}}
        <div class="card form-section">
            <div class="flex items-center justify-between mb-4">
                <h2 class="form-section-title !mb-0"><i class="fas fa-barcode"></i> Pilih Kopi Buku</h2>
                <button type="button" @click="toggleCamera()" class="btn-secondary text-xs !px-3 !py-1.5">
                    <i class="fas" :class="cameraOn ? 'fa-video-slash' : 'fa-camera'"></i>
                    <span x-text="cameraOn ? 'Matikan Kamera' : 'Scan pakai Kamera'"></span>
                </button>
            </div>

            <div x-show="cameraOn" x-cloak class="mb-3">
                <div id="checkout-qr-reader" class="rounded-xl overflow-hidden bg-slate-900" style="min-height:240px"></div>
                <p x-show="cameraError" x-cloak class="form-hint text-red-600 dark:text-red-400"><i class="fas fa-triangle-exclamation"></i> <span x-text="cameraError"></span></p>
                <p x-show="cameraOn && !cameraError" class="form-hint">Arahkan kamera ke barcode/QR di kopi buku.</p>
            </div>

            <label class="form-label"><i class="fas fa-keyboard text-primary-500 text-xs"></i> Catalog Code / Barcode</label>
            <div class="relative">
                <i class="fas fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" id="copy-input" placeholder="Scan atau tempelkan barcode/catalog code, lalu Enter..." class="form-input pl-10"
                       @keyup.enter.prevent="lookupAndAdd($event.target.value); $event.target.value=''">
            </div>
            <p x-show="notFound" x-cloak class="form-hint text-red-600 dark:text-red-400"><i class="fas fa-triangle-exclamation"></i> Kode tidak ditemukan.</p>

            <div class="mt-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400 mb-2">
                    Kopi Dipilih <span x-show="copies.length" class="badge-blue" x-text="copies.length"></span>
                </p>
                <div class="space-y-2">
                    <template x-for="c in copies" :key="c.id">
                        <div class="flex justify-between items-center p-3 rounded-xl bg-primary-50/70 dark:bg-slate-700/40 ring-1 ring-primary-100 dark:ring-slate-600">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <i class="fas fa-book text-primary-600 shrink-0"></i>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold truncate" x-text="c.offline_book?.title || 'Buku'"></p>
                                    <p class="text-xs text-slate-500 font-mono" x-text="c.catalog_code"></p>
                                </div>
                            </div>
                            <button type="button" @click="copies = copies.filter(x => x.id !== c.id)" class="text-red-500 hover:text-red-700 text-sm p-1.5 shrink-0"><i class="fas fa-xmark"></i></button>
                            <input type="hidden" name="copy_ids[]" :value="c.id">
                        </div>
                    </template>
                    <div x-show="copies.length === 0" class="rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-700 py-6 text-center text-sm text-slate-400">
                        <i class="fas fa-inbox mb-1 block text-lg"></i> Belum ada kopi dipilih.
                    </div>
                </div>
            </div>
        </div>

        {{-- Durasi --}}
        <div class="card form-section">
            <h2 class="form-section-title"><i class="fas fa-calendar-days"></i> Durasi Peminjaman</h2>
            <label class="form-label">Lama Pinjam (hari)</label>
            <input type="number" name="days" min="1" max="30" placeholder="Default sesuai Setting Durasi Peminjaman" class="form-input max-w-xs">
            <p class="form-hint">Kosongkan untuk pakai durasi default reading spot ini.</p>
        </div>

        <button class="btn-primary" :disabled="copies.length === 0" :class="{ 'opacity-50': copies.length === 0 }">
            <i class="fas fa-check"></i> Simpan Checkout
        </button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    function checkoutCopyPicker() {
        return {
            copies: [],
            notFound: false,
            cameraOn: false,
            cameraError: null,
            html5QrCode: null,

            async lookupAndAdd(code) {
                code = (code || '').trim();
                if (!code) return;
                this.notFound = false;
                const res = await fetch('{{ route('checkouts.lookupCopy') }}?code=' + encodeURIComponent(code), {
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                });
                const d = await res.json();
                if (d && d.id) {
                    if (!this.copies.find(c => c.id === d.id)) this.copies.push(d);
                } else {
                    this.notFound = true;
                }
            },

            toggleCamera() {
                this.cameraOn ? this.stopCamera() : this.startCamera();
            },

            startCamera() {
                if (typeof Html5Qrcode === 'undefined') {
                    this.cameraError = 'Pustaka kamera gagal dimuat.';
                    return;
                }
                this.cameraOn = true;
                this.cameraError = null;
                this.$nextTick(() => {
                    this.html5QrCode = new Html5Qrcode('checkout-qr-reader', {
                        formatsToSupport: [
                            Html5QrcodeSupportedFormats.QR_CODE,
                            Html5QrcodeSupportedFormats.CODE_128,
                            Html5QrcodeSupportedFormats.CODE_39,
                            Html5QrcodeSupportedFormats.EAN_13,
                            Html5QrcodeSupportedFormats.EAN_8,
                            Html5QrcodeSupportedFormats.UPC_A,
                            Html5QrcodeSupportedFormats.UPC_E,
                            Html5QrcodeSupportedFormats.CODABAR,
                            Html5QrcodeSupportedFormats.ITF,
                        ],
                    });
                    this.html5QrCode.start(
                        { facingMode: 'environment' },
                        { fps: 10, qrbox: { width: 250, height: 150 } },
                        (decodedText) => { this.lookupAndAdd(decodedText); },
                        () => {}
                    ).catch(() => {
                        this.cameraError = 'Tidak bisa mengakses kamera. Izinkan akses kamera atau gunakan input manual.';
                    });
                });
            },

            stopCamera() {
                if (this.html5QrCode) {
                    this.html5QrCode.stop().catch(() => {}).finally(() => { this.html5QrCode = null; });
                }
                this.cameraOn = false;
            },
        };
    }
</script>
@endsection
