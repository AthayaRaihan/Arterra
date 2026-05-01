<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }} - Simulation</title>

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
                                                <option value="Cilacap">Kab. Cilacap</option>
                                                <option value="Banyumas">Kab. Banyumas</option>
                                                <option value="Purbalingga">Kab. Purbalingga</option>
                                                <option value="Banjarnegara">Kab. Banjarnegara</option>
                                                <option value="Kebumen">Kab. Kebumen</option>
                                                <option value="Purworejo">Kab. Purworejo</option>
                                                <option value="Wonosobo">Kab. Wonosobo</option>
                                                <option value="Magelang">Kab. Magelang</option>
                                                <option value="Boyolali">Kab. Boyolali</option>
                                                <option value="Klaten">Kab. Klaten</option>
                                                <option value="Sukoharjo">Kab. Sukoharjo</option>
                                                <option value="Wonogiri">Kab. Wonogiri</option>
                                                <option value="Karanganyar">Kab. Karanganyar</option>
                                                <option value="Sragen">Kab. Sragen</option>
                                                <option value="Grobogan">Kab. Grobogan</option>
                                                <option value="Blora">Kab. Blora</option>
                                                <option value="Rembang">Kab. Rembang</option>
                                                <option value="Pati">Kab. Pati</option>
                                                <option value="Kudus">Kab. Kudus</option>
                                                <option value="Jepara">Kab. Jepara</option>
                                                <option value="Demak">Kab. Demak</option>
                                                <option value="Semarang">Kab. Semarang</option>
                                                <option value="Temanggung">Kab. Temanggung</option>
                                                <option value="Kendal">Kab. Kendal</option>
                                                <option value="Batang">Kab. Batang</option>
                                                <option value="Pekalongan">Kab. Pekalongan</option>
                                                <option value="Pemalang">Kab. Pemalang</option>
                                                <option value="Tegal">Kab. Tegal</option>
                                                <option value="Brebes">Kab. Brebes</option>
                                                <option value="Kota Magelang">Kota Magelang</option>
                                                <option value="Kota Surakarta">Kota Surakarta</option>
                                                <option value="Kota Salatiga">Kota Salatiga</option>
                                                <option value="Kota Semarang">Kota Semarang</option>
                                                <option value="Kota Pekalongan">Kota Pekalongan</option>
                                                <option value="Kota Tegal">Kota Tegal</option>
                                            </select>
                                            <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Year Select -->
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Data</label>
                                        <div class="relative">
                                            <select id="yearSelect" class="w-full appearance-none rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20">
                                                <option value="" selected disabled>Pilih tahun...</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
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
                                            <input type="number" id="inputRLS" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="15" step="0.1">
                                            <span class="text-sm text-slate-500">tahun</span>
                                        </div>
                                        <input type="range" id="sliderRLS" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="15" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 15 tahun</p>
                                    </div>

                                    <!-- APS SD -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">APS SD/Sederajat</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputAPSSD" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">%</span>
                                        </div>
                                        <input type="range" id="sliderAPSSD" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100%</p>
                                    </div>

                                    <!-- APS SMP -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">APS SMP/Sederajat</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputAPSSMP" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">%</span>
                                        </div>
                                        <input type="range" id="sliderAPSSMP" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100%</p>
                                    </div>

                                    <!-- APS SMA -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">APS SMA/Sederajat</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputAPSSMA" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">%</span>
                                        </div>
                                        <input type="range" id="sliderAPSSMA" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100%</p>
                                    </div>

                                    <!-- APK SD -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">APK SD/Sederajat</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputAPKSD" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">%</span>
                                        </div>
                                        <input type="range" id="sliderAPKSD" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100%</p>
                                    </div>

                                    <!-- APK SMP -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">APK SMP/Sederajat</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputAPKSMP" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">%</span>
                                        </div>
                                        <input type="range" id="sliderAPKSMP" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100%</p>
                                    </div>

                                    <!-- APK SMA -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">APK SMA/Sederajat</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputAPKSMA" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">%</span>
                                        </div>
                                        <input type="range" id="sliderAPKSMA" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100%</p>
                                    </div>

                                    <!-- Literacy Rate -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Tingkat Literasi</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputLiteracy" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">%</span>
                                        </div>
                                        <input type="range" id="sliderLiteracy" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100%</p>
                                    </div>

                                    <!-- Teacher Ratio -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Rasio Murid/Guru</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputTeacherRatio" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="5" max="50" step="0.1">
                                            <span class="text-sm text-slate-500">murid</span>
                                        </div>
                                        <input type="range" id="sliderTeacherRatio" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="5" max="50" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 5 - 50 murid/guru</p>
                                    </div>

                                    <!-- Pass Rate -->
                                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Tingkat Kelulusan</label>
                                        <div class="flex items-baseline gap-2 mb-4">
                                            <input type="number" id="inputPassRate" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-2xl font-bold text-[#1F2937] focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20" min="0" max="100" step="0.1">
                                            <span class="text-sm text-slate-500">%</span>
                                        </div>
                                        <input type="range" id="sliderPassRate" class="w-full h-2 bg-slate-100 rounded-full appearance-none cursor-pointer" min="0" max="100" step="0.1">
                                        <p class="mt-2 text-xs text-slate-500">Rentang: 0 - 100%</p>
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

                            <!-- Factor Ranking Section -->
                            <section class="mt-8">
                                <h2 class="text-lg font-semibold text-[#1F2937] mb-4">Peringkat Faktor Pengaruh terhadap EQI</h2>
                                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                    <div class="space-y-4">
                                        <div class="flex items-center justify-between gap-4">
                                            <div class="flex items-center gap-3 flex-1">
                                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-[#1E3A8A] text-white text-xs font-bold">1</div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-semibold text-slate-700" id="factor1Name">-</p>
                                                    <p class="text-xs text-slate-500">Pengaruh relatif</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-32 h-2 bg-slate-100 rounded-full overflow-hidden">
                                                        <div id="factor1Bar" class="h-full bg-emerald-500 rounded-full" style="width: 100%"></div>
                                                    </div>
                                                    <span class="text-sm font-bold text-slate-700 w-10 text-right" id="factor1Value">0%</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between gap-4">
                                            <div class="flex items-center gap-3 flex-1">
                                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-[#1E3A8A] text-white text-xs font-bold">2</div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-semibold text-slate-700" id="factor2Name">-</p>
                                                    <p class="text-xs text-slate-500">Pengaruh relatif</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-32 h-2 bg-slate-100 rounded-full overflow-hidden">
                                                        <div id="factor2Bar" class="h-full bg-amber-500 rounded-full" style="width: 100%"></div>
                                                    </div>
                                                    <span class="text-sm font-bold text-slate-700 w-10 text-right" id="factor2Value">0%</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between gap-4">
                                            <div class="flex items-center gap-3 flex-1">
                                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-[#1E3A8A] text-white text-xs font-bold">3</div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-semibold text-slate-700" id="factor3Name">-</p>
                                                    <p class="text-xs text-slate-500">Pengaruh relatif</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-32 h-2 bg-slate-100 rounded-full overflow-hidden">
                                                        <div id="factor3Bar" class="h-full bg-red-500 rounded-full" style="width: 100%"></div>
                                                    </div>
                                                    <span class="text-sm font-bold text-slate-700 w-10 text-right" id="factor3Value">0%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Comparison Chart -->
                            <section class="mt-8 mb-8">
                                <h2 class="text-lg font-semibold text-[#1F2937] mb-4">Perbandingan Data Asli vs Simulasi</h2>
                                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                                    <div class="space-y-6">
                                        <div>
                                            <div class="flex justify-between mb-2">
                                                <span class="text-sm font-medium text-slate-700">Rata-rata Lama Sekolah</span>
                                                <span class="text-sm font-bold text-slate-700"><span id="compRLS">0</span> → <span id="compRLSNew">0</span> tahun</span>
                                            </div>
                                            <div class="flex gap-2">
                                                <div class="flex-1 h-2 bg-slate-200 rounded-full overflow-hidden">
                                                    <div id="compBarRLS" class="h-full bg-slate-500 rounded-full" style="width: 0%"></div>
                                                </div>
                                                <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                                    <div id="compBarRLSNew" class="h-full bg-emerald-500 rounded-full" style="width: 0%"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="flex justify-between mb-2">
                                                <span class="text-sm font-medium text-slate-700">Rata-rata APS</span>
                                                <span class="text-sm font-bold text-slate-700"><span id="compAPS">0</span>% → <span id="compAPSNew">0</span>%</span>
                                            </div>
                                            <div class="flex gap-2">
                                                <div class="flex-1 h-2 bg-slate-200 rounded-full overflow-hidden">
                                                    <div id="compBarAPS" class="h-full bg-slate-500 rounded-full" style="width: 0%"></div>
                                                </div>
                                                <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                                    <div id="compBarAPSNew" class="h-full bg-emerald-500 rounded-full" style="width: 0%"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="flex justify-between mb-2">
                                                <span class="text-sm font-medium text-slate-700">Rata-rata APK</span>
                                                <span class="text-sm font-bold text-slate-700"><span id="compAPK">0</span>% → <span id="compAPKNew">0</span>%</span>
                                            </div>
                                            <div class="flex gap-2">
                                                <div class="flex-1 h-2 bg-slate-200 rounded-full overflow-hidden">
                                                    <div id="compBarAPK" class="h-full bg-slate-500 rounded-full" style="width: 0%"></div>
                                                </div>
                                                <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                                    <div id="compBarAPKNew" class="h-full bg-emerald-500 rounded-full" style="width: 0%"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="flex justify-between mb-2">
                                                <span class="text-sm font-medium text-slate-700">Tingkat Literasi</span>
                                                <span class="text-sm font-bold text-slate-700"><span id="compLiteracy">0</span>% → <span id="compLiteracyNew">0</span>%</span>
                                            </div>
                                            <div class="flex gap-2">
                                                <div class="flex-1 h-2 bg-slate-200 rounded-full overflow-hidden">
                                                    <div id="compBarLiteracy" class="h-full bg-slate-500 rounded-full" style="width: 0%"></div>
                                                </div>
                                                <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                                    <div id="compBarLiteracyNew" class="h-full bg-emerald-500 rounded-full" style="width: 0%"></div>
                                                </div>
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
            // Dummy data for each region and year
            const regionData = {
                'Cilacap': { '2021': { rls: 7.2, apsSD: 95, apsSMP: 82, apsSMA: 65, apkSD: 105, apkSMP: 88, apkSMA: 67, literacy: 85, teacherRatio: 18, passRate: 88, eqi: 72 }, '2022': { rls: 7.3, apsSD: 96, apsSMP: 83, apsSMA: 66, apkSD: 106, apkSMP: 89, apkSMA: 68, literacy: 86, teacherRatio: 17.5, passRate: 89, eqi: 74 }, '2023': { rls: 7.4, apsSD: 97, apsSMP: 84, apsSMA: 67, apkSD: 107, apkSMP: 90, apkSMA: 69, literacy: 87, teacherRatio: 17, passRate: 90, eqi: 76 }, '2024': { rls: 7.5, apsSD: 98, apsSMP: 85, apsSMA: 68, apkSD: 108, apkSMP: 91, apkSMA: 70, literacy: 88, teacherRatio: 16.5, passRate: 91, eqi: 78 } },
                'Banyumas': { '2021': { rls: 6.8, apsSD: 92, apsSMP: 78, apsSMA: 60, apkSD: 100, apkSMP: 85, apkSMA: 65, literacy: 82, teacherRatio: 20, passRate: 85, eqi: 68 }, '2022': { rls: 6.9, apsSD: 93, apsSMP: 79, apsSMA: 61, apkSD: 102, apkSMP: 86, apkSMA: 66, literacy: 83, teacherRatio: 19.5, passRate: 86, eqi: 70 }, '2023': { rls: 7.0, apsSD: 94, apsSMP: 80, apsSMA: 62, apkSD: 103, apkSMP: 87, apkSMA: 67, literacy: 84, teacherRatio: 19, passRate: 87, eqi: 72 }, '2024': { rls: 7.1, apsSD: 95, apsSMP: 81, apsSMA: 63, apkSD: 104, apkSMP: 88, apkSMA: 68, literacy: 85, teacherRatio: 18.5, passRate: 88, eqi: 74 } },
                'Kota Semarang': { '2021': { rls: 8.2, apsSD: 98, apsSMP: 90, apsSMA: 78, apkSD: 110, apkSMP: 95, apkSMA: 80, literacy: 92, teacherRatio: 15, passRate: 94, eqi: 85 }, '2022': { rls: 8.3, apsSD: 99, apsSMP: 91, apsSMA: 79, apkSD: 111, apkSMP: 96, apkSMA: 81, literacy: 93, teacherRatio: 14.5, passRate: 95, eqi: 87 }, '2023': { rls: 8.4, apsSD: 100, apsSMP: 92, apsSMA: 80, apkSD: 112, apkSMP: 97, apkSMA: 82, literacy: 94, teacherRatio: 14, passRate: 96, eqi: 89 }, '2024': { rls: 8.5, apsSD: 101, apsSMP: 93, apsSMA: 81, apkSD: 113, apkSMP: 98, apkSMA: 83, literacy: 95, teacherRatio: 13.5, passRate: 97, eqi: 91 } }
            };

            // Fill with default data for all regions
            for (let region in regionData) {
                if (!regionData[region]) regionData[region] = {};
            }

            let currentRegion = null;
            let currentYear = null;
            let originalData = null;

            const regionSelect = document.getElementById('regionSelect');
            const yearSelect = document.getElementById('yearSelect');
            const simulationContent = document.getElementById('simulationContent');
            const resetBtn = document.getElementById('resetBtn');

            // Input elements
            const inputs = {
                rls: document.getElementById('inputRLS'),
                apsSD: document.getElementById('inputAPSSD'),
                apsSMP: document.getElementById('inputAPSSMP'),
                apsSMA: document.getElementById('inputAPSSMA'),
                apkSD: document.getElementById('inputAPKSD'),
                apkSMP: document.getElementById('inputAPKSMP'),
                apkSMA: document.getElementById('inputAPKSMA'),
                literacy: document.getElementById('inputLiteracy'),
                teacherRatio: document.getElementById('inputTeacherRatio'),
                passRate: document.getElementById('inputPassRate')
            };

            const sliders = {
                rls: document.getElementById('sliderRLS'),
                apsSD: document.getElementById('sliderAPSSD'),
                apsSMP: document.getElementById('sliderAPSSMP'),
                apsSMA: document.getElementById('sliderAPSSMA'),
                apkSD: document.getElementById('sliderAPKSD'),
                apkSMP: document.getElementById('sliderAPKSMP'),
                apkSMA: document.getElementById('sliderAPKSMA'),
                literacy: document.getElementById('sliderLiteracy'),
                teacherRatio: document.getElementById('sliderTeacherRatio'),
                passRate: document.getElementById('sliderPassRate')
            };

            // Sync input and slider
            function syncInputSlider(inputId, sliderId) {
                inputs[inputId].addEventListener('input', function() {
                    sliders[inputId].value = this.value;
                    updateResults();
                });

                sliders[inputId].addEventListener('input', function() {
                    inputs[inputId].value = this.value;
                    updateResults();
                });
            }

            Object.keys(inputs).forEach(key => syncInputSlider(key, key));

            regionSelect.addEventListener('change', function() {
                currentRegion = this.value;
                if (currentRegion && currentYear) loadData();
            });

            yearSelect.addEventListener('change', function() {
                currentYear = this.value;
                if (currentRegion && currentYear) loadData();
            });

            resetBtn.addEventListener('click', function() {
                regionSelect.value = '';
                yearSelect.value = '';
                simulationContent.classList.add('hidden');
                currentRegion = null;
                currentYear = null;
            });

            function loadData() {
                // Get data for region and year (or generate if not exists)
                let data = regionData[currentRegion]?.[currentYear] || generateDefaultData();
                originalData = JSON.parse(JSON.stringify(data));

                // Populate inputs
                inputs.rls.value = data.rls;
                sliders.rls.value = data.rls;
                inputs.apsSD.value = data.apsSD;
                sliders.apsSD.value = data.apsSD;
                inputs.apsSMP.value = data.apsSMP;
                sliders.apsSMP.value = data.apsSMP;
                inputs.apsSMA.value = data.apsSMA;
                sliders.apsSMA.value = data.apsSMA;
                inputs.apkSD.value = data.apkSD;
                sliders.apkSD.value = data.apkSD;
                inputs.apkSMP.value = data.apkSMP;
                sliders.apkSMP.value = data.apkSMP;
                inputs.apkSMA.value = data.apkSMA;
                sliders.apkSMA.value = data.apkSMA;
                inputs.literacy.value = data.literacy;
                sliders.literacy.value = data.literacy;
                inputs.teacherRatio.value = data.teacherRatio;
                sliders.teacherRatio.value = data.teacherRatio;
                inputs.passRate.value = data.passRate;
                sliders.passRate.value = data.passRate;

                document.getElementById('selectedYear').textContent = currentYear;
                document.getElementById('originalEQI').textContent = data.eqi;

                simulationContent.classList.remove('hidden');
                updateResults();
            }

            function generateDefaultData() {
                return {
                    rls: 7.2,
                    apsSD: 95,
                    apsSMP: 82,
                    apsSMA: 65,
                    apkSD: 105,
                    apkSMP: 88,
                    apkSMA: 67,
                    literacy: 85,
                    teacherRatio: 18,
                    passRate: 88,
                    eqi: 72
                };
            }

            function calculateEQI(data) {
                // Normalized weights for each factor
                const weights = {
                    rls: 0.15,
                    aps: 0.20,
                    apk: 0.20,
                    literacy: 0.15,
                    teacherRatio: 0.10,
                    passRate: 0.20
                };

                // Normalize values to 0-100 scale
                const normalizedRLS = (data.rls / 15) * 100;
                const normalizedAPS = ((data.apsSD + data.apsSMP + data.apsSMA) / 3) / 100 * 100;
                const normalizedAPK = ((data.apkSD + data.apkSMP + data.apkSMA) / 3) / 100 * 100;
                const normalizedLiteracy = data.literacy;
                const normalizedTeacherRatio = ((50 - data.teacherRatio) / 45) * 100; // Lower ratio is better
                const normalizedPassRate = data.passRate;

                // Calculate EQI
                const eqi = (
                    normalizedRLS * weights.rls +
                    normalizedAPS * weights.aps +
                    normalizedAPK * weights.apk +
                    normalizedLiteracy * weights.literacy +
                    normalizedTeacherRatio * weights.teacherRatio +
                    normalizedPassRate * weights.passRate
                ) / 100;

                return Math.min(100, Math.max(0, eqi));
            }

            function getFactorInfluence(data) {
                // Calculate sensitivity of each factor
                const baseEQI = calculateEQI(data);
                const influences = {};

                const testIncrease = 5;

                // Test RLS
                let testData = JSON.parse(JSON.stringify(data));
                testData.rls = Math.min(15, data.rls + testIncrease);
                influences.rls = Math.abs(calculateEQI(testData) - baseEQI);

                // Test APS
                testData = JSON.parse(JSON.stringify(data));
                testData.apsSD = Math.min(100, data.apsSD + testIncrease);
                influences.aps = Math.abs(calculateEQI(testData) - baseEQI);

                // Test APK
                testData = JSON.parse(JSON.stringify(data));
                testData.apkSD = Math.min(100, data.apkSD + testIncrease);
                influences.apk = Math.abs(calculateEQI(testData) - baseEQI);

                // Test Literacy
                testData = JSON.parse(JSON.stringify(data));
                testData.literacy = Math.min(100, data.literacy + testIncrease);
                influences.literacy = Math.abs(calculateEQI(testData) - baseEQI);

                // Test Teacher Ratio
                testData = JSON.parse(JSON.stringify(data));
                testData.teacherRatio = Math.max(5, data.teacherRatio - testIncrease / 10);
                influences.teacherRatio = Math.abs(calculateEQI(testData) - baseEQI);

                // Test Pass Rate
                testData = JSON.parse(JSON.stringify(data));
                testData.passRate = Math.min(100, data.passRate + testIncrease);
                influences.passRate = Math.abs(calculateEQI(testData) - baseEQI);

                return influences;
            }

            function updateResults() {
                const currentData = {
                    rls: parseFloat(inputs.rls.value),
                    apsSD: parseFloat(inputs.apsSD.value),
                    apsSMP: parseFloat(inputs.apsSMP.value),
                    apsSMA: parseFloat(inputs.apsSMA.value),
                    apkSD: parseFloat(inputs.apkSD.value),
                    apkSMP: parseFloat(inputs.apkSMP.value),
                    apkSMA: parseFloat(inputs.apkSMA.value),
                    literacy: parseFloat(inputs.literacy.value),
                    teacherRatio: parseFloat(inputs.teacherRatio.value),
                    passRate: parseFloat(inputs.passRate.value)
                };

                const newEQI = calculateEQI(currentData);
                const originalEQI = originalData.eqi;
                const difference = newEQI - originalEQI;
                const differencePercent = (difference / originalEQI) * 100;

                // Update EQI display
                document.getElementById('currentEQI').textContent = newEQI.toFixed(1);
                document.getElementById('eqiBar').style.width = (newEQI) + '%';

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
                let rank, color;
                if (newEQI >= 80) {
                    rank = 'Sangat Tinggi';
                    color = '#10b981';
                } else if (newEQI >= 60) {
                    rank = 'Tinggi';
                    color = '#34d399';
                } else if (newEQI >= 40) {
                    rank = 'Sedang';
                    color = '#f59e0b';
                } else if (newEQI >= 20) {
                    rank = 'Rendah';
                    color = '#fb923c';
                } else {
                    rank = 'Sangat Rendah';
                    color = '#ef4444';
                }
                document.getElementById('qualityRank').textContent = rank;
                document.getElementById('qualityBar').style.backgroundColor = color;
                document.getElementById('qualityBar').style.width = newEQI + '%';

                // Update factor influence ranking
                const influences = getFactorInfluence(currentData);
                const sorted = Object.entries(influences).sort((a, b) => b[1] - a[1]);

                const factorNames = {
                    'rls': 'Rata-rata Lama Sekolah',
                    'aps': 'Angka Partisipasi Sekolah',
                    'apk': 'Angka Partisipasi Kasar',
                    'literacy': 'Tingkat Literasi',
                    'teacherRatio': 'Rasio Murid/Guru',
                    'passRate': 'Tingkat Kelulusan'
                };

                const colors = ['#10b981', '#f59e0b', '#ef4444'];
                for (let i = 0; i < 3; i++) {
                    if (sorted[i]) {
                        const factor = sorted[i][0];
                        const value = sorted[i][1];
                        const maxValue = Math.max(...Object.values(influences));
                        const percentage = (value / maxValue) * 100;

                        document.getElementById(`factor${i + 1}Name`).textContent = factorNames[factor];
                        document.getElementById(`factor${i + 1}Value`).textContent = percentage.toFixed(0) + '%';
                        document.getElementById(`factor${i + 1}Bar`).style.width = percentage + '%';
                        document.getElementById(`factor${i + 1}Bar`).style.backgroundColor = colors[i];
                    }
                }

                // Update comparison chart
                document.getElementById('compRLS').textContent = originalData.rls;
                document.getElementById('compRLSNew').textContent = currentData.rls.toFixed(1);
                document.getElementById('compBarRLS').style.width = (originalData.rls / 15) * 100 + '%';
                document.getElementById('compBarRLSNew').style.width = (currentData.rls / 15) * 100 + '%';

                const avgAPS = (originalData.apsSD + originalData.apsSMP + originalData.apsSMA) / 3;
                const avgAPSNew = (currentData.apsSD + currentData.apsSMP + currentData.apsSMA) / 3;
                document.getElementById('compAPS').textContent = avgAPS.toFixed(0);
                document.getElementById('compAPSNew').textContent = avgAPSNew.toFixed(1);
                document.getElementById('compBarAPS').style.width = avgAPS + '%';
                document.getElementById('compBarAPSNew').style.width = avgAPSNew + '%';

                const avgAPK = (originalData.apkSD + originalData.apkSMP + originalData.apkSMA) / 3;
                const avgAPKNew = (currentData.apkSD + currentData.apkSMP + currentData.apkSMA) / 3;
                document.getElementById('compAPK').textContent = avgAPK.toFixed(0);
                document.getElementById('compAPKNew').textContent = avgAPKNew.toFixed(1);
                document.getElementById('compBarAPK').style.width = Math.min(100, avgAPK) + '%';
                document.getElementById('compBarAPKNew').style.width = Math.min(100, avgAPKNew) + '%';

                document.getElementById('compLiteracy').textContent = originalData.literacy;
                document.getElementById('compLiteracyNew').textContent = currentData.literacy.toFixed(1);
                document.getElementById('compBarLiteracy').style.width = originalData.literacy + '%';
                document.getElementById('compBarLiteracyNew').style.width = currentData.literacy + '%';
            }
        </script>
    </body>
</html>
