<?php

namespace App\Http\Controllers;

use App\Models\Hold;
use App\Models\OfflineBookCopy;
use App\Models\ReadingSpot;
use App\Services\CheckoutService;
use Illuminate\Http\Request;

class HoldController extends Controller
{
    public function index(Request $r)
    {
        $rows = Hold::with(['user','readingSpot','offlineBookCopies.offlineBook'])
            ->when($r->status, fn($q) => $q->where('status', $r->status))
            ->latest()->paginate(20);
        return view('holds.index', compact('rows'));
    }

    public function store(Request $r, CheckoutService $svc)
    {
        $data = $r->validate([
            'reading_spot_id' => 'required|exists:reading_spots,id',
            'copy_ids'        => 'required|array',
            'copy_ids.*'      => 'integer|exists:offline_book_copies,id',
            'notes'           => 'nullable|string|max:500',
        ]);
        $hold = $svc->placeHold(
            $r->user(),
            ReadingSpot::findOrFail($data['reading_spot_id']),
            $data['copy_ids'],
            $data['notes'] ?? null
        );
        return redirect()->route('holds.index')->with('toast', 'Hold dibuat (kedaluwarsa: '.$hold->expires_at->format('d M Y H:i').').');
    }

    public function fulfill(Hold $hold, CheckoutService $svc, Request $r)
    {
        $checkout = $svc->fulfillHold($hold, $r->user()->id);
        return redirect()->route('checkouts.show', $checkout)->with('toast', 'Hold dijadikan checkout.');
    }

    public function cancel(Hold $hold, CheckoutService $svc)
    {
        abort_unless($hold->user_id === auth()->id() || auth()->user()->can('borrow.return'), 403);
        $svc->cancelHold($hold);
        return back()->with('toast', 'Hold dibatalkan.');
    }
}
