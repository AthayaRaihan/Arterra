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
								<p class="mt-2 max-w-2xl text-sm text-slate-600">Visualisasi persebaran kualitas pendidikan berdasarkan ranking relatif antar kabupaten/kota.</p>
							</div>
						</header>

						<section class="mt-6">
							<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
								<div class="mb-4 flex flex-wrap items-center justify-between gap-4">
									<div>
										<h2 class="text-lg font-semibold text-[#1E3A8A]">Peta Persebaran Kualitas Pendidikan</h2>
										<p class="text-sm text-slate-500">Tampilan berdasarkan ranking relatif (Hijau = Tinggi, Merah = Rendah)</p>
									</div>
									<div class="relative">
										<select id="regionSelect" class="w-56 appearance-none rounded-xl border border-slate-200 bg-white px-4 py-2 pr-10 text-sm font-semibold text-slate-700 shadow-sm transition focus:border-[#1E3A8A] focus:outline-none relative z-10">
											<option value="" selected>Semua Wilayah</option>
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
								
								<div class="mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 relative">
									<div id="map" class="h-[500px] w-full z-0 relative"></div>
								</div>
                                
                                <div class="mt-6 flex flex-wrap items-center justify-center gap-3 text-xs font-semibold text-slate-600">
                                    <span>Kualitas Relatif Rendah</span>
                                    <div class="h-3 w-64 rounded-full" style="background: linear-gradient(to right, #ef4444, #f59e0b, #10b981);"></div>
                                    <span>Kualitas Relatif Tinggi</span>
                                </div>
							</div>
						</section>

						<section id="detailSection" class="mt-6 hidden transition-all duration-500">
							<div class="mb-4">
								<h2 id="detailRegionName" class="text-2xl font-bold text-[#1F2937]">Kabupaten Terpilih</h2>
								<p class="text-sm text-slate-500">Detail indikator pendidikan (Data Simulasi)</p>
							</div>

							<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
								<!-- Card 1 -->
								<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
									<p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Rata-rata Lama Sekolah</p>
									<p class="mt-2 text-3xl font-bold text-[#1F2937]"><span id="valRLS">7.5</span> <span class="text-sm font-medium text-slate-500">Tahun</span></p>
                                    <p class="mt-2 text-xs text-emerald-600 font-medium">↑ Di atas rata-rata provinsi</p>
								</div>
								
                                <!-- Card 2 -->
								<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
									<p class="text-xs font-semibold uppercase tracking-wider text-slate-500">APS (Rata-rata)</p>
									<p class="mt-2 text-3xl font-bold text-[#1F2937]"><span id="valAPS">82.4</span>%</p>
                                    <div class="mt-3 h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-[#1E3A8A] rounded-full transition-all duration-1000" style="width: 82.4%"></div>
                                    </div>
								</div>

                                <!-- Card 3 -->
								<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
									<p class="text-xs font-semibold uppercase tracking-wider text-slate-500">APK (Rata-rata)</p>
									<p class="mt-2 text-3xl font-bold text-[#1F2937]"><span id="valAPK">85.1</span>%</p>
                                    <div class="mt-3 h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000" style="width: 85.1%"></div>
                                    </div>
								</div>

                                <!-- Card 4 -->
								<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm flex items-center gap-4">
									<div class="flex-1">
                                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Sekolah</p>
									    <p class="mt-1 text-3xl font-bold text-[#1F2937]" id="valSekolah">1,240</p>
                                    </div>
                                    <div class="h-12 w-12 rounded-full bg-[#4CAF50]/15 text-[#2E7D32] flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
								</div>
							</div>

							<div class="mt-6 grid gap-6 lg:grid-cols-2">
								<!-- Bar Chart -->
								<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
									<h3 class="text-sm font-semibold text-slate-700">Perbandingan APS & APK per Jenjang</h3>
                                    <div class="mt-6 space-y-5">
                                        <!-- SD -->
                                        <div>
                                            <div class="flex justify-between text-xs font-medium text-slate-600 mb-1">
                                                <span>SD/Sederajat</span>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <span class="text-[10px] w-6 text-slate-400">APS</span>
                                                <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                                    <div class="h-full bg-[#1E3A8A] rounded-full transition-all duration-1000" id="barApsSD" style="width: 98%"></div>
                                                </div>
                                                <span class="text-xs font-semibold w-8 text-right" id="valApsSD">98%</span>
                                            </div>
                                            <div class="flex items-center gap-3 mt-1.5">
                                                <span class="text-[10px] w-6 text-slate-400">APK</span>
                                                <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                                    <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000" id="barApkSD" style="width: 102%"></div>
                                                </div>
                                                <span class="text-xs font-semibold w-8 text-right" id="valApkSD">102%</span>
                                            </div>
                                        </div>
                                        <!-- SMP -->
                                        <div>
                                            <div class="flex justify-between text-xs font-medium text-slate-600 mb-1">
                                                <span>SMP/Sederajat</span>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <span class="text-[10px] w-6 text-slate-400">APS</span>
                                                <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                                    <div class="h-full bg-[#1E3A8A] rounded-full transition-all duration-1000" id="barApsSMP" style="width: 85%"></div>
                                                </div>
                                                <span class="text-xs font-semibold w-8 text-right" id="valApsSMP">85%</span>
                                            </div>
                                            <div class="flex items-center gap-3 mt-1.5">
                                                <span class="text-[10px] w-6 text-slate-400">APK</span>
                                                <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                                    <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000" id="barApkSMP" style="width: 88%"></div>
                                                </div>
                                                <span class="text-xs font-semibold w-8 text-right" id="valApkSMP">88%</span>
                                            </div>
                                        </div>
                                        <!-- SMA -->
                                        <div>
                                            <div class="flex justify-between text-xs font-medium text-slate-600 mb-1">
                                                <span>SMA/Sederajat</span>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <span class="text-[10px] w-6 text-slate-400">APS</span>
                                                <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                                    <div class="h-full bg-[#1E3A8A] rounded-full transition-all duration-1000" id="barApsSMA" style="width: 65%"></div>
                                                </div>
                                                <span class="text-xs font-semibold w-8 text-right" id="valApsSMA">65%</span>
                                            </div>
                                            <div class="flex items-center gap-3 mt-1.5">
                                                <span class="text-[10px] w-6 text-slate-400">APK</span>
                                                <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                                    <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000" id="barApkSMA" style="width: 67%"></div>
                                                </div>
                                                <span class="text-xs font-semibold w-8 text-right" id="valApkSMA">67%</span>
                                            </div>
                                        </div>
                                    </div>
								</div>

								<!-- Donut Chart -->
								<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm flex flex-col">
									<h3 class="text-sm font-semibold text-slate-700">Persebaran Jumlah Sekolah</h3>
                                    <div class="flex-1 flex items-center justify-center mt-4">
                                        <div class="relative h-48 w-48 rounded-full transition-all duration-1000" id="sekolahDonut" style="background: conic-gradient(#10b981 0% 60%, #f59e0b 60% 85%, #ef4444 85% 100%);">
                                            <div class="absolute inset-4 rounded-full bg-white flex items-center justify-center flex-col">
                                                <span class="text-2xl font-bold text-[#1F2937]" id="valSekolahDonut">1,240</span>
                                                <span class="text-[10px] uppercase font-bold text-slate-400">Total</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex flex-wrap justify-center gap-4 text-xs font-medium">
                                        <div class="flex items-center gap-1.5"><span class="h-3 w-3 rounded-full bg-emerald-500"></span> SD (<span id="pctSD">60</span>%)</div>
                                        <div class="flex items-center gap-1.5"><span class="h-3 w-3 rounded-full bg-amber-500"></span> SMP (<span id="pctSMP">25</span>%)</div>
                                        <div class="flex items-center gap-1.5"><span class="h-3 w-3 rounded-full bg-red-500"></span> SMA (<span id="pctSMA">15</span>%)</div>
                                    </div>
								</div>
							</div>
						</section>
					</div>
				</section>
			</main>
		</div>
		
		<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				var map = L.map('map').setView([-7.1509, 110.1402], 8);
				
				L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
					maxZoom: 19
				}).addTo(map);

				var regionSelect = document.getElementById('regionSelect');
                var detailSection = document.getElementById('detailSection');
                var detailRegionName = document.getElementById('detailRegionName');
                
                var geoJsonLayer;
                var mapData = null;

                function getColor(rank) {
                    if(rank > 80) return '#10b981';
                    if(rank > 60) return '#34d399';
                    if(rank > 40) return '#fbbf24';
                    if(rank > 20) return '#fb923c';
                    return '#ef4444';
                }

                function style(feature) {
                    return {
                        fillColor: getColor(feature.properties.ranking),
                        weight: 1,
                        opacity: 1,
                        color: 'white',
                        dashArray: '3',
                        fillOpacity: 0.7
                    };
                }
                
                function highlightFeature(e) {
                    var layer = e.target;
                    layer.setStyle({
                        weight: 2,
                        color: '#1E3A8A',
                        dashArray: '',
                        fillOpacity: 0.9
                    });
                    layer.bringToFront();
                }

                function resetHighlight(e) {
                    geoJsonLayer.resetStyle(e.target);
                }

                function onEachFeature(feature, layer) {
                    layer.on({
                        mouseover: highlightFeature,
                        mouseout: resetHighlight,
                        click: function(e) {
                            var name = feature.properties.name;
                            for (var i = 0; i < regionSelect.options.length; i++) {
                                if (regionSelect.options[i].text.includes(name)) {
                                    regionSelect.selectedIndex = i;
                                    regionSelect.dispatchEvent(new Event('change'));
                                    break;
                                }
                            }
                        }
                    });
                    layer.bindTooltip('<div class="text-center"><b>' + feature.properties.name + '</b><br>Skor Kualitas Relatif: <span class="font-bold text-emerald-600">' + feature.properties.ranking + '</span>/100</div>');
                }

                fetch('/jawa-tengah.geojson')
                    .then(response => response.json())
                    .then(data => {
                        mapData = data;
                        geoJsonLayer = L.geoJSON(data, {
                            style: style,
                            onEachFeature: onEachFeature
                        }).addTo(map);
                        map.fitBounds(geoJsonLayer.getBounds());
                    })
                    .catch(error => console.error('Error loading GeoJSON:', error));

				regionSelect.addEventListener('change', function () {
					var selectedValue = this.value;
                    var name = this.options[this.selectedIndex].text;
                    
                    if (!selectedValue) {
                        detailSection.classList.add('hidden');
                        if (geoJsonLayer && mapData) {
                            map.removeLayer(geoJsonLayer);
                            geoJsonLayer = L.geoJSON(mapData, {
                                style: style,
                                onEachFeature: onEachFeature
                            }).addTo(map);
                            map.fitBounds(geoJsonLayer.getBounds());
                        }
                        return;
                    }

                    detailRegionName.textContent = name;
                    detailSection.classList.remove('hidden');

                    if (geoJsonLayer && mapData) {
                        map.removeLayer(geoJsonLayer);
                        
                        var selectedFeature = null;
                        var otherFeatures = [];

                        mapData.features.forEach(function(f) {
                            if (f.properties.name === selectedValue || f.properties.name === name || name.includes(f.properties.name)) {
                                selectedFeature = f;
                            } else {
                                otherFeatures.push(f);
                            }
                        });

                        geoJsonLayer = L.layerGroup().addTo(map);

                        L.geoJSON(otherFeatures, {
                            style: {
                                fillColor: '#cbd5e1',
                                weight: 1,
                                opacity: 0.5,
                                color: 'white',
                                fillOpacity: 0.2
                            },
                            onEachFeature: onEachFeature
                        }).addTo(geoJsonLayer);

                        if (selectedFeature) {
                            var selectedLayer = L.geoJSON(selectedFeature, {
                                style: {
                                    fillColor: getColor(selectedFeature.properties.ranking),
                                    weight: 3,
                                    opacity: 1,
                                    color: '#1E3A8A',
                                    fillOpacity: 0.9
                                },
                                onEachFeature: onEachFeature
                            }).addTo(geoJsonLayer);
                            map.fitBounds(selectedLayer.getBounds());
                        }
                    }

                    updateDummyData();
				});

                function updateDummyData() {
                    document.getElementById('valRLS').textContent = (6 + Math.random() * 4).toFixed(1);
                    
                    var apsRata = (70 + Math.random() * 25).toFixed(1);
                    document.getElementById('valAPS').textContent = apsRata;
                    document.getElementById('valAPS').parentElement.nextElementSibling.firstElementChild.style.width = apsRata + '%';

                    var apkRata = (75 + Math.random() * 25).toFixed(1);
                    document.getElementById('valAPK').textContent = apkRata;
                    document.getElementById('valAPK').parentElement.nextElementSibling.firstElementChild.style.width = apkRata + '%';

                    var totalSekolah = Math.floor(500 + Math.random() * 1500);
                    document.getElementById('valSekolah').textContent = totalSekolah.toLocaleString();
                    document.getElementById('valSekolahDonut').textContent = totalSekolah.toLocaleString();

                    ['SD', 'SMP', 'SMA'].forEach(function(lvl) {
                        var aps = Math.floor(60 + Math.random() * 38);
                        var apk = Math.floor(aps + Math.random() * 10);
                        document.getElementById('valAps' + lvl).textContent = aps + '%';
                        document.getElementById('barAps' + lvl).style.width = aps + '%';
                        document.getElementById('valApk' + lvl).textContent = apk + '%';
                        document.getElementById('barApk' + lvl).style.width = Math.min(100, apk) + '%';
                    });

                    var sdPct = Math.floor(50 + Math.random() * 20);
                    var smpPct = Math.floor(20 + Math.random() * 15);
                    var smaPct = 100 - sdPct - smpPct;
                    
                    document.getElementById('pctSD').textContent = sdPct;
                    document.getElementById('pctSMP').textContent = smpPct;
                    document.getElementById('pctSMA').textContent = smaPct;

                    var p1 = sdPct;
                    var p2 = sdPct + smpPct;
                    
                    document.getElementById('sekolahDonut').style.background = 
                        `conic-gradient(#10b981 0% ${p1}%, #f59e0b ${p1}% ${p2}%, #ef4444 ${p2}% 100%)`;
                }
			});
		</script>
	</body>
</html>
