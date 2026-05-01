<?php
// app/Http/Controllers/SimulationController.php

namespace App\Http\Controllers;

use App\Models\EduQuality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SimulationController extends Controller
{
    protected string $apiUrl;

    // Mapping nama fitur API → label tampilan
    protected array $labelFitur = [
        'aps'                        => 'Angka Partisipasi Sekolah (APS)',
        'apk'                        => 'Angka Partisipasi Kasar (APK)',
        'ruang_kelas_layak_(%)'      => 'Ruang Kelas Layak (%)',
        'rata"_lama_sekolah_(tahun)' => 'Rata-rata Lama Sekolah (Tahun)',
        'rasio_guru_siswa'           => 'Rasio Guru per Siswa',
        'siswa_per_sekolah'          => 'Siswa per Sekolah',
        'dropout_rate'               => 'Dropout Rate (%)',
        'akses_internet(%)'          => 'Akses Internet (%)',
        'guru_s1(%)'                 => 'Guru Berkualifikasi S1 (%)',
        'sekolah_lab(%)'             => 'Sekolah dengan Lab (%)',
        'persebaran_sekolah'         => 'Persebaran Sekolah',
        'akses_sekolah'              => 'Akses Sekolah',
    ];

    public function __construct()
    {
        $this->apiUrl = config('services.ml_api.url');
    }

    // ── Halaman utama simulasi ────────────────────────────────
    public function index()
    {
        return view('Simulation', [
            'label_fitur' => $this->labelFitur,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateInput($request);

        $response = Http::timeout(15)->post("{$this->apiUrl}/predict", $this->mapForApi($validated));

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghitung EQI. Periksa koneksi ke API.'
            ], 500);
        }

        $apiData = $response->json();
        $record = EduQuality::create($this->mapForDb($validated, $apiData));

        return response()->json([
            'success' => true,
            'data'    => EduQuality::find($record->id)
        ]);
    }

    // ── Hitung EQI awal dari input user ──────────────────────
    public function hitungEqi(Request $request)
    {
        $validated = $this->validateInput($request);

        $response = Http::timeout(15)->post("{$this->apiUrl}/predict", $this->mapForApi($validated));

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghitung EQI. Periksa koneksi ke API.'
            ], 500);
        }

        $apiData = $response->json();
        $record = EduQuality::create($this->mapForDb($validated, $apiData));

        return response()->json([
            'success' => true,
            'data'    => EduQuality::find($record->id)
        ]);
    }

    // ── Simulasi what-if satu fitur ───────────────────────────
    public function whatIf(Request $request)
    {
        $request->validate([
            'data_kabupaten'          => 'required|array',
            'data_kabupaten.*'        => 'required|numeric',
            'fitur_diubah'            => 'required|string',
            'perubahan'               => 'required|numeric',
        ]);

        $response = Http::timeout(15)->post("{$this->apiUrl}/what-if", [
            'data_kabupaten' => $request->data_kabupaten,
            'fitur_diubah'   => $request->fitur_diubah,
            'perubahan'      => (float) $request->perubahan,
        ]);

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menjalankan simulasi.'
            ], 500);
        }

        $hasil = $response->json();

        // Tambahkan label fitur yang readable
        $hasil['label_fitur'] = $this->labelFitur[$request->fitur_diubah] ?? $request->fitur_diubah;

        return response()->json([
            'success' => true,
            'data'    => $hasil
        ]);
    }

    // ── Analisis sensitivitas semua fitur ─────────────────────
    public function sensitivity(Request $request)
    {
        $request->validate([
            'data_kabupaten'   => 'required|array',
            'data_kabupaten.*' => 'required|numeric',
            'perubahan'        => 'nullable|numeric',
        ]);

        $response = Http::timeout(30)->post("{$this->apiUrl}/sensitivity", [
            'data_kabupaten' => $request->data_kabupaten,
            'perubahan'      => (float) ($request->perubahan ?? 5.0),
        ]);

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menjalankan analisis sensitivitas.'
            ], 500);
        }

        $hasil = $response->json();

        // Tambahkan label readable untuk setiap fitur
        $hasil['hasil'] = array_map(function ($item) {
            $item['label'] = $this->labelFitur[$item['fitur']] ?? $item['fitur'];
            return $item;
        }, $hasil['hasil']);

        return response()->json([
            'success' => true,
            'data'    => $hasil
        ]);
    }

    private function validateInput(Request $request): array
    {
        return $request->validate([
            'kabupaten_kota'    => 'required|string',
            'aps'               => 'required|numeric|min:0',
            'apk'               => 'required|numeric|min:0',
            'ruang_kelas_layak' => 'required|numeric|min:0|max:100',
            'rata_lama_sekolah' => 'required|numeric|min:0',
            'rasio_guru_siswa'  => 'required|numeric|min:0',
            'siswa_per_sekolah' => 'required|numeric|min:0',
            'dropout_rate'      => 'required|numeric|min:0|max:100',
            'akses_internet'    => 'required|numeric|min:0|max:100',
            'guru_s1'           => 'required|numeric|min:0|max:100',
            'sekolah_lab'       => 'required|numeric|min:0|max:100',
            'persebaran_sekolah'=> 'required|numeric|min:0',
            'akses_sekolah'     => 'required|numeric|min:0',
        ]);
    }

    private function mapForApi(array $validated): array
    {
        return [
            'aps'               => $validated['aps'],
            'apk'               => $validated['apk'],
            'ruang_kelas_layak' => $validated['ruang_kelas_layak'],
            'rata_lama_sekolah' => $validated['rata_lama_sekolah'],
            'rasio_guru_siswa'  => $validated['rasio_guru_siswa'],
            'siswa_per_sekolah' => $validated['siswa_per_sekolah'],
            'dropout_rate'      => $validated['dropout_rate'],
            'akses_internet'    => $validated['akses_internet'],
            'guru_s1'           => $validated['guru_s1'],
            'sekolah_lab'       => $validated['sekolah_lab'],
            'persebaran_sekolah'=> $validated['persebaran_sekolah'],
            'akses_sekolah'     => $validated['akses_sekolah'],
        ];
    }

    private function mapForDb(array $validated, array $apiData): array
    {
        return [
            'kabupaten/kota'    => $validated['kabupaten_kota'],
            'aps'               => $validated['aps'],
            'apk'               => $validated['apk'],
            'ruang_kelas'       => $validated['ruang_kelas_layak'],
            'rls'               => $validated['rata_lama_sekolah'],
            'rasio_guru'        => $validated['rasio_guru_siswa'],
            'siswa_per_sekolah' => $validated['siswa_per_sekolah'],
            'dropout_rate'      => $validated['dropout_rate'],
            'akses_internet'    => $validated['akses_internet'],
            'guru_s1'           => $validated['guru_s1'],
            'sekolah_lab'       => $validated['sekolah_lab'],
            'persebaran_sekolah'=> $validated['persebaran_sekolah'],
            'akses_sekolah'     => $validated['akses_sekolah'],
            'eqi_score'         => $apiData['eqi_score'] ?? null,
            'kategori'          => $apiData['kategori'] ?? null,
            'warna'             => $apiData['warna'] ?? null,
        ];
    }
}
