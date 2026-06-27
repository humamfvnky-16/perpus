<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');
        return view('settings.index', compact('settings'));
    }

    public function update(Request $r)
    {
        foreach ($r->input('settings', []) as $key => $value) Setting::set($key, $value);
        return back()->with('toast', 'Pengaturan disimpan.');
    }

    public function uploadLogo(Request $r)
    {
        $r->validate(['logo' => 'required|image|max:2048']);
        $path = $r->file('logo')->store('settings', 'public');
        Setting::set('library.logo', $path);
        return back()->with('toast', 'Logo diperbarui.');
    }

    public function uploadFavicon(Request $r)
    {
        $r->validate(['favicon' => 'required|file|max:512']);
        $path = $r->file('favicon')->store('settings', 'public');
        Setting::set('library.favicon', $path);
        return back()->with('toast', 'Favicon diperbarui.');
    }

    public function testMail(Request $r)
    {
        try {
            \Mail::raw('Tes email dari PerpusDigital', fn($m) => $m->to($r->user()->email)->subject('Tes Email'));
            return back()->with('toast', 'Tes email terkirim ke ' . $r->user()->email);
        } catch (\Throwable $e) {
            return back()->with('toast', 'Gagal kirim: ' . $e->getMessage());
        }
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return back()->with('toast', 'Cache dibersihkan.');
    }
}
