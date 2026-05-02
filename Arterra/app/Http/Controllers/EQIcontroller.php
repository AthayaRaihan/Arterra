<?php

namespace App\Http\Controllers;

use App\Models\EduQuality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EQIcontroller extends Controller
{
    /** URL of the FastAPI ML service */
    private string $fastApiUrl = 'http://127.0.0.1:8001';

    // ─────────────────────────────────────────────────────────────────────────
    // PAGE: render the EQI view (passes eqi_data as JSON to the blade)
    // ─────────────────────────────────────────────────────────────────────────

    public function index()
    {
        $records = EduQuality::all();

        // If EQI scores not yet computed, run the pipeline first
        if ($records->whereNull('eqi_score')->count() === $records->count() && $records->count() > 0) {
            $this->runPipeline();
            $records = EduQuality::all();
        }

        return view('EQI', ['eqiData' => $records]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // API: Return all EQI data as JSON (used by the map / ranking JS)
    // ─────────────────────────────────────────────────────────────────────────

    public function getData()
    {
        $records = EduQuality::orderByDesc('eqi_score')->get();

        $data = $records->map(function ($r) {
            return [
                'nama'                => $r->{'kabupaten/kota'},
                'eqi_score'           => $r->eqi_score,
                'kategori'            => $r->kategori,
                'warna'               => $r->warna,
                // 12 feature values
                'aps'                 => $r->aps,
                'apk'                 => $r->apk,
                'ruang_kelas'         => $r->ruang_kelas,
                'rls'                 => $r->rls,
                'rasio_guru'          => $r->rasio_guru,
                'siswa_per_sekolah'   => $r->siswa_per_sekolah,
                'dropout_rate'        => $r->dropout_rate,
                'akses_internet'      => $r->akses_internet,
                'guru_s1'             => $r->guru_s1,
                'sekolah_lab'         => $r->sekolah_lab,
                'persebaran_sekolah'  => $r->persebaran_sekolah,
                'akses_sekolah'       => $r->akses_sekolah,
            ];
        });

        return response()->json([
            'status' => 'success',
            'total'  => $data->count(),
            'data'   => $data,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // API: Force re-run the FastAPI pipeline and save results to DB
    // ─────────────────────────────────────────────────────────────────────────

    public function refreshEqi()
    {
        try {
            $count = $this->runPipeline();
            return response()->json([
                'status'  => 'success',
                'message' => "EQI berhasil dihitung untuk {$count} kabupaten/kota.",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PRIVATE: Core pipeline — fetch from DB, call FastAPI, save back
    // ─────────────────────────────────────────────────────────────────────────

    private function runPipeline(): int
    {
        $records = EduQuality::all();

        if ($records->isEmpty()) {
            throw new \Exception('Tidak ada data kabupaten di database. Jalankan seeder terlebih dahulu.');
        }

        // Build the batch payload matching FastAPI EQIInput schema
        $payload = $records->map(function ($r) {
            return [
                'aps'                => (float) $r->aps,
                'apk'                => (float) $r->apk,
                'ruang_kelas_layak'  => (float) $r->ruang_kelas,   // DB: ruang_kelas
                'rata_lama_sekolah'  => (float) $r->rls,            // DB: rls
                'rasio_guru_siswa'   => (float) $r->rasio_guru,     // DB: rasio_guru
                'siswa_per_sekolah'  => (float) $r->siswa_per_sekolah,
                'dropout_rate'       => (float) $r->dropout_rate,
                'akses_internet'     => (float) $r->akses_internet,
                'guru_s1'            => (float) $r->guru_s1,
                'sekolah_lab'        => (float) $r->sekolah_lab,
                'persebaran_sekolah' => (float) $r->persebaran_sekolah,
                'akses_sekolah'      => (float) $r->akses_sekolah,
            ];
        })->values()->toArray();

        // Call FastAPI /predict-batch
        $response = Http::timeout(30)->post("{$this->fastApiUrl}/predict-batch", $payload);

        if (!$response->successful()) {
            throw new \Exception("FastAPI error ({$response->status()}): " . $response->body());
        }

        $result = $response->json();

        if (($result['status'] ?? '') !== 'success') {
            throw new \Exception('FastAPI returned non-success: ' . json_encode($result));
        }

        // Map hasil back by original index (FastAPI returns sorted list, use 'index' field)
        $hasilByIndex = [];
        foreach ($result['hasil'] as $item) {
            $hasilByIndex[$item['index']] = $item;
        }

        // Save EQI results back to DB
        foreach ($records as $i => $record) {
            if (!isset($hasilByIndex[$i])) {
                continue;
            }

            $score    = $hasilByIndex[$i]['eqi_score'];
            $kategori = $hasilByIndex[$i]['kategori'];
            $warna    = $this->scoreToHslColor($score);

            $record->eqi_score = $score;
            $record->kategori  = $kategori;
            $record->warna     = $warna;
            $record->save();
        }

        return $records->count();
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PRIVATE: Convert EQI score (0–100) to a continuous HSL hex color
    //   100 → green (#22c55e-ish, hue=142)
    //   50  → yellow (#f59e0b-ish, hue=45)
    //   0   → red   (#ef4444-ish, hue=0)
    // ─────────────────────────────────────────────────────────────────────────

    private function scoreToHslColor(float $score): string
    {
        $score = max(0, min(100, $score));
        // Map 0–100 → hue 0–142
        $hue = round(($score / 100) * 142);
        // Convert HSL to hex
        return $this->hslToHex($hue, 80, 45);
    }

    private function hslToHex(int $h, int $s, int $l): string
    {
        $s /= 100;
        $l /= 100;

        $c = (1 - abs(2 * $l - 1)) * $s;
        $x = $c * (1 - abs(fmod($h / 60, 2) - 1));
        $m = $l - $c / 2;

        if ($h < 60)       { $r = $c; $g = $x; $b = 0; }
        elseif ($h < 120)  { $r = $x; $g = $c; $b = 0; }
        elseif ($h < 180)  { $r = 0; $g = $c; $b = $x; }
        elseif ($h < 240)  { $r = 0; $g = $x; $b = $c; }
        elseif ($h < 300)  { $r = $x; $g = 0; $b = $c; }
        else               { $r = $c; $g = 0; $b = $x; }

        $r = round(($r + $m) * 255);
        $g = round(($g + $m) * 255);
        $b = round(($b + $m) * 255);

        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
}
