<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BantuanProgram extends Model
{
    use HasFactory;

    protected $table = 'bantuan_programs'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'name',        // Nama program
        'description', // Deskripsi program
    ];

    /**
     * Relasi ke model Laporan (jika ada laporan terkait program ini).
     */
    public function laporanPenyaluran()
    {
        return $this->hasMany(LaporanPenyaluran::class); // Foreign key harus disesuaikan dengan database
    }
}