<?php

namespace App\Http\Controllers;

use App\Models\BorrowTransaction;
use App\Services\BorrowService;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function create(Request $r)
    {
        $tx = BorrowTransaction::where('status', 'active')
            ->when($r->code,    fn($q) => $q->where('code', $r->code))
            ->when($r->barcode, fn($q) => $q->whereHas('book', fn($b) => $b->where('barcode', $r->barcode)))
            ->with(['member.user','book'])
            ->first();
        return view('returns.create', compact('tx'));
    }

    public function store(Request $r, BorrowService $svc)
    {
        $data = $r->validate([
            'borrow_transaction_id' => 'required|exists:borrow_transactions,id',
            'condition'             => 'required|in:good,damaged,lost',
            'damage_notes'          => 'nullable|string|max:1000',
        ]);
        $tx = BorrowTransaction::findOrFail($data['borrow_transaction_id']);
        $this->authorize('return', $tx);

        $ret = $svc->checkin($tx, $data['condition'], $data['damage_notes'] ?? null, $r->user()->id);
        return redirect()->route('borrows.show', $tx)
            ->with('toast', "Pengembalian sukses. Denda: Rp " . number_format($ret->fine_amount, 0, ',', '.'));
    }

    public function history(Request $r)
    {
        $rows = BorrowTransaction::where('status', '!=', 'active')
            ->with(['member.user','book','return_'])->latest()->paginate(20);
        return view('returns.history', compact('rows'));
    }
}
