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
        Schema::create('eduquality', function (Blueprint $table) {
            $table->id();
            $table->string('kabupaten/kota');
            $table->float('aps');
            $table->float('apk');
            $table->float('ruang_kelas');
            $table->float('rls');
            $table->float('rasio_guru');
            $table->float('siswa_per_sekolah');
            $table->float('dropout_rate');
            $table->float('akses_internet');
            $table->float('guru_s1');
            $table->float('sekolah_lab');
            $table->float('persebaran_sekolah');
            $table->float('akses_sekolah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eduquality');
    }
};
