<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LaporanCreateRequest;
use App\Http\Requests\UpdateLaporanRequest;
use App\Models\LaporanPenyaluran;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function getLaporan(Request $request)
    {
        $laporans = LaporanPenyaluran::where('user_id', $request->user()->id)->get();

        return response()->json($laporans);
    }

        public function store(LaporanCreateRequest $request)
        {
            $validated = $request->validated();

            // Ambil data kecamatan berdasarkan region_id
            $kecamatan = Region::findOrFail($validated['region_id']);
            if ($kecamatan->type !== 'Kecamatan') {
                return response()->json(['message' => 'region_id harus berupa Kecamatan'], 422);
            }

            // Ambil data kabupaten dan provinsi berdasarkan parent_id
            $kabupaten = Region::find($kecamatan->parent_id);
            $provinsi = $kabupaten ? Region::find($kabupaten->parent_id) : null;

            $validated['wilayah'] = json_encode([
                'provinsi' => $provinsi ? $provinsi->name : null,
                'kabupaten' => $kabupaten ? $kabupaten->name : null,
                'kecamatan' => $kecamatan->name,
            ]);

            $validated['user_id'] = $request->user()->id;

            // Simpan file bukti_penyaluran
            $validated['bukti_penyaluran'] = $request->file('bukti_penyaluran')->store('bukti_penyaluran', 'public');

            // Simpan laporan ke database
            $laporan = LaporanPenyaluran::create($validated);

            return response()->json(['laporan' => $laporan], 201);
        }


    public function update(UpdateLaporanRequest $request, $id)
    {
        $laporan = LaporanPenyaluran::where('user_id', $request->user()->id)->findOrFail($id);

        // Cek apakah laporan berstatus "Pending"
        if ($laporan->status !== 'Pending') {
            return response()->json(['message' => 'Laporan yang sudah diverifikasi tidak dapat diubah'], 403);
        }

        $validated = $request->validated();

        if ($request->hasFile('bukti_penyaluran')) {
            // Hapus file lama
            Storage::disk('public')->delete($laporan->bukti_penyaluran);

            // Simpan file baru
            $validated['bukti_penyaluran'] = $request->file('bukti_penyaluran')->store('bukti_penyaluran', 'public');
        }

        // Update data laporan
        $laporan->update($validated);

        return response()->json(['message' => 'Laporan updated successfully']);
    }

    public function destroy(Request $request, $id)
    {
        $laporan = LaporanPenyaluran::where('user_id', $request->user()->id)->findOrFail($id);

        // Cek apakah laporan berstatus "Pending"
        if ($laporan->status !== 'Pending') {
            return response()->json(['message' => 'Laporan yang sudah diverifikasi tidak dapat dihapus'], 403);
        }

        Storage::disk('public')->delete($laporan->bukti_penyaluran);
        $laporan->delete();

        return response()->json(['message' => 'Laporan deleted successfully']);
    }

}