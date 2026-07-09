<?php

namespace App\Http\Controllers;

use App\Models\CheckoutSetting;
use App\Models\ReadingSpot;
use Illuminate\Http\Request;

class CheckoutSettingController extends Controller
{
    public function edit(ReadingSpot $readingSpot)
    {
        $setting = CheckoutSetting::firstOrCreate(['reading_spot_id' => $readingSpot->id]);
        return view('checkout-settings.edit', compact('readingSpot', 'setting'));
    }

    public function update(Request $r, ReadingSpot $readingSpot)
    {
        $setting = CheckoutSetting::firstOrCreate(['reading_spot_id' => $readingSpot->id]);
        $data = $r->validate([
            'loan_days'          => 'required|integer|min:1|max:365',
            'max_books'          => 'required|integer|min:1|max:50',
            'daily_fine'         => 'required|integer|min:0',
            'damage_fine'        => 'required|integer|min:0',
            'lost_fine'          => 'required|integer|min:0',
            'renew_limit'        => 'required|integer|min:0|max:10',
            'hold_expires_hours' => 'required|integer|min:1|max:720',
        ]);
        $setting->update($data);
        return back()->with('toast', 'Durasi dan aturan peminjaman diperbarui.');
    }
}
