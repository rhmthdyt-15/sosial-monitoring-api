<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPenyaluran extends Model
{
    use HasFactory;

    protected $table = 'laporan_penyalurans'; // Nama tabel eksplisit

    protected $fillable = [
        'program_id',
        'user_id',
        'jumlah_penerima',
        'wilayah',
        'tanggal_penyaluran',
        'bukti_penyaluran',
        'catatan_tambahan',
        'status',
        'alasan_penolakan',
    ];

    protected $casts = [
        'wilayah' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(BantuanProgram::class, 'program_id');
    }

}
