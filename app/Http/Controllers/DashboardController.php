<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookActivityLog;
use App\Models\BookCategory;
use App\Models\Checkout;
use App\Models\Ebook;
use App\Models\Fine;
use App\Models\Member;
use App\Models\OfflineBook;
use App\Models\ReadingSpot;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books'  => Book::count(),
            'total_ebooks' => Ebook::count(),
            'available'    => Book::where('status', 'available')->count(),
            'borrowed'     => Checkout::where('is_returned', false)->count(),
            'members'      => Member::count(),
            'transactions' => Checkout::count(),
            'overdue'      => Checkout::overdue()->count(),
            'fine_unpaid'  => (int) Fine::whereIn('status', ['unpaid', 'partial'])->sum('amount'),
        ];

        $chart = Checkout::selectRaw('DATE(start_time) as d, COUNT(*) as c')
            ->where('start_time', '>=', now()->subDays(14))
            ->groupBy('d')->orderBy('d')->get();

        $popular = Book::orderByDesc('view_count')->take(5)->get(['id','title','view_count','rating_avg']);

        $activeMembers = Member::withCount('checkouts')->orderByDesc('checkouts_count')
            ->take(5)->get(['id','user_id','member_no']);

        $recent = Checkout::with(['user','offlineBookCopies.offlineBook'])
            ->latest()->take(10)->get();

        return view('dashboard.index', array_merge(
            compact('stats', 'chart', 'popular', 'activeMembers', 'recent'),
            $this->activitySummary()
        ));
    }

    /**
     * Ringkasan aktivitas ala dashboard "Hybrid": grafik 30 hari (dilihat/dibaca/dipinjam),
     * kategori bacaan, dan top 10 lokasi baca. Data dilihat/dibaca berasal dari
     * BookActivityLog (mulai tercatat sejak fitur ini aktif — hari sebelumnya akan 0).
     * "Dipinjam" berasal dari Checkout (peminjaman fisik) karena buku digital tidak
     * lagi memakai sistem peminjaman — bebas dibaca tanpa batas.
     */
    protected function activitySummary(): array
    {
        $digitalBooksCount = Book::count();
        $fisikBooksCount   = OfflineBook::count();
        $categoriesCount   = BookCategory::count();

        $todayViews       = BookActivityLog::where('type', 'view')->whereDate('created_at', today())->count();
        $todayReads       = BookActivityLog::where('type', 'read')->whereDate('created_at', today())->count();
        $todayBorrows     = Checkout::whereDate('start_time', today())->count();
        $newAccountsToday = Member::whereDate('created_at', today())->count();

        $days = collect(range(29, 0))->map(fn ($i) => now()->subDays($i)->toDateString());
        $since = now()->subDays(29)->startOfDay();

        $viewsByDay = BookActivityLog::where('type', 'view')->where('created_at', '>=', $since)
            ->selectRaw('DATE(created_at) as d, COUNT(*) as c')->groupBy('d')->pluck('c', 'd');
        $readsByDay = BookActivityLog::where('type', 'read')->where('created_at', '>=', $since)
            ->selectRaw('DATE(created_at) as d, COUNT(*) as c')->groupBy('d')->pluck('c', 'd');
        $borrowsByDay = Checkout::where('start_time', '>=', $since)
            ->selectRaw('DATE(start_time) as d, COUNT(*) as c')->groupBy('d')->pluck('c', 'd');

        $activityChart = [
            'labels'  => $days->map(fn ($d) => Carbon::parse($d)->translatedFormat('d M'))->all(),
            'views'   => $days->map(fn ($d) => (int) ($viewsByDay[$d] ?? 0))->all(),
            'reads'   => $days->map(fn ($d) => (int) ($readsByDay[$d] ?? 0))->all(),
            'borrows' => $days->map(fn ($d) => (int) ($borrowsByDay[$d] ?? 0))->all(),
        ];

        $categoryBreakdown = BookCategory::withCount('books')
            ->having('books_count', '>', 0)
            ->orderByDesc('books_count')->get();

        $spotActivity = BookActivityLog::where('created_at', '>=', $since)
            ->whereNotNull('reading_spot_id')
            ->selectRaw("reading_spot_id, SUM(type = 'view') as views, SUM(type = 'read') as read_count")
            ->groupBy('reading_spot_id')->get()->keyBy('reading_spot_id');

        $borrowsPerSpot = Checkout::where('start_time', '>=', $since)
            ->selectRaw('reading_spot_id, COUNT(*) as borrows')
            ->groupBy('reading_spot_id')->get()->keyBy('reading_spot_id');

        $topSpots = ReadingSpot::active()->get()->map(function ($spot) use ($spotActivity, $borrowsPerSpot) {
            $spot->views_count   = (int) ($spotActivity[$spot->id]->views ?? 0);
            $spot->reads_count   = (int) ($spotActivity[$spot->id]->read_count ?? 0);
            $spot->borrows_count = (int) ($borrowsPerSpot[$spot->id]->borrows ?? 0);
            $spot->total_activity = $spot->views_count + $spot->reads_count + $spot->borrows_count;
            return $spot;
        })->sortByDesc('total_activity')->take(10)->values();

        return compact(
            'digitalBooksCount', 'fisikBooksCount', 'categoriesCount',
            'todayViews', 'todayReads', 'todayBorrows', 'newAccountsToday',
            'activityChart', 'categoryBreakdown', 'topSpots'
        );
    }
}
