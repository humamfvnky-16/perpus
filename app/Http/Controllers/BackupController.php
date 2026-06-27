<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        return view('backups.index');
    }

    public function run()
    {
        try {
            Artisan::call('backup:run', ['--only-db' => true]);
            return back()->with('toast', 'Backup database berhasil.');
        } catch (\Throwable $e) {
            return back()->with('toast', 'Gagal: ' . $e->getMessage());
        }
    }

    public function download(string $file)
    {
        $path = "Laravel/$file";
        abort_unless(Storage::exists($path), 404);
        return Storage::download($path);
    }

    public function destroy(string $file)
    {
        Storage::delete("Laravel/$file");
        return back()->with('toast', 'Backup dihapus.');
    }
}
