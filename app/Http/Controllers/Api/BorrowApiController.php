<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Reservation;
use App\Services\BorrowService;
use Illuminate\Http\Request;

class BorrowApiController extends Controller
{
    public function myBorrows(Request $r)
    {
        $member = $r->user()->member;
        if (!$member) return response()->json(['data' => []]);
        return $member->borrows()->with('book')->latest()->paginate(20);
    }

    public function myFines(Request $r)
    {
        $member = $r->user()->member;
        if (!$member) return response()->json(['data' => []]);
        return $member->fines()->latest()->paginate(20);
    }

    public function myReservations(Request $r)
    {
        $member = $r->user()->member;
        if (!$member) return response()->json(['data' => []]);
        return $member->reservations()->with('book')->latest()->paginate(20);
    }

    public function checkout(Request $r, BorrowService $svc)
    {
        $r->validate(['book_id' => 'required|exists:books,id']);
        $member = $r->user()->member ?? abort(422, 'Akun bukan anggota.');
        $tx = $svc->checkout($member, Book::findOrFail($r->book_id));
        return response()->json(['ok' => true, 'id' => $tx->id, 'due_at' => $tx->due_at]);
    }

    public function checkin(Request $r) { return response()->json(['ok' => true]); }

    public function reserve(Request $r)
    {
        $r->validate(['book_id' => 'required|exists:books,id']);
        $member = $r->user()->member ?? abort(422, 'Akun bukan anggota.');
        $position = Reservation::where('book_id', $r->book_id)
            ->whereIn('status', ['pending','ready'])->count() + 1;
        $res = Reservation::create([
            'member_id'      => $member->id,
            'book_id'        => $r->book_id,
            'reserved_at'    => now(),
            'expires_at'     => now()->addHours(config('library.reservation_hours', 48)),
            'queue_position' => $position,
            'status'         => 'pending',
        ]);
        return response()->json(['ok' => true, 'id' => $res->id, 'queue_position' => $position]);
    }
}
