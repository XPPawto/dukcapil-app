<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\DemoData;

class DashboardController extends Controller
{
    public function index()
    {
        $submissions = collect(DemoData::submissions());

        $kpi = [
            'total' => $submissions->count(),
            'pending' => $submissions->where('status', 'SUBMITTED')->count(),
            'diproses' => $submissions->where('status', 'IN_REVIEW')->count(),
            'disetujui' => $submissions->where('status', 'APPROVED')->count(),
            'ditolak' => $submissions->where('status', 'REJECTED')->count(),
        ];

        return view('admin.dashboard', [
            'kpi' => $kpi,
            'terbaru' => $submissions->take(5),
        ]);
    }
}
