<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{ config('app.name', 'Laravel') }} - EQI</title>

		<link rel="preconnect" href="https://fonts.bunny.net">
		<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

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
										<select id="regionSelect" class="w-56 appearance-none rounded-xl border border-slate-200 bg-white px-4 py-2 pr-10 text-sm font-semibold text-slate-700 shadow-sm transition focus:border-[#1E3A8A] focus:outline-none relative z-10">
											<option value="Cilacap" data-lat="-7.6402" data-lng="109.0069" selected>Kab. Cilacap</option>
											<option value="Banyumas" data-lat="-7.4646" data-lng="109.0202">Kab. Banyumas</option>
											<option value="Purbalingga" data-lat="-7.3005" data-lng="109.3496">Kab. Purbalingga</option>
											<option value="Banjarnegara" data-lat="-7.3912" data-lng="109.6896">Kab. Banjarnegara</option>
											<option value="Kebumen" data-lat="-7.6698" data-lng="109.6508">Kab. Kebumen</option>
											<option value="Purworejo" data-lat="-7.7027" data-lng="109.9984">Kab. Purworejo</option>
											<option value="Wonosobo" data-lat="-7.3619" data-lng="109.8978">Kab. Wonosobo</option>
											<option value="Magelang" data-lat="-7.5029" data-lng="110.2223">Kab. Magelang</option>
											<option value="Boyolali" data-lat="-7.5186" data-lng="110.6019">Kab. Boyolali</option>
											<option value="Klaten" data-lat="-7.7126" data-lng="110.6053">Kab. Klaten</option>
											<option value="Sukoharjo" data-lat="-7.6826" data-lng="110.8353">Kab. Sukoharjo</option>
											<option value="Wonogiri" data-lat="-7.8821" data-lng="111.0252">Kab. Wonogiri</option>
											<option value="Karanganyar" data-lat="-7.6322" data-lng="111.0264">Kab. Karanganyar</option>
											<option value="Sragen" data-lat="-7.4206" data-lng="110.9892">Kab. Sragen</option>
											<option value="Grobogan" data-lat="-7.0984" data-lng="110.9322">Kab. Grobogan</option>
											<option value="Blora" data-lat="-7.0252" data-lng="111.4552">Kab. Blora</option>
											<option value="Rembang" data-lat="-6.7905" data-lng="111.4589">Kab. Rembang</option>
											<option value="Pati" data-lat="-6.7570" data-lng="111.0375">Kab. Pati</option>
											<option value="Kudus" data-lat="-6.8048" data-lng="110.8405">Kab. Kudus</option>
											<option value="Jepara" data-lat="-6.5861" data-lng="110.6698">Kab. Jepara</option>
											<option value="Demak" data-lat="-6.8953" data-lng="110.6385">Kab. Demak</option>
											<option value="Semarang" data-lat="-7.1852" data-lng="110.4284">Kab. Semarang</option>
											<option value="Temanggung" data-lat="-7.3117" data-lng="110.1557">Kab. Temanggung</option>
											<option value="Kendal" data-lat="-7.0310" data-lng="110.1654">Kab. Kendal</option>
											<option value="Batang" data-lat="-7.0097" data-lng="109.8453">Kab. Batang</option>
											<option value="Pekalongan" data-lat="-7.0673" data-lng="109.6105">Kab. Pekalongan</option>
											<option value="Pemalang" data-lat="-7.0392" data-lng="109.4312">Kab. Pemalang</option>
											<option value="Tegal" data-lat="-7.0381" data-lng="109.1677">Kab. Tegal</option>
											<option value="Brebes" data-lat="-7.0422" data-lng="108.9172">Kab. Brebes</option>
											<option value="Kota Magelang" data-lat="-7.4728" data-lng="110.2223">Kota Magelang</option>
											<option value="Kota Surakarta" data-lat="-7.5561" data-lng="110.8317">Kota Surakarta</option>
											<option value="Kota Salatiga" data-lat="-7.3305" data-lng="110.5084">Kota Salatiga</option>
											<option value="Kota Semarang" data-lat="-7.0051" data-lng="110.4381">Kota Semarang</option>
											<option value="Kota Pekalongan" data-lat="-6.8898" data-lng="109.6773">Kota Pekalongan</option>
											<option value="Kota Tegal" data-lat="-6.8797" data-lng="109.1256">Kota Tegal</option>
										</select>
										<span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
											<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
											</svg>
										</span>
									</div>
									<div class="rounded-2xl bg-[#F8FAFC] px-4 py-3">
										<p class="text-xs text-slate-500">Kabupaten terpilih</p>
										<p id="selectedRegion" class="text-lg font-semibold text-[#1E3A8A]">Kab. Cilacap</p>
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
										<p class="mt-1 text-sm text-slate-500">Menampilkan wilayah kabupaten/kota di Jawa Tengah.</p>
									</div>
								</div>
								<div class="mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 relative">
									<div id="map" class="h-[500px] w-full z-0 relative"></div>
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
		
		<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				var map = L.map('map').setView([-7.6402, 109.0069], 10);
				
				L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					maxZoom: 19,
				}).addTo(map);

				var regionSelect = document.getElementById('regionSelect');
				var selectedRegionText = document.getElementById('selectedRegion');
				var currentLayer = null;

				function loadRegionBoundary(name, fallbackLat, fallbackLng) {
					var searchName = name.replace('Kab.', 'Kabupaten') + ', Jawa Tengah';
					
					fetch('https://nominatim.openstreetmap.org/search?q=' + encodeURIComponent(searchName) + '&format=json&polygon_geojson=1&limit=1')
						.then(response => response.json())
						.then(data => {
							if (currentLayer) {
								map.removeLayer(currentLayer);
							}

							if (data && data.length > 0 && data[0].geojson && (data[0].geojson.type === 'Polygon' || data[0].geojson.type === 'MultiPolygon')) {
								currentLayer = L.geoJSON(data[0].geojson, {
									style: {
										color: '#ef4444', // Red border
										weight: 2,
										opacity: 1,
										fillColor: '#000000',
										fillOpacity: 0.1
									}
								}).addTo(map);

								map.fitBounds(currentLayer.getBounds());
							} else {
								// Fallback to marker if polygon not found
								map.setView([fallbackLat, fallbackLng], 10);
								currentLayer = L.marker([fallbackLat, fallbackLng]).bindPopup("<b>" + name + "</b>").addTo(map).openPopup();
							}
						})
						.catch(error => {
							console.error('Error fetching region boundary:', error);
							if (currentLayer) map.removeLayer(currentLayer);
							map.setView([fallbackLat, fallbackLng], 10);
							currentLayer = L.marker([fallbackLat, fallbackLng]).bindPopup("<b>" + name + "</b>").addTo(map).openPopup();
						});
				}

				// Initial load
				loadRegionBoundary('Kab. Cilacap', -7.6402, 109.0069);

				regionSelect.addEventListener('change', function () {
					var selectedOption = this.options[this.selectedIndex];
					var lat = parseFloat(selectedOption.getAttribute('data-lat'));
					var lng = parseFloat(selectedOption.getAttribute('data-lng'));
					var name = selectedOption.text;

					if (selectedRegionText) selectedRegionText.textContent = name;
					loadRegionBoundary(name, lat, lng);
				});
			});
		</script>
	</body>
</html>
