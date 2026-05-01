<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{ config('app.name', 'Laravel') }} - EQI</title>

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
								<p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Jawa Tengah</p>
								<h1 class="mt-2 text-3xl font-semibold">Analisis Education Quality Index (EQI)</h1>
								<p class="mt-2 max-w-2xl text-sm text-slate-600">Analisis tren kualitas pendidikan per kabupaten/kota di Jawa Tengah.</p>
							</div>
							<div class="flex flex-wrap gap-3">
								<button class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-slate-300">Simpan Ringkasan</button>
								<button class="rounded-xl bg-[#1E3A8A] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1C347B]">Unduh Laporan</button>
							</div>
						</header>

						<section class="mt-6 grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
							<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
								<p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Pilih Kabupaten/Kota</p>
								<div class="mt-3 flex flex-wrap items-center gap-4">
									<div class="relative">
										<select id="regionSelect" class="w-56 appearance-none rounded-xl border border-slate-200 bg-white px-4 py-2 pr-10 text-sm font-semibold text-slate-700 shadow-sm transition focus:border-[#1E3A8A] focus:outline-none">
											<option value="Cilacap" selected>Kab. Cilacap</option>
											<option value="Banyumas">Kab. Banyumas</option>
											<option value="Purbalingga">Kab. Purbalingga</option>
											<option value="Semarang">Kab. Banjarnegara</option>
											<option value="Surakarta">Kab. Kebumen</option>
											<option value="Surakarta">Kab. Purworejo</option>
											<option value="Surakarta">Kab. Wonosobo</option>
											<option value="Surakarta">Kab. Magelang</option>
											<option value="Surakarta">Kab. Boyolali</option>
											<option value="Surakarta">Kab. Klaten</option>
											<option value="Surakarta">Kab. Sukoharjo</option>
											<option value="Surakarta">Kab. Wonogiri</option>
											<option value="Surakarta">Kab. Karanganyar</option>
											<option value="Surakarta">Kab. Sragen</option>
											<option value="Surakarta">Kab. Grobogan</option>
											<option value="Surakarta">Kab. Blora</option>
											<option value="Surakarta">Kab. Rembang</option>
											<option value="Surakarta">Kab. Pati</option>
											<option value="Surakarta">Kab. Kudus</option>
											<option value="Surakarta">Kab. Jepara</option>
											<option value="Surakarta">Kab. Demak</option>
											<option value="Surakarta">Kab. Semarang</option>
											<option value="Surakarta">Kab. Temanggung</option>
											<option value="Surakarta">Kab. Kendal</option>
											<option value="Surakarta">Kab. Batang</option>
											<option value="Surakarta">Kab. Pekalongan</option>
											<option value="Surakarta">Kab. Pemalang</option>
											<option value="Surakarta">Kab. Tegal</option>
											<option value="Surakarta">Kab. Brebes</option>
											<option value="Surakarta">Kota Magelang</option>
											<option value="Surakarta">Kota Surakarta</option>
											<option value="Surakarta">Kota Salatiga</option>
											<option value="Surakarta">Kota Semarang</option>
											<option value="Surakarta">Kota Pekalongan</option>
											<option value="Surakarta">Kota Tegal</option>
										</select>
										<span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
											<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
											</svg>
										</span>
									</div>
									<div class="rounded-2xl bg-[#F8FAFC] px-4 py-3">
										<p class="text-xs text-slate-500">Kabupaten terpilih</p>
										<p id="selectedRegion" class="text-lg font-semibold text-[#1E3A8A]">Cilacap</p>
									</div>
								</div>
								<p class="mt-3 text-sm text-slate-500">Pilih wilayah untuk melihat ringkasan EQI, tren lima tahun, dan peta visualisasi.</p>
							</div>

							<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
								<div class="flex items-center justify-between">
									<div>
										<p class="text-xs font-semibold uppercase tracking-wider text-slate-500">EQI Terbaru</p>
										<p id="eqiValue" class="mt-2 text-4xl font-semibold text-[#1F2937]">78.5</p>
										<p class="mt-1 text-sm text-slate-500">Berdasarkan data 5 tahun terakhir</p>
									</div>
									<span id="eqiStatus" class="rounded-full bg-[#4CAF50]/15 px-4 py-1 text-xs font-semibold text-[#2E7D32]">Baik</span>
								</div>
								<div class="mt-4 flex flex-wrap gap-2 text-xs text-slate-500">
									<span class="rounded-full border border-slate-200 px-3 py-1">Tren positif</span>
									<span class="rounded-full border border-slate-200 px-3 py-1">Pemantauan 35 kab/kota</span>
								</div>
							</div>
						</section>

						<section class="mt-6 grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
							<div class="space-y-6">
								<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
									<div class="flex items-center justify-between">
										<div>
											<h2 class="text-lg font-semibold">Tren EQI 5 Tahun Terakhir</h2>
											<p class="mt-1 text-sm text-slate-500">2020 - 2024 (data simulasi)</p>
										</div>
									</div>
									<div class="mt-5 rounded-2xl border border-dashed border-slate-200 bg-gradient-to-b from-slate-50 to-white p-6">
										<svg class="h-80 w-full" viewBox="0 0 820 410" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M40 410H780" stroke="#E2E8F0" stroke-width="2" />
											<path d="M40 00V410" stroke="#E2E8F0" stroke-width="2" />
											<polyline points="80,370 240,320 400,350 560,295 720,340" fill="none" stroke="#60A5FA" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
											<circle cx="80" cy="370" r="6" fill="#1E3A8A" />
											<circle cx="240" cy="320" r="6" fill="#1E3A8A" />
											<circle cx="400" cy="350" r="6" fill="#1E3A8A" />
											<circle cx="560" cy="295" r="6" fill="#1E3A8A" />
											<circle cx="720" cy="340" r="6" fill="#1E3A8A" />
											<text x="70" y="435" font-size="12" fill="#64748B">2020</text>
											<text x="230" y="435" font-size="12" fill="#64748B">2021</text>
											<text x="390" y="435" font-size="12" fill="#64748B">2022</text>
											<text x="550" y="435" font-size="12" fill="#64748B">2023</text>
											<text x="710" y="435" font-size="12" fill="#64748B">2024</text>
										</svg>
										<div class="mt-4 text-xs text-slate-500">EQI: 70, 72, 74, 76, 78</div>
									</div>
								</div>
                                
                                
							</div>

							<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
								<div class="flex items-start justify-between">
									<div>
										<h2 class="text-lg font-semibold">Peta Kabupaten Terpilih</h2>
										<p class="mt-1 text-sm text-slate-500">Highlight wilayah berdasarkan kategori EQI.</p>
									</div>
								</div>
								<div class="mt-4 overflow-hidden rounded-2xl border border-dashed border-slate-200 bg-gradient-to-br from-slate-50 via-white to-slate-100">
									<div class="flex h-72 items-center justify-center">
										<div class="text-center">
											<span id="mapRegion" class="inline-flex items-center justify-center rounded-2xl bg-[#1E3A8A]/10 px-3 py-2 text-sm font-semibold text-[#1E3A8A]">Cilacap</span>
											<p class="mt-2 text-xs text-slate-500">Peta interaktif akan ditampilkan di sini</p>
											<div class="mt-4 flex items-center justify-center gap-4 text-xs text-slate-500">
												<span class="inline-flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#4CAF50]"></span>Hijau = tinggi</span>
												<span class="inline-flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#FACC15]"></span>Kuning = sedang</span>
												<span class="inline-flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EF4444]"></span>Merah = rendah</span>
											</div>
										</div>
									</div>
								</div>
							</div>

						</section>
                        <section class="mt-6">
							<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
								<div class="flex items-center justify-between">
									<div>
										<h2 class="text-lg font-semibold">EQI Pertahun (5 Tahun Terakhir)</h2>
										<p class="mt-1 text-sm text-slate-500">Ringkasan nilai EQI per tahun.</p>
									</div>
							</div>
							<div class="mt-4 overflow-hidden rounded-2xl border border-slate-200">
								<table class="min-w-full text-left text-sm">
									<thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
										<tr>
											<th class="px-4 py-3">Tahun</th>
											<th class="px-4 py-3">EQI</th>
											<th class="px-4 py-3">Status</th>
										</tr>
									</thead>
									<tbody class="divide-y divide-slate-200">
										<tr>
											<td class="px-4 py-3 font-medium">2020</td>
											<td class="px-4 py-3">70.0</td>
											<td class="px-4 py-3"><span class="rounded-full bg-[#FACC15]/30 px-2 py-1 text-xs font-semibold text-[#9A7B00]">Sedang</span></td>
										</tr>
										<tr class="bg-slate-50/60">
											<td class="px-4 py-3 font-medium">2021</td>
											<td class="px-4 py-3">72.0</td>
											<td class="px-4 py-3"><span class="rounded-full bg-[#FACC15]/30 px-2 py-1 text-xs font-semibold text-[#9A7B00]">Sedang</span></td>
										</tr>
										<tr>
											<td class="px-4 py-3 font-medium">2022</td>
											<td class="px-4 py-3">74.0</td>
											<td class="px-4 py-3"><span class="rounded-full bg-[#4CAF50]/15 px-2 py-1 text-xs font-semibold text-[#2E7D32]">Baik</span></td>
										</tr>
										<tr class="bg-slate-50/60">
											<td class="px-4 py-3 font-medium">2023</td>
											<td class="px-4 py-3">76.0</td>
											<td class="px-4 py-3"><span class="rounded-full bg-[#4CAF50]/15 px-2 py-1 text-xs font-semibold text-[#2E7D32]">Baik</span></td>
										</tr>
										<tr>
											<td class="px-4 py-3 font-medium">2024</td>
											<td class="px-4 py-3">78.0</td>
											<td class="px-4 py-3"><span class="rounded-full bg-[#4CAF50]/15 px-2 py-1 text-xs font-semibold text-[#2E7D32]">Baik</span></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</section>
			</main>
		</div>
		
	</body>
</html>
