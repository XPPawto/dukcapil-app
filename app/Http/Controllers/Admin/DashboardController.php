<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;

class DashboardController extends Controller
{
    public function index()
    {
        $kpi = [
            'total' => Submission::count(),
            'pending' => Submission::where('status', 'SUBMITTED')->count(),
            'diproses' => Submission::where('status', 'IN_REVIEW')->count(),
            'disetujui' => Submission::where('status', 'APPROVED')->count(),
            'ditolak' => Submission::where('status', 'REJECTED')->count(),
        ];

        return view('admin.dashboard', [
            'kpi' => $kpi,
            'terbaru' => Submission::with('citizen')->latest()->take(5)->get(),
        ]);
    }
}
