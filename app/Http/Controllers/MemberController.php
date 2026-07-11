<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index(Request $r)
    {
        $this->authorize('viewAny', Member::class);
        $members = Member::with('user')
            ->when($r->q, function ($q) use ($r) {
                $q->where(function ($w) use ($r) {
                    $w->whereHas('user', fn($u) => $u->where('name','like',"%{$r->q}%")
                                                    ->orWhere('email','like',"%{$r->q}%"))
                      ->orWhere('member_no','like',"%{$r->q}%")
                      ->orWhere('nis_nip','like',"%{$r->q}%");
                });
            })
            ->when($r->type, fn($q) => $q->where('type', $r->type))
            ->orderByDesc('id')->paginate(20)->withQueryString();
        return view('members.index', compact('members'));
    }

    public function create()
    {
        $this->authorize('create', Member::class);
        return view('members.create');
    }

    public function store(StoreMemberRequest $r)
    {
        $user = User::create([
            'name'              => $r->name,
            'email'             => $r->email,
            'password'          => Hash::make($r->password),
            'email_verified_at' => now(),
        ]);
        $user->assignRole($r->type === 'teacher' ? 'teacher' : 'student');

        $member = Member::create([
            'user_id'   => $user->id,
            'member_no' => 'M-' . str_pad((string) $user->id, 6, '0', STR_PAD_LEFT),
            'nis_nip'   => $r->nis_nip,
            'type'      => $r->type,
            'class'     => $r->class,
            'major'     => $r->major,
            'address'   => $r->address,
            'birth_date'=> $r->birth_date,
            'gender'    => $r->gender,
            'joined_at' => now(),
            'expires_at'=> $r->expires_at ?: now()->addYears(2),
        ]);

        return redirect()->route('members.show', $member)->with('toast', 'Anggota ditambahkan.');
    }

    public function show(Member $member)
    {
        $this->authorize('view', $member);
        $member->load('user');
        $checkouts = $member->checkouts()->with('offlineBookCopies.offlineBook')->latest()->take(20)->get();
        return view('members.show', compact('member', 'checkouts'));
    }

    public function edit(Member $member)
    {
        $this->authorize('update', $member);
        return view('members.edit', compact('member'));
    }

    public function update(Request $r, Member $member)
    {
        $this->authorize('update', $member);
        $data = $r->validate([
            'class'      => 'nullable|string|max:50',
            'major'      => 'nullable|string|max:100',
            'address'    => 'nullable|string',
            'is_active'  => 'boolean',
            'expires_at' => 'nullable|date',
        ]);
        $member->update($data);
        return back()->with('toast', 'Anggota diperbarui.');
    }

    public function destroy(Member $member)
    {
        $this->authorize('delete', $member);
        $member->delete();
        return redirect()->route('members.index')->with('toast', 'Anggota dihapus.');
    }

    public function card(Member $member) { return view('members.card', compact('member')); }
    public function importForm()         { return view('members.import'); }
    public function import(Request $r)   { return back()->with('toast', 'Import: implementasi Maatwebsite\Excel.'); }
    public function export(string $format) { return back()->with('toast', "Export $format: implementasi."); }
}
