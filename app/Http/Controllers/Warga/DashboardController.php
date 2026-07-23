<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $citizen = Auth::guard('citizen')->user();

        $submissions = $citizen->submissions()->latest()->take(3)->get();

        $summary = [
            'total' => $citizen->submissions()->count(),
            'diproses' => $citizen->submissions()->whereIn('status', ['SUBMITTED', 'IN_REVIEW'])->count(),
            'selesai' => $citizen->submissions()->where('status', 'APPROVED')->count(),
            'ditolak' => $citizen->submissions()->where('status', 'REJECTED')->count(),
        ];

        return view('warga.dashboard', compact('submissions', 'summary'));
    }
}
