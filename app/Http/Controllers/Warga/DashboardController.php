<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Support\DemoData;

class DashboardController extends Controller
{
    public function index()
    {
        $submissions = collect(DemoData::submissions())->take(3);

        $summary = [
            'total' => 5,
            'diproses' => 2,
            'selesai' => 1,
            'ditolak' => 1,
        ];

        return view('warga.dashboard', compact('submissions', 'summary'));
    }
}
