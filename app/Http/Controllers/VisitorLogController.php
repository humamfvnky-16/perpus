<?php

namespace App\Http\Controllers;

use App\Models\VisitorLog;

class VisitorLogController extends Controller
{
    public function index()
    {
        $logs = VisitorLog::with('user')->latest()->paginate(50);
        return view('visitors.index', compact('logs'));
    }
}
