<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index()
    {
        $logs = AuditLog::with('user')->latest()->paginate(50);
        return view('audit.index', compact('logs'));
    }

    public function activity()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(50);
        return view('audit.index', compact('logs'));
    }
}
