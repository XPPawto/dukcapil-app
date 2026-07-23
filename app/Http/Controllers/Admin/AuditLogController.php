<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditLogController extends Controller
{
    public function index()
    {
        abort_unless(Auth::guard('admin')->user()->role === 'super_admin', 403);

        return view('admin.audit-logs.index', [
            'logs' => AuditLog::latest()->paginate(30),
        ]);
    }
}
