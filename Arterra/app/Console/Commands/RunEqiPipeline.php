<?php

namespace App\Console\Commands;

use App\Models\EduQuality;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class RunEqiPipeline extends Command
{
    protected $signature   = 'eqi:run-pipeline';
    protected $description = 'Fetch all kabupaten features, call FastAPI /predict-batch, save EQI results to DB';

    private string $fastApiUrl = 'http://127.0.0.1:8001';

    public function handle(): int
    {
        $records = EduQuality::all();

        if ($records->isEmpty()) {
            $this->error('No records in eduquality table. Run seeder first.');
            return 1;
        }

        $this->info("Sending {$records->count()} records to FastAPI...");

        $payload = $records->map(function ($r) {
            return [
                'aps'                => (float) $r->aps,
                'apk'                => (float) $r->apk,
                'ruang_kelas_layak'  => (float) $r->ruang_kelas,
                'rata_lama_sekolah'  => (float) $r->rls,
                'rasio_guru_siswa'   => (float) $r->rasio_guru,
                'siswa_per_sekolah'  => (float) $r->siswa_per_sekolah,
                'dropout_rate'       => (float) $r->dropout_rate,
                'akses_internet'     => (float) $r->akses_internet,
                'guru_s1'            => (float) $r->guru_s1,
                'sekolah_lab'        => (float) $r->sekolah_lab,
                'persebaran_sekolah' => (float) $r->persebaran_sekolah,
                'akses_sekolah'      => (float) $r->akses_sekolah,
            ];
        })->values()->toArray();

        $response = Http::timeout(30)->post("{$this->fastApiUrl}/predict-batch", $payload);

        if (!$response->successful()) {
            $this->error("FastAPI error {$response->status()}: " . $response->body());
            return 1;
        }

        $result = $response->json();

        if (($result['status'] ?? '') !== 'success') {
            $this->error('FastAPI returned: ' . json_encode($result));
            return 1;
        }

        $hasilByIndex = [];
        foreach ($result['hasil'] as $item) {
            $hasilByIndex[$item['index']] = $item;
        }

        $saved = 0;
        foreach ($records as $i => $record) {
            if (!isset($hasilByIndex[$i])) continue;

            $score    = $hasilByIndex[$i]['eqi_score'];
            $kategori = $hasilByIndex[$i]['kategori'];
            $hue      = round(($score / 100) * 142);
            $warna    = $this->hslToHex($hue, 80, 42);

            $record->eqi_score = $score;
            $record->kategori  = $kategori;
            $record->warna     = $warna;
            $record->save();
            $saved++;
        }

        $this->info("✓ Saved EQI scores for {$saved} kabupaten/kota.");

        // Print top 5
        EduQuality::orderByDesc('eqi_score')->take(5)->get()->each(function ($r) {
            $name  = $r->{'kabupaten/kota'};
            $score = number_format($r->eqi_score, 2);
            $this->line("  {$name}: {$score} ({$r->kategori})");
        });

        return 0;
    }

    private function hslToHex(int $h, int $s, int $l): string
    {
        $s /= 100; $l /= 100;
        $c = (1 - abs(2 * $l - 1)) * $s;
        $x = $c * (1 - abs(fmod($h / 60, 2) - 1));
        $m = $l - $c / 2;
        if ($h < 60)      { $r = $c; $g = $x; $b = 0; }
        elseif ($h < 120) { $r = $x; $g = $c; $b = 0; }
        elseif ($h < 180) { $r = 0;  $g = $c; $b = $x; }
        elseif ($h < 240) { $r = 0;  $g = $x; $b = $c; }
        elseif ($h < 300) { $r = $x; $g = 0;  $b = $c; }
        else              { $r = $c; $g = 0;  $b = $x; }
        return sprintf('#%02x%02x%02x',
            round(($r + $m) * 255),
            round(($g + $m) * 255),
            round(($b + $m) * 255)
        );
    }
}
