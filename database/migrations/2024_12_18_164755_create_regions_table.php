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
        Schema::create('regions', function (Blueprint $table) {
           $table->id();
            $table->string('name');
            $table->enum('type', ['Provinsi', 'Kota', 'Kabupaten', 'Kecamatan']);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('external_id')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};