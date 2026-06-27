{{--
    Komponen header halaman dengan judul, deskripsi, dan tombol aksi.
    Pakai:
    @include('partials.page-header', [
        'icon' => 'fa-book',
        'title' => 'Manajemen Buku',
        'desc' => 'Kelola koleksi buku digital perpustakaan.',
        'actions' => [
            ['url' => route('books.create'), 'label' => '+ Buku Baru', 'class' => 'btn-primary', 'icon' => 'fa-plus', 'can' => 'book.create'],
        ],
    ])
--}}
<div class="flex flex-wrap justify-between items-start gap-4 mb-5">
    <div class="flex items-start gap-4">
        @if(!empty($icon))
        <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 text-white flex items-center justify-center shadow-soft">
            <i class="fas {{ $icon }} text-lg"></i>
        </div>
        @endif
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $title }}</h1>
            @if(!empty($desc))<p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">{{ $desc }}</p>@endif
        </div>
    </div>
    @if(!empty($actions))
    <div class="flex gap-2 flex-wrap">
        @foreach($actions as $a)
            @if(empty($a['can']) || auth()->user()->can($a['can']))
                <a href="{{ $a['url'] }}" class="{{ $a['class'] ?? 'btn-secondary' }}">
                    @if(!empty($a['icon']))<i class="fas {{ $a['icon'] }}"></i>@endif
                    {{ $a['label'] }}
                </a>
            @endif
        @endforeach
    </div>
    @endif
</div>
