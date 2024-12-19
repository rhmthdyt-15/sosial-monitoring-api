<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_penyalurans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('bantuan_programs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('jumlah_penerima');
            $table->json('wilayah');
            $table->date('tanggal_penyaluran');
            $table->string('bukti_penyaluran');
            $table->text('catatan_tambahan')->nullable();
            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_penyalurans');
    }
};