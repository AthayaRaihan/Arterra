<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('assets/icon.png') }}">
        <title>{{ config('app.name') }} </title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#F3F6FB] text-[#0F172A]">
        <div class="min-h-screen">
            <x-sidebar />
            <main class="lg:pl-72">
                <section class="relative overflow-hidden bg-[#F8FAFC] px-6 py-8 text-[#1F2937]">
                    <div class="pointer-events-none absolute inset-0">
                        <div class="absolute -top-32 right-10 h-64 w-64 rounded-full bg-[#1E3A8A]/12 blur-3xl"></div>
                        <div class="absolute bottom-0 left-10 h-48 w-48 rounded-full bg-[#4CAF50]/15 blur-3xl"></div>
                    </div>
                    <div class="relative">
                        <header class="flex flex-wrap items-start justify-between gap-6">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Simulasi Data EQI</p>
                                <h1 class="mt-2 text-3xl font-semibold">Uji Coba Faktor-Faktor Pendidikan</h1>
                                <p class="mt-2 max-w-2xl text-sm text-slate-600">Ubah faktor-faktor pendidikan untuk melihat dampaknya terhadap Education Quality Index (EQI) kabupaten/kota pilihan Anda.</p>
                            </div>
                        </header>

                        <!-- Region & Year Selection -->
                        <section class="mt-8">
                            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                                    <!-- Region Select -->
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Kabupaten/Kota</label>
                                        <div class="relative">
                                            <select id="regionSelect" class="w-full appearance-none rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20">
                                                <option value="" selected disabled>Pilih wilayah...</option>
                                                @foreach($kabupatenList as $kab)
                                                    <option value="{{ $kab }}">{{ $kab }}</option>
                                                @endforeach
                                            </select>
                                            <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Reset Button -->
                                    <div class="flex items-end">
                                        <button id="resetBtn" class="w-full rounded-xl bg-slate-200 hover:bg-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition">Atur Ulang</button>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Main Content - Hidden until selection -->
                        <div id="simulationContent" class="hidden mt-8">
                            <!-- Input Factors Grid -->
                            <section class="mt-6">
                                <h2 class="text-lg font-semibold text-[#1F2937] mb-4">Ubah Faktor-Faktor Pendidikan</h2>
                                
                                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                                    <!-- Rata-rata Lama Sekolah -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Rata-rata Lama Sekolah (RLS)</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputRLS" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="20" step="0.1">
                                            <span class="text-sm text-slate-500">tahun</span>
                                        </div>
                                        <input type="range" id="sliderRLS" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="20" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 20 tahun</p>
                                    </div>

                                    <!-- APS -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Angka Partisipasi Sekolah (APS)</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputAPS" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">%</span>
                                        </div>
                                        <input type="range" id="sliderAPS" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100%</p>
                                    </div>

                                    <!-- APK -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Angka Partisipasi Kasar (APK)</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputAPK" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">%</span>
                                        </div>
                                        <input type="range" id="sliderAPK" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100%</p>
                                    </div>

                                    <!-- Ruang Kelas Layak -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Ruang Kelas Layak</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputRuangKelas" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">%</span>
                                        </div>
                                        <input type="range" id="sliderRuangKelas" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100%</p>
                                    </div>

                                    <!-- Rasio Guru Siswa -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Rasio Guru per Siswa</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputRasioGuru" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">rasio</span>
                                        </div>
                                        <input type="range" id="sliderRasioGuru" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100</p>
                                    </div>

                                    <!-- Siswa per Sekolah -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Siswa per Sekolah</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputSiswaPerSekolah" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="2000" step="1">
                                            <span class="text-sm text-slate-500">siswa</span>
                                        </div>
                                        <input type="range" id="sliderSiswaPerSekolah" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="2000" step="1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 2000 siswa</p>
                                    </div>

                                    <!-- Dropout Rate -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Dropout Rate</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputDropout" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">%</span>
                                        </div>
                                        <input type="range" id="sliderDropout" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100%</p>
                                    </div>

                                    <!-- Akses Internet -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Akses Internet</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputAksesInternet" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">%</span>
                                        </div>
                                        <input type="range" id="sliderAksesInternet" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100%</p>
                                    </div>

                                    <!-- Guru S1 -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Guru Berkualifikasi S1</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputGuruS1" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">%</span>
                                        </div>
                                        <input type="range" id="sliderGuruS1" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100%</p>
                                    </div>

                                    <!-- Sekolah Lab -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Sekolah dengan Lab</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputSekolahLab" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">%</span>
                                        </div>
                                        <input type="range" id="sliderSekolahLab" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100%</p>
                                    </div>

                                    <!-- Persebaran Sekolah -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Persebaran Sekolah</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputPersebaran" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">indeks</span>
                                        </div>
                                        <input type="range" id="sliderPersebaran" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100</p>
                                    </div>

                                    <!-- Akses Sekolah -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Akses Sekolah</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputAksesSekolah" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">indeks</span>
                                        </div>
                                        <input type="range" id="sliderAksesSekolah" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100</p>
                                    </div>
                                </div>
                            </section>

                            <!-- Results Section -->
                            <section class="mt-8">
                                <h2 class="text-lg font-semibold text-[#1F2937] mb-4">Hasil Simulasi</h2>
                                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                                    <!-- Current EQI -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">EQI Saat Ini</p>
                                        <p class="mt-3 text-4xl font-bold text-[#1E3A8A]"><span id="currentEQI">0</span><span class="text-lg text-slate-500">/100</span></p>
                                        <div class="mt-3 h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                            <div id="eqiBar" class="h-full bg-linear-to-r from-[#ef4444] to-[#10b981] rounded-full transition-all duration-500" style="width: 0%"></div>
                                        </div>
                                    </div>

                                    <!-- Original EQI -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">EQI Asli</p>
                                        <p class="mt-3 text-4xl font-bold text-slate-400"><span id="originalEQI">0</span><span class="text-lg text-slate-500">/100</span></p>
                                        <p class="mt-3 text-sm text-slate-500">Data tahun <span id="selectedYear">-</span></p>
                                    </div>

                                    <!-- Difference -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Perubahan EQI</p>
                                        <p class="mt-3 text-4xl font-bold" id="eqiDifference"><span>0</span><span class="text-lg text-slate-500">/100</span></p>
                                        <p class="mt-3 text-sm" id="eqiDifferencePercent">+0.0%</p>
                                    </div>

                                    <!-- Quality Rank -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Kategori Kualitas</p>
                                        <p class="mt-3 text-3xl font-bold text-[#1E3A8A]" id="qualityRank">Rendah</p>
                                        <div class="mt-3 flex items-center gap-1">
                                            <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                                <div id="qualityBar" class="h-full bg-[#1E3A8A] rounded-full" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </main>
        </div>

        <script>
            const apiEndpoints = {
                hitungEqi: "{{ route('simulation.hitung-eqi') }}",
                kabupatenData: "{{ route('simulation.kabupaten-data') }}"
            };

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            async function postJson(url, payload) {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });
                return response.json();
            }

            let currentRegion = null;
            let originalData = null;
            let baselineEqi = null;
            let debounceTimer = null;

            const regionSelect = document.getElementById('regionSelect');
            const simulationContent = document.getElementById('simulationContent');
            const resetBtn = document.getElementById('resetBtn');

            // Input elements
            const inputs = {
                rls: document.getElementById('inputRLS'),
                aps: document.getElementById('inputAPS'),
                apk: document.getElementById('inputAPK'),
                ruang_kelas_layak: document.getElementById('inputRuangKelas'),
                rasio_guru_siswa: document.getElementById('inputRasioGuru'),
                siswa_per_sekolah: document.getElementById('inputSiswaPerSekolah'),
                dropout_rate: document.getElementById('inputDropout'),
                akses_internet: document.getElementById('inputAksesInternet'),
                guru_s1: document.getElementById('inputGuruS1'),
                sekolah_lab: document.getElementById('inputSekolahLab'),
                persebaran_sekolah: document.getElementById('inputPersebaran'),
                akses_sekolah: document.getElementById('inputAksesSekolah')
            };

            const sliders = {
                rls: document.getElementById('sliderRLS'),
                aps: document.getElementById('sliderAPS'),
                apk: document.getElementById('sliderAPK'),
                ruang_kelas_layak: document.getElementById('sliderRuangKelas'),
                rasio_guru_siswa: document.getElementById('sliderRasioGuru'),
                siswa_per_sekolah: document.getElementById('sliderSiswaPerSekolah'),
                dropout_rate: document.getElementById('sliderDropout'),
                akses_internet: document.getElementById('sliderAksesInternet'),
                guru_s1: document.getElementById('sliderGuruS1'),
                sekolah_lab: document.getElementById('sliderSekolahLab'),
                persebaran_sekolah: document.getElementById('sliderPersebaran'),
                akses_sekolah: document.getElementById('sliderAksesSekolah')
            };

            // Sync input and slider
            function syncInputSlider(inputId) {
                inputs[inputId].addEventListener('input', function() {
                    sliders[inputId].value = this.value;
                    scheduleSimulation();
                });

                sliders[inputId].addEventListener('input', function() {
                    inputs[inputId].value = this.value;
                    scheduleSimulation();
                });
            }

            Object.keys(inputs).forEach(key => syncInputSlider(key));

            regionSelect.addEventListener('change', function() {
                currentRegion = this.value;
                if (currentRegion) loadData();
            });

            resetBtn.addEventListener('click', function() {
                regionSelect.value = '';
                simulationContent.classList.add('hidden');
                currentRegion = null;
                baselineEqi = null;
            });

            async function loadData() {
                // Fetch data asli dari database
                const res = await fetch(`${apiEndpoints.kabupatenData}?kabupaten=${encodeURIComponent(currentRegion)}`);
                const json = await res.json();

                if (!json.success) {
                    alert('Data kabupaten tidak ditemukan.');
                    return;
                }

                const data = json.data;
                originalData = { ...data };

                // Populate inputs dengan data asli dari DB
                inputs.rls.value              = data.rata_lama_sekolah   ?? 0;
                sliders.rls.value             = data.rata_lama_sekolah   ?? 0;
                inputs.aps.value              = data.aps                 ?? 0;
                sliders.aps.value             = data.aps                 ?? 0;
                inputs.apk.value              = data.apk                 ?? 0;
                sliders.apk.value             = data.apk                 ?? 0;
                inputs.ruang_kelas_layak.value = data.ruang_kelas_layak  ?? 0;
                sliders.ruang_kelas_layak.value= data.ruang_kelas_layak  ?? 0;
                inputs.rasio_guru_siswa.value  = data.rasio_guru_siswa   ?? 0;
                sliders.rasio_guru_siswa.value = data.rasio_guru_siswa   ?? 0;
                inputs.siswa_per_sekolah.value = data.siswa_per_sekolah  ?? 0;
                sliders.siswa_per_sekolah.value= data.siswa_per_sekolah  ?? 0;
                inputs.dropout_rate.value      = data.dropout_rate       ?? 0;
                sliders.dropout_rate.value     = data.dropout_rate       ?? 0;
                inputs.akses_internet.value    = data.akses_internet     ?? 0;
                sliders.akses_internet.value   = data.akses_internet     ?? 0;
                inputs.guru_s1.value           = data.guru_s1            ?? 0;
                sliders.guru_s1.value          = data.guru_s1            ?? 0;
                inputs.sekolah_lab.value       = data.sekolah_lab        ?? 0;
                sliders.sekolah_lab.value      = data.sekolah_lab        ?? 0;
                inputs.persebaran_sekolah.value= data.persebaran_sekolah ?? 0;
                sliders.persebaran_sekolah.value=data.persebaran_sekolah ?? 0;
                inputs.akses_sekolah.value     = data.akses_sekolah      ?? 0;
                sliders.akses_sekolah.value    = data.akses_sekolah      ?? 0;

                simulationContent.classList.remove('hidden');
                baselineEqi = null;
                runSimulation(true);
            }

            function scheduleSimulation() {
                if (!currentRegion) {
                    return;
                }
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => runSimulation(false), 350);
            }

            function buildApiPayload() {
                return {
                    aps: parseFloat(inputs.aps.value),
                    apk: parseFloat(inputs.apk.value),
                    ruang_kelas_layak: parseFloat(inputs.ruang_kelas_layak.value),
                    rata_lama_sekolah: parseFloat(inputs.rls.value),
                    rasio_guru_siswa: parseFloat(inputs.rasio_guru_siswa.value),
                    siswa_per_sekolah: parseFloat(inputs.siswa_per_sekolah.value),
                    dropout_rate: parseFloat(inputs.dropout_rate.value),
                    akses_internet: parseFloat(inputs.akses_internet.value),
                    guru_s1: parseFloat(inputs.guru_s1.value),
                    sekolah_lab: parseFloat(inputs.sekolah_lab.value),
                    persebaran_sekolah: parseFloat(inputs.persebaran_sekolah.value),
                    akses_sekolah: parseFloat(inputs.akses_sekolah.value)
                };
            }

            async function runSimulation(isBaseline) {
                const currentData = buildApiPayload();

                const result = await postJson(apiEndpoints.hitungEqi, {
                    kabupaten_kota: currentRegion,
                    ...currentData
                });

                if (!result || !result.success) {
                    return;
                }

                const stored = result.data || {};
                const newEQI = stored.eqi_score ?? 0;

                if (isBaseline || baselineEqi === null) {
                    baselineEqi = newEQI;
                    document.getElementById('originalEQI').textContent = newEQI.toFixed(1);
                }

                const difference = newEQI - baselineEqi;
                const differencePercent = baselineEqi === 0 ? 0 : (difference / baselineEqi) * 100;

                // Update EQI display
                document.getElementById('currentEQI').textContent = newEQI.toFixed(1);
                document.getElementById('eqiBar').style.width = newEQI + '%';

                // Update difference
                document.getElementById('eqiDifference').innerHTML = `<span>${difference.toFixed(1)}</span><span class="text-lg text-slate-500">/100</span>`;
                document.getElementById('eqiDifferencePercent').textContent = (differencePercent >= 0 ? '+' : '') + differencePercent.toFixed(1) + '%';

                if (difference >= 0) {
                    document.getElementById('eqiDifference').classList.remove('text-red-600');
                    document.getElementById('eqiDifference').classList.add('text-emerald-600');
                    document.getElementById('eqiDifferencePercent').classList.remove('text-red-600');
                    document.getElementById('eqiDifferencePercent').classList.add('text-emerald-600');
                } else {
                    document.getElementById('eqiDifference').classList.remove('text-emerald-600');
                    document.getElementById('eqiDifference').classList.add('text-red-600');
                    document.getElementById('eqiDifferencePercent').classList.remove('text-emerald-600');
                    document.getElementById('eqiDifferencePercent').classList.add('text-red-600');
                }

                // Update quality rank
                document.getElementById('qualityRank').textContent = stored.kategori || '-';
                document.getElementById('qualityBar').style.backgroundColor = stored.warna || '#1E3A8A';
                document.getElementById('qualityBar').style.width = newEQI + '%';
            }
        </script>
    </body>
</html>
