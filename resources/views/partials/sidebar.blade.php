<aside
    class="fixed inset-y-0 left-0 z-40 flex flex-col bg-white dark:bg-slate-800 border-r border-slate-200 dark:border-slate-700 transition-all duration-200 shadow-lg md:shadow-none"
    :class="{
        'w-64': $store.sidebar.open,
        'w-16': !$store.sidebar.open,
        '-translate-x-full md:translate-x-0': !$store.sidebar.mobileOpen,
        'translate-x-0': $store.sidebar.mobileOpen,
    }">
    <div class="flex items-center h-16 px-4 border-b border-slate-200 dark:border-slate-700 bg-gradient-to-r from-primary-600 to-primary-700">
        <div class="flex items-center gap-3 text-white">
            <div class="h-9 w-9 rounded-lg bg-white text-primary-600 flex items-center justify-center font-bold text-lg shadow">
                <i class="fas fa-book-open-reader"></i>
            </div>
            <div x-show="$store.sidebar.open" x-cloak>
                <p class="font-bold text-base leading-tight">PerpusDigital</p>
                <p class="text-[10px] opacity-90">Spot Baca Platform</p>
            </div>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-3 text-sm">
        @php
            $sections = [
                'Utama' => [
                    ['route' => 'dashboard',           'label' => 'Dashboard',     'icon' => 'fas fa-gauge-high'],
                    ['route' => 'catalog.index',       'label' => 'Katalog Publik','icon' => 'fas fa-compass'],
                ],
                'Multi-Tenant' => [
                    ['route' => 'reading-spots.index', 'label' => 'Reading Spots', 'icon' => 'fas fa-map-location-dot'],
                    ['route' => 'ddc-categories.index','label' => 'Kategori DDC',  'icon' => 'fas fa-sitemap'],
                ],
                'Koleksi' => [
                    ['route' => 'books.index',         'label' => 'Buku Digital',  'icon' => 'fas fa-tablet-screen-button', 'perm' => 'book.view'],
                    ['route' => 'offline-books.index', 'label' => 'Buku Fisik',    'icon' => 'fas fa-book',                 'perm' => 'book.view'],
                    ['route' => 'ebooks.index',        'label' => 'E-Book Reader', 'icon' => 'fas fa-book-bookmark',        'perm' => 'ebook.view'],
                ],
                'Sirkulasi' => [
                    ['route' => 'members.index',       'label' => 'Anggota',         'icon' => 'fas fa-users',          'perm' => 'member.view'],
                    ['route' => 'borrows.index',       'label' => 'Peminjaman',      'icon' => 'fas fa-handshake',      'perm' => 'borrow.view'],
                    ['route' => 'returns.create',      'label' => 'Pengembalian',    'icon' => 'fas fa-rotate-left',    'perm' => 'borrow.return'],
                    ['route' => 'checkouts.index',     'label' => 'Checkout Fisik',  'icon' => 'fas fa-cart-shopping'],
                    ['route' => 'holds.index',         'label' => 'Hold/Antrean',    'icon' => 'fas fa-hourglass-half'],
                    ['route' => 'reservations.index',  'label' => 'Reservasi',       'icon' => 'fas fa-bookmark'],
                    ['route' => 'fines.index',         'label' => 'Denda',           'icon' => 'fas fa-money-bill-wave', 'perm' => 'fine.view'],
                ],
                'Personal' => [
                    ['route' => 'wishlist.index',      'label' => 'Wishlist Saya',   'icon' => 'fas fa-heart'],
                    ['route' => 'notifications.index', 'label' => 'Notifikasi',      'icon' => 'fas fa-bell'],
                ],
                'Admin' => [
                    ['route' => 'reports.index',       'label' => 'Laporan',         'icon' => 'fas fa-chart-line', 'perm' => 'report.view'],
                    ['route' => 'users.index',         'label' => 'Manajemen User',  'icon' => 'fas fa-user-shield','perm' => 'user.manage'],
                    ['route' => 'settings.index',      'label' => 'Pengaturan',      'icon' => 'fas fa-gear',       'perm' => 'setting.manage'],
                ],
            ];
        @endphp
        @foreach($sections as $section => $links)
            <div class="px-4 pt-4 pb-1 text-[10px] font-bold uppercase text-slate-400 tracking-widest" x-show="$store.sidebar.open" x-cloak>
                {{ $section }}
            </div>
            <div x-show="!$store.sidebar.open" x-cloak class="border-t border-slate-200 dark:border-slate-700 my-2 mx-3"></div>
            @foreach($links as $l)
                @if(empty($l['perm']) || auth()->user()->can($l['perm']))
                    @php
                        $active = request()->routeIs($l['route']);
                        $url = \Illuminate\Support\Facades\Route::has($l['route']) ? route($l['route']) : '#';
                    @endphp
                    <a href="{{ $url }}"
                       class="group flex items-center gap-3 px-4 py-2.5 mx-2 my-0.5 rounded-lg transition
                              {{ $active
                                 ? 'bg-primary-600 text-white shadow-soft'
                                 : 'text-slate-700 dark:text-slate-200 hover:bg-primary-50 dark:hover:bg-slate-700' }}"
                       :class="!$store.sidebar.open && 'justify-center'"
                       title="{{ $l['label'] }}">
                        <i class="{{ $l['icon'] }} w-5 text-center shrink-0 {{ $active ? '' : 'text-primary-600 dark:text-primary-400' }}"></i>
                        <span x-show="$store.sidebar.open" x-cloak class="truncate">{{ $l['label'] }}</span>
                    </a>
                @endif
            @endforeach
        @endforeach
    </nav>

    {{-- Footer mini sidebar --}}
    <div class="px-4 py-3 border-t border-slate-200 dark:border-slate-700 text-xs text-slate-500" x-show="$store.sidebar.open" x-cloak>
        <p class="font-semibold">v1.0.0</p>
        <p>&copy; {{ date('Y') }} PerpusDigital</p>
    </div>
</aside>
