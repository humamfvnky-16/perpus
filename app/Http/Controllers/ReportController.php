<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Checkout;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()          { return view('reports.index', $this->commonData()); }
    public function borrowed()       { return view('reports.index', $this->commonData()); }
    public function overdue()        { return view('reports.index', $this->commonData()); }
    public function popular()        { return view('reports.index', $this->commonData()); }
    public function activeMembers()  { return view('reports.index', $this->commonData()); }
    public function categories()     { return view('reports.index', $this->commonData()); }
    public function ebookStats()     { return view('reports.index', $this->commonData()); }
    public function visits()         { return view('reports.index', $this->commonData()); }

    public function pdf(string $type)
    {
        $data = match ($type) {
            'overdue' => ['title' => 'Laporan Peminjaman Terlambat', 'rows' => Checkout::overdue()->with(['user','offlineBookCopies.offlineBook'])->get()],
            'popular' => ['title' => 'Buku Populer', 'rows' => Book::orderByDesc('view_count')->take(50)->get()],
            default   => abort(404),
        };
        return Pdf::loadView('reports.pdf', $data)->download("laporan-{$type}.pdf");
    }

    public function excel(string $type) { return back()->with('toast', "Export Excel $type: implementasi Maatwebsite\Excel."); }
    public function csv(string $type)   { return back()->with('toast', "Export CSV $type: implementasi."); }

    protected function commonData(): array
    {
        return [
            'topBooks'      => Book::orderByDesc('view_count')->take(10)->get(),
            'overdue'       => Checkout::overdue()->with(['user','offlineBookCopies.offlineBook'])->get(),
            'activeMembers' => Member::withCount('checkouts')->orderByDesc('checkouts_count')->take(10)->get(),
        ];
    }
}
