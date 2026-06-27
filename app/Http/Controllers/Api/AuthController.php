<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $r)
    {
        $r->validate(['email' => 'required|email', 'password' => 'required|string']);
        $user = User::where('email', $r->email)->first();
        if (!$user || !Hash::check($r->password, $user->password)) {
            throw ValidationException::withMessages(['email' => ['Kredensial salah.']]);
        }
        return [
            'token' => $user->createToken('api', expiresAt: now()->addDays(30))->plainTextToken,
            'user'  => $user->only(['id','name','email']) + ['roles' => $user->getRoleNames()],
        ];
    }

    public function me(Request $r)
    {
        return $r->user()->load('member');
    }

    public function logout(Request $r)
    {
        $r->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
