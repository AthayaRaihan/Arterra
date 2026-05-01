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
        Schema::table('eduquality', function (Blueprint $table) {
            $table->float('eqi_score')->nullable()->after('akses_sekolah');
            $table->string('kategori')->nullable()->after('eqi_score');
            $table->string('warna')->nullable()->after('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eduquality', function (Blueprint $table) {
            $table->dropColumn(['eqi_score', 'kategori', 'warna']);
        });
    }
};
