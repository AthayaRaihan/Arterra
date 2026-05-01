<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

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
                                                <span class="text-sm font-medium text-slate-700">Angka Partisipasi Sekolah (APS)</span>
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
                                                <span class="text-sm font-medium text-slate-700">Angka Partisipasi Kasar (APK)</span>
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
                                                <span class="text-sm font-medium text-slate-700">Akses Internet</span>
                                                <span class="text-sm font-bold text-slate-700"><span id="compAkses">0</span>% → <span id="compAksesNew">0</span>%</span>
                                            </div>
                                            <div class="flex gap-2">
                                                <div class="flex-1 h-2 bg-slate-200 rounded-full overflow-hidden">
                                                    <div id="compBarAkses" class="h-full bg-slate-500 rounded-full" style="width: 0%"></div>
                                                </div>
                                                <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                                    <div id="compBarAksesNew" class="h-full bg-emerald-500 rounded-full" style="width: 0%"></div>
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
            const apiEndpoints = {
                hitungEqi: "{{ route('simulation.hitung-eqi') }}",
                sensitivity: "{{ route('simulation.sensitivity') }}"
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

            // Dummy data for each region and year
            const regionData = {
                'Cilacap': { '2021': { aps: 82, apk: 88, ruang_kelas_layak: 71, rata_lama_sekolah: 7.2, rasio_guru_siswa: 18, siswa_per_sekolah: 420, dropout_rate: 3.2, akses_internet: 76, guru_s1: 64, sekolah_lab: 55, persebaran_sekolah: 68, akses_sekolah: 72 }, '2022': { aps: 83, apk: 89, ruang_kelas_layak: 73, rata_lama_sekolah: 7.3, rasio_guru_siswa: 17.5, siswa_per_sekolah: 415, dropout_rate: 3.0, akses_internet: 78, guru_s1: 66, sekolah_lab: 56, persebaran_sekolah: 69, akses_sekolah: 73 }, '2023': { aps: 84, apk: 90, ruang_kelas_layak: 74, rata_lama_sekolah: 7.4, rasio_guru_siswa: 17, siswa_per_sekolah: 410, dropout_rate: 2.8, akses_internet: 80, guru_s1: 68, sekolah_lab: 58, persebaran_sekolah: 70, akses_sekolah: 74 }, '2024': { aps: 85, apk: 91, ruang_kelas_layak: 76, rata_lama_sekolah: 7.5, rasio_guru_siswa: 16.5, siswa_per_sekolah: 405, dropout_rate: 2.6, akses_internet: 82, guru_s1: 70, sekolah_lab: 60, persebaran_sekolah: 72, akses_sekolah: 75 } },
                'Banyumas': { '2021': { aps: 78, apk: 84, ruang_kelas_layak: 66, rata_lama_sekolah: 6.8, rasio_guru_siswa: 20, siswa_per_sekolah: 460, dropout_rate: 3.8, akses_internet: 70, guru_s1: 60, sekolah_lab: 48, persebaran_sekolah: 64, akses_sekolah: 68 }, '2022': { aps: 79, apk: 85, ruang_kelas_layak: 67, rata_lama_sekolah: 6.9, rasio_guru_siswa: 19.5, siswa_per_sekolah: 450, dropout_rate: 3.6, akses_internet: 71, guru_s1: 61, sekolah_lab: 49, persebaran_sekolah: 65, akses_sekolah: 69 }, '2023': { aps: 80, apk: 86, ruang_kelas_layak: 68, rata_lama_sekolah: 7.0, rasio_guru_siswa: 19, siswa_per_sekolah: 445, dropout_rate: 3.4, akses_internet: 72, guru_s1: 62, sekolah_lab: 51, persebaran_sekolah: 66, akses_sekolah: 70 }, '2024': { aps: 81, apk: 87, ruang_kelas_layak: 70, rata_lama_sekolah: 7.1, rasio_guru_siswa: 18.5, siswa_per_sekolah: 440, dropout_rate: 3.2, akses_internet: 74, guru_s1: 64, sekolah_lab: 52, persebaran_sekolah: 67, akses_sekolah: 71 } },
                'Kota Semarang': { '2021': { aps: 90, apk: 96, ruang_kelas_layak: 82, rata_lama_sekolah: 8.2, rasio_guru_siswa: 15, siswa_per_sekolah: 380, dropout_rate: 2.1, akses_internet: 88, guru_s1: 78, sekolah_lab: 72, persebaran_sekolah: 79, akses_sekolah: 84 }, '2022': { aps: 91, apk: 97, ruang_kelas_layak: 83, rata_lama_sekolah: 8.3, rasio_guru_siswa: 14.5, siswa_per_sekolah: 375, dropout_rate: 2.0, akses_internet: 89, guru_s1: 79, sekolah_lab: 74, persebaran_sekolah: 80, akses_sekolah: 85 }, '2023': { aps: 92, apk: 98, ruang_kelas_layak: 84, rata_lama_sekolah: 8.4, rasio_guru_siswa: 14, siswa_per_sekolah: 370, dropout_rate: 1.9, akses_internet: 90, guru_s1: 80, sekolah_lab: 75, persebaran_sekolah: 81, akses_sekolah: 86 }, '2024': { aps: 93, apk: 99, ruang_kelas_layak: 85, rata_lama_sekolah: 8.5, rasio_guru_siswa: 13.5, siswa_per_sekolah: 365, dropout_rate: 1.8, akses_internet: 91, guru_s1: 82, sekolah_lab: 76, persebaran_sekolah: 82, akses_sekolah: 87 } }
            };

            // Fill with default data for all regions
            for (let region in regionData) {
                if (!regionData[region]) regionData[region] = {};
            }

            let currentRegion = null;
            let currentYear = null;
            let originalData = null;
            let baselineEqi = null;
            let debounceTimer = null;

            const regionSelect = document.getElementById('regionSelect');
            const yearSelect = document.getElementById('yearSelect');
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
                baselineEqi = null;
            });

            function loadData() {
                // Get data for region and year (or generate if not exists)
                let data = regionData[currentRegion]?.[currentYear] || generateDefaultData();
                originalData = JSON.parse(JSON.stringify(data));

                // Populate inputs
                inputs.rls.value = data.rata_lama_sekolah;
                sliders.rls.value = data.rata_lama_sekolah;
                inputs.aps.value = data.aps;
                sliders.aps.value = data.aps;
                inputs.apk.value = data.apk;
                sliders.apk.value = data.apk;
                inputs.ruang_kelas_layak.value = data.ruang_kelas_layak;
                sliders.ruang_kelas_layak.value = data.ruang_kelas_layak;
                inputs.rasio_guru_siswa.value = data.rasio_guru_siswa;
                sliders.rasio_guru_siswa.value = data.rasio_guru_siswa;
                inputs.siswa_per_sekolah.value = data.siswa_per_sekolah;
                sliders.siswa_per_sekolah.value = data.siswa_per_sekolah;
                inputs.dropout_rate.value = data.dropout_rate;
                sliders.dropout_rate.value = data.dropout_rate;
                inputs.akses_internet.value = data.akses_internet;
                sliders.akses_internet.value = data.akses_internet;
                inputs.guru_s1.value = data.guru_s1;
                sliders.guru_s1.value = data.guru_s1;
                inputs.sekolah_lab.value = data.sekolah_lab;
                sliders.sekolah_lab.value = data.sekolah_lab;
                inputs.persebaran_sekolah.value = data.persebaran_sekolah;
                sliders.persebaran_sekolah.value = data.persebaran_sekolah;
                inputs.akses_sekolah.value = data.akses_sekolah;
                sliders.akses_sekolah.value = data.akses_sekolah;

                document.getElementById('selectedYear').textContent = currentYear;

                simulationContent.classList.remove('hidden');
                baselineEqi = null;
                runSimulation(true);
            }

            function generateDefaultData() {
                return {
                    aps: 80,
                    apk: 86,
                    ruang_kelas_layak: 70,
                    rata_lama_sekolah: 7.2,
                    rasio_guru_siswa: 18,
                    siswa_per_sekolah: 430,
                    dropout_rate: 3.0,
                    akses_internet: 74,
                    guru_s1: 62,
                    sekolah_lab: 50,
                    persebaran_sekolah: 66,
                    akses_sekolah: 70
                };
            }
            function scheduleSimulation() {
                if (!currentRegion || !currentYear) {
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

            function buildSensitivityPayload(currentData) {
                return {
                    'aps': currentData.aps,
                    'apk': currentData.apk,
                    'ruang_kelas_layak_(%)': currentData.ruang_kelas_layak,
                    'rata"_lama_sekolah_(tahun)': currentData.rata_lama_sekolah,
                    'rasio_guru_siswa': currentData.rasio_guru_siswa,
                    'siswa_per_sekolah': currentData.siswa_per_sekolah,
                    'dropout_rate': currentData.dropout_rate,
                    'akses_internet(%)': currentData.akses_internet,
                    'guru_s1(%)': currentData.guru_s1,
                    'sekolah_lab(%)': currentData.sekolah_lab,
                    'persebaran_sekolah': currentData.persebaran_sekolah,
                    'akses_sekolah': currentData.akses_sekolah
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

                const sensitivity = await postJson(apiEndpoints.sensitivity, {
                    data_kabupaten: buildSensitivityPayload(currentData),
                    perubahan: 5
                });

                if (sensitivity && sensitivity.success && sensitivity.data && Array.isArray(sensitivity.data.hasil)) {
                    const colors = ['#10b981', '#f59e0b', '#ef4444'];
                    const maxDelta = Math.max(...sensitivity.data.hasil.map(item => Math.abs(item.delta_eqi || 0)), 1);
                    const topThree = sensitivity.data.hasil.slice(0, 3);
                    for (let i = 0; i < 3; i++) {
                        const item = topThree[i];
                        if (!item) {
                            continue;
                        }
                        const percentage = (Math.abs(item.delta_eqi || 0) / maxDelta) * 100;
                        document.getElementById(`factor${i + 1}Name`).textContent = item.label || item.fitur || '-';
                        document.getElementById(`factor${i + 1}Value`).textContent = percentage.toFixed(0) + '%';
                        document.getElementById(`factor${i + 1}Bar`).style.width = percentage + '%';
                        document.getElementById(`factor${i + 1}Bar`).style.backgroundColor = colors[i];
                    }
                }

                // Update comparison chart
                document.getElementById('compRLS').textContent = originalData.rata_lama_sekolah;
                document.getElementById('compRLSNew').textContent = currentData.rata_lama_sekolah.toFixed(1);
                document.getElementById('compBarRLS').style.width = (originalData.rata_lama_sekolah / 20) * 100 + '%';
                document.getElementById('compBarRLSNew').style.width = (currentData.rata_lama_sekolah / 20) * 100 + '%';

                document.getElementById('compAPS').textContent = originalData.aps.toFixed(0);
                document.getElementById('compAPSNew').textContent = currentData.aps.toFixed(1);
                document.getElementById('compBarAPS').style.width = originalData.aps + '%';
                document.getElementById('compBarAPSNew').style.width = currentData.aps + '%';

                document.getElementById('compAPK').textContent = originalData.apk.toFixed(0);
                document.getElementById('compAPKNew').textContent = currentData.apk.toFixed(1);
                document.getElementById('compBarAPK').style.width = Math.min(100, originalData.apk) + '%';
                document.getElementById('compBarAPKNew').style.width = Math.min(100, currentData.apk) + '%';

                document.getElementById('compAkses').textContent = originalData.akses_internet.toFixed(0);
                document.getElementById('compAksesNew').textContent = currentData.akses_internet.toFixed(1);
                document.getElementById('compBarAkses').style.width = originalData.akses_internet + '%';
                document.getElementById('compBarAksesNew').style.width = currentData.akses_internet + '%';
            }
        </script>
    </body>
</html>
