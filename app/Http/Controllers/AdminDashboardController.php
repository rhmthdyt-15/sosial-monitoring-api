<?php

namespace App\Http\Controllers;

use App\Models\LaporanPenyaluran;

class AdminDashboardController extends Controller
{
    public function stats()
    {
        $stats = [
            'total_laporan' => LaporanPenyaluran::count(),
            'pending' => LaporanPenyaluran::where('status', 'Pending')->count(),
            'disetujui' => LaporanPenyaluran::where('status', 'Disetujui')->count(),
            'ditolak' => LaporanPenyaluran::where('status', 'Ditolak')->count(),
        ];

        return response()->json($stats);
    }
}