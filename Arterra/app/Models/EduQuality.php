<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EduQuality extends Model
{
    use HasFactory;

    protected $fillable = [
        'kabupaten/kota',
        'aps',
        'apk',
        'ruang_kelas',
        'rls',
        'rasio_guru',
        'siswa_per_sekolah',
        'dropout_rate',
        'akses_internet',
        'guru_s1',
        'sekolah_lab',
        'persebaran_sekolah',
        'akses_sekolah',
    ];
}
