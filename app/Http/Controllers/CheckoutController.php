<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\OfflineBookCopy;
use App\Models\ReadingSpot;
use App\Models\User;
use App\Services\CheckoutService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $r)
    {
        $rows = Checkout::with(['user','readingSpot','offlineBookCopies.offlineBook'])
            ->when($r->status === 'active',   fn($q) => $q->active())
            ->when($r->status === 'returned', fn($q) => $q->where('is_returned', true))
            ->when($r->status === 'overdue',  fn($q) => $q->overdue())
            ->latest()->paginate(20)->withQueryString();
        return view('checkouts.index', compact('rows'));
    }

    public function create()
    {
        return view('checkouts.create', [
            'spots' => ReadingSpot::active()->orderBy('name')->get(),
            'users' => User::orderBy('name')->limit(200)->get(['id','name','email']),
        ]);
    }

    public function store(Request $r, CheckoutService $svc)
    {
        $data = $r->validate([
            'user_id'         => 'required|exists:users,id',
            'reading_spot_id' => 'required|exists:reading_spots,id',
            'copy_ids'        => 'required|array',
            'copy_ids.*'      => 'integer|exists:offline_book_copies,id',
            'days'            => 'nullable|integer|min:1|max:30',
        ]);
        $checkout = $svc->checkout(
            User::findOrFail($data['user_id']),
            ReadingSpot::findOrFail($data['reading_spot_id']),
            $data['copy_ids'],
            $r->user()->id,
            $data['days'] ?? null
        );
        return redirect()->route('checkouts.show', $checkout)->with('toast', 'Checkout berhasil.');
    }

    public function show(Checkout $checkout)
    {
        $checkout->load(['user','staff','readingSpot','offlineBookCopies.offlineBook']);
        return view('checkouts.show', compact('checkout'));
    }

    public function checkin(Checkout $checkout, CheckoutService $svc, Request $r)
    {
        $data = $r->validate([
            'condition'    => 'nullable|in:good,damaged,lost',
            'damage_notes' => 'nullable|string|max:500',
        ]);
        $svc->checkin($checkout, $r->user()->id, $data['condition'] ?? 'good', $data['damage_notes'] ?? null);
        $msg = $checkout->fine_amount > 0
            ? 'Pengembalian sukses. Denda: Rp '.number_format($checkout->fine_amount,0,',','.')
            : 'Pengembalian sukses tanpa denda.';
        return back()->with('toast', $msg);
    }

    public function lookupCopy(Request $r)
    {
        $copy = OfflineBookCopy::with('offlineBook')
            ->where('catalog_code', $r->code)
            ->orWhere('barcode', $r->code)
            ->first();
        return response()->json($copy);
    }
}
