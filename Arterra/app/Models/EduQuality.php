<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EduQuality extends Model
{
    use HasFactory;

    protected $table = 'eduquality';

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
        'eqi_score',
        'kategori',
        'warna',
    ];

    protected $casts = [
        'aps'               => 'float',
        'apk'               => 'float',
        'ruang_kelas'       => 'float',
        'rls'               => 'float',
        'rasio_guru'        => 'float',
        'siswa_per_sekolah' => 'float',
        'dropout_rate'      => 'float',
        'akses_internet'    => 'float',
        'guru_s1'           => 'float',
        'sekolah_lab'       => 'float',
        'persebaran_sekolah'=> 'float',
        'akses_sekolah'     => 'float',
        'eqi_score'         => 'float',
    ];
}
