<?php

namespace App\Http\Controllers;

use App\Models\LaporanPenyaluran;
use App\Notifications\LaporanStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class AdminLaporanController extends Controller
{
    public function index()
    {
        $laporans = LaporanPenyaluran::with(['user', 'program'])->get();

        return response()->json($laporans, 200);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'status' => 'required|in:Pending,Disetujui,Ditolak',
            'alasan_penolakan' => 'nullable|string',
        ]);

        // Jika status adalah 'Ditolak', pastikan alasan_penolakan diisi
        if ($validated['status'] === 'Ditolak' && empty($validated['alasan_penolakan'])) {
            return response()->json(['message' => 'Alasan penolakan harus diisi ketika status ditolak.'], 422);
        }

        // Temukan laporan berdasarkan ID
        $laporan = LaporanPenyaluran::findOrFail($id);

        // Update laporan
        $laporan->update($validated);

        // Kirim notifikasi email
        Notification::send($laporan->user, new LaporanStatusUpdated($laporan));

        return response()->json(['message' => 'Laporan updated successfully']);
    }
}
