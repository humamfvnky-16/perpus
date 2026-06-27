<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowTransaction;
use App\Models\Ebook;
use App\Models\Fine;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books'  => Book::count(),
            'total_ebooks' => Ebook::count(),
            'available'    => (int) Book::sum('available'),
            'borrowed'     => BorrowTransaction::where('status', 'active')->count(),
            'members'      => Member::count(),
            'transactions' => BorrowTransaction::count(),
            'overdue'      => BorrowTransaction::overdue()->count(),
            'fine_unpaid'  => (int) Fine::whereIn('status', ['unpaid', 'partial'])->sum('amount'),
        ];

        $chart = BorrowTransaction::selectRaw('DATE(borrowed_at) as d, COUNT(*) as c')
            ->where('borrowed_at', '>=', now()->subDays(14))
            ->groupBy('d')->orderBy('d')->get();

        $popular = Book::orderByDesc('borrow_count')->take(5)->get(['id','title','borrow_count','rating_avg']);

        $activeMembers = Member::withCount('borrows')->orderByDesc('borrows_count')
            ->take(5)->get(['id','user_id','member_no']);

        $recent = BorrowTransaction::with(['member.user','book'])
            ->latest()->take(10)->get();

        return view('dashboard.index', compact('stats', 'chart', 'popular', 'activeMembers', 'recent'));
    }
}
