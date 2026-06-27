<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BorrowTransaction;
use App\Models\Ebook;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index', [
            'topBooks'      => Book::orderByDesc('borrow_count')->take(10)->get(),
            'overdue'       => BorrowTransaction::overdue()->with(['member.user','book'])->get(),
            'activeMembers' => Member::withCount('borrows')->orderByDesc('borrows_count')->take(10)->get(),
        ]);
    }

    public function borrowed()   { return view('reports.index', $this->commonData()); }
    public function overdue()    { return view('reports.index', $this->commonData()); }
    public function popular()    { return view('reports.index', $this->commonData()); }
    public function activeMembers() { return view('reports.index', $this->commonData()); }
    public function categories() { return view('reports.index', $this->commonData()); }
    public function ebookStats() { return view('reports.index', $this->commonData()); }
    public function visits()     { return view('reports.index', $this->commonData()); }

    public function pdf(string $type)
    {
        $data = match ($type) {
            'overdue' => ['title' => 'Laporan Buku Terlambat', 'rows' => BorrowTransaction::overdue()->with(['member.user','book'])->get()],
            'popular' => ['title' => 'Buku Populer', 'rows' => Book::orderByDesc('borrow_count')->take(50)->get()],
            default   => abort(404),
        };
        return Pdf::loadView('reports.pdf', $data)->download("laporan-{$type}.pdf");
    }

    public function excel(string $type) { return back()->with('toast', "Export Excel $type: implementasi Maatwebsite\Excel."); }
    public function csv(string $type)   { return back()->with('toast', "Export CSV $type: implementasi."); }

    protected function commonData(): array
    {
        return [
            'topBooks'      => Book::orderByDesc('borrow_count')->take(10)->get(),
            'overdue'       => BorrowTransaction::overdue()->with(['member.user','book'])->get(),
            'activeMembers' => Member::withCount('borrows')->orderByDesc('borrows_count')->take(10)->get(),
        ];
    }
}
