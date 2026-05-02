<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="{{ asset('assets/icon.png') }}">
    <title>{{ config('app.name') }} </title>
    <meta name="description" content="Peta Education Quality Index Jawa Tengah — visualisasi kualitas pendidikan 35 kabupaten/kota.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #map { height: 500px; width: 100%; }
        .detail-card { transition: all 0.4s ease; }
        .bar-fill { transition: width 1s ease; }
    </style>
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
                        <p class="mt-2 max-w-2xl text-sm text-slate-600">Visualisasi persebaran kualitas pendidikan berdasarkan EQI score antar kabupaten/kota.</p>
                    </div>
                    <div>
                        <button id="btnRefresh" onclick="refreshEqi()" class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Hitung Ulang EQI
                        </button>
                    </div>
                </header>

                {{-- MAP SECTION --}}
                <section class="mt-6">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-semibold text-[#1E3A8A]">Peta Persebaran Kualitas Pendidikan</h2>
                                <p class="text-sm text-slate-500">Warna berdasarkan EQI Score (Hijau = Tinggi, Merah = Rendah)</p>
                            </div>
                            <div class="relative">
                                <select id="regionSelect" class="w-56 appearance-none rounded-xl border border-slate-200 bg-white px-4 py-2 pr-10 text-sm font-semibold text-slate-700 shadow-sm transition focus:border-[#1E3A8A] focus:outline-none relative z-10">
                                    <option value="">Semua Wilayah</option>
                                </select>
                                <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"><path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </span>
                            </div>
                        </div>

                        <div id="loadingOverlay" class="mt-4 flex items-center justify-center h-24 text-slate-500 text-sm gap-2">
                            <svg class="animate-spin h-5 w-5 text-[#1E3A8A]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                            Memuat data EQI...
                        </div>

                        <div id="mapWrapper" class="mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 relative hidden">
                            <div id="map" class="z-0 relative"></div>
                        </div>

                        <div class="mt-6 flex flex-wrap items-center justify-center gap-3 text-xs font-semibold text-slate-600">
                            <span>EQI Rendah</span>
                            <div class="h-3 w-64 rounded-full" style="background: linear-gradient(to right, #ef4444, #f59e0b, #22c55e);"></div>
                            <span>EQI Tinggi</span>
                        </div>
                    </div>
                </section>

                {{-- DETAIL SECTION --}}
                <section id="detailSection" class="mt-6 hidden">
                    <div class="mb-4">
                        <h2 id="detailRegionName" class="text-2xl font-bold text-[#1F2937]">Kabupaten Terpilih</h2>
                        <p class="text-sm text-slate-500">Detail 12 indikator pendidikan</p>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Rata-rata Lama Sekolah</p>
                            <p class="mt-2 text-3xl font-bold text-[#1F2937]"><span id="valRLS">-</span> <span class="text-sm font-medium text-slate-500">Tahun</span></p>
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">APS (Rata-rata)</p>
                            <p class="mt-2 text-3xl font-bold text-[#1F2937]"><span id="valAPS">-</span>%</p>
                            <div class="mt-3 h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div id="barAPS" class="h-full bg-[#1E3A8A] rounded-full bar-fill" style="width:0%"></div>
                            </div>
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">APK (Rata-rata)</p>
                            <p class="mt-2 text-3xl font-bold text-[#1F2937]"><span id="valAPK">-</span>%</p>
                            <div class="mt-3 h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div id="barAPK" class="h-full bg-emerald-500 rounded-full bar-fill" style="width:0%"></div>
                            </div>
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Akses Internet</p>
                            <p class="mt-2 text-3xl font-bold text-[#1F2937]"><span id="valInternet">-</span>%</p>
                            <div class="mt-3 h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div id="barInternet" class="h-full bg-blue-500 rounded-full bar-fill" style="width:0%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-6 lg:grid-cols-2">
                        {{-- Left: feature bars --}}
                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                            <h3 class="text-sm font-semibold text-slate-700 mb-5">Indikator Kualitas Pendidikan</h3>
                            <div class="space-y-4" id="featureBars"></div>
                        </div>

                        {{-- Right: more indicators --}}
                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                            <h3 class="text-sm font-semibold text-slate-700 mb-5">Indikator Infrastruktur & SDM</h3>
                            <div class="space-y-4" id="infraBars"></div>
                        </div>
                    </div>
                </section>

                {{-- RANKING SECTION --}}
                <section class="mt-6">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-[#1E3A8A] mb-1">Ranking EQI — 35 Kabupaten/Kota</h2>
                        <p class="text-sm text-slate-500 mb-5">Diurutkan dari EQI tertinggi ke terendah</p>
                        <div id="rankingList" class="divide-y divide-slate-100"></div>
                    </div>
                </section>
            </div>
        </section>
    </main>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
(function () {
    /* ── State ──────────────────────────────────────────────────────────── */
    let eqiData  = [];   // array of kabupaten objects from /api/eqi-data
    let mapData  = null; // GeoJSON
    let map, geoJsonLayer;

    const regionSelect  = document.getElementById('regionSelect');
    const detailSection = document.getElementById('detailSection');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const mapWrapper    = document.getElementById('mapWrapper');

    /* ── Color helper: EQI 0-100 → HSL hex (red→yellow→green) ─────────── */
    function eqiColor(score) {
        const s = Math.max(0, Math.min(100, score || 0));
        const hue = Math.round((s / 100) * 142); // 0=red, 142=green
        return `hsl(${hue},80%,42%)`;
    }

    /* ── Build a bar row ─────────────────────────────────────────────────── */
    function barRow(label, value, max, color) {
        const pct = Math.min(100, (value / max) * 100).toFixed(1);
        return `<div>
            <div class="flex justify-between text-xs text-slate-600 mb-1">
                <span class="font-medium">${label}</span>
                <span class="font-semibold">${value}</span>
            </div>
            <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full rounded-full bar-fill" style="width:${pct}%;background:${color}"></div>
            </div>
        </div>`;
    }

    /* ── Show detail panel for a kabupaten ───────────────────────────────── */
    function showDetail(d) {
        detailSection.classList.remove('hidden');
        document.getElementById('detailRegionName').textContent = d.nama;

        document.getElementById('valRLS').textContent = d.rls;
        document.getElementById('valAPS').textContent = d.aps;
        document.getElementById('barAPS').style.width = Math.min(100, d.aps) + '%';
        document.getElementById('valAPK').textContent = d.apk;
        document.getElementById('barAPK').style.width = Math.min(100, d.apk) + '%';
        document.getElementById('valInternet').textContent = d.akses_internet;
        document.getElementById('barInternet').style.width = Math.min(100, d.akses_internet) + '%';

        document.getElementById('featureBars').innerHTML =
            barRow('Ruang Kelas Layak (%)', d.ruang_kelas, 100, '#1E3A8A') +
            barRow('Guru Berpendidikan S1 (%)', d.guru_s1, 100, '#6366f1') +
            barRow('Sekolah Ber-lab (%)', d.sekolah_lab, 100, '#8b5cf6') +
            barRow('Dropout Rate (%)', d.dropout_rate, 10, '#ef4444');

        document.getElementById('infraBars').innerHTML =
            barRow('Rasio Guru:Siswa', +(d.rasio_guru).toFixed(3), 0.15, '#f59e0b') +
            barRow('Siswa per Sekolah', d.siswa_per_sekolah, 400, '#f97316') +
            barRow('Persebaran Sekolah', +(d.persebaran_sekolah).toFixed(2), 1, '#10b981') +
            barRow('Akses Sekolah', +(d.akses_sekolah).toFixed(2), 1, '#14b8a6');

        // Do not auto-scroll — user stays at the map position
    }

    /* ── Highlight ranking item ──────────────────────────────────────────── */
    function highlightRanking(nama) {
        document.querySelectorAll('.rank-item').forEach(el => {
            if (nama && el.dataset.nama === nama) {
                el.classList.add('bg-[#1E3A8A]/5', 'ring-1', 'ring-[#1E3A8A]/30', 'shadow-sm', 'font-black');
                el.classList.remove('hover:bg-[#f1f5f9]'); // optional remove hover effect when selected
            } else {
                el.classList.remove('bg-[#1E3A8A]/5', 'ring-1', 'ring-[#1E3A8A]/30', 'shadow-sm', 'font-black');
                el.classList.add('hover:bg-[#f1f5f9]');
            }
        });
    }

    /* ── Build ranking list ──────────────────────────────────────────────── */
    function buildRanking() {
        const container = document.getElementById('rankingList');
        container.innerHTML = eqiData.map((d, i) => {
            const color = eqiColor(d.eqi_score);
            const score = d.eqi_score != null ? d.eqi_score.toFixed(2) : 'N/A';
            return `<div class="rank-item flex items-center gap-4 py-3 px-2 rounded-xl cursor-pointer hover:bg-[#f1f5f9] transition-all" data-nama="${d.nama}" onclick="selectKabupaten('${d.nama}')">
                <span class="w-7 text-center text-xs font-bold text-slate-400">${i + 1}</span>
                <span class="flex-1 text-sm font-semibold text-slate-700">${d.nama}</span>
                <span class="text-xs font-medium px-2 py-0.5 rounded-full text-white" style="background:${color}">${d.kategori || '-'}</span>
                <span class="text-sm font-bold" style="color:${color}">${score}</span>
            </div>`;
        }).join('');
    }

    /* ── Populate region select dropdown ────────────────────────────────── */
    function buildSelect() {
        eqiData.forEach(d => {
            const opt = document.createElement('option');
            opt.value = d.nama;
            opt.textContent = d.nama;
            regionSelect.appendChild(opt);
        });
    }

    /* ── GeoJSON style using real EQI color ──────────────────────────────── */
    function getFeatureColor(name) {
        const d = eqiData.find(x => x.nama === name || name.includes(x.nama) || x.nama.includes(name));
        return d && d.eqi_score != null ? eqiColor(d.eqi_score) : '#94a3b8';
    }

    function styleFeature(feature) {
        return {
            fillColor: getFeatureColor(feature.properties.name),
            weight: 1, opacity: 1, color: 'white', dashArray: '3', fillOpacity: 0.75
        };
    }

    function highlightFeature(e) {
        const selectedValue = regionSelect.value;
        const name = e.target.feature.properties.name;
        
        // Jika sedang fokus ke satu kabupaten, jangan highlight kabupaten lain di sekitarnya
        if (selectedValue && !(name === selectedValue || selectedValue.includes(name) || name.includes(selectedValue))) {
            return;
        }

        e.target.setStyle({ weight: 2, color: '#1E3A8A', dashArray: '', fillOpacity: 0.92 });
        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
            e.target.bringToFront();
        }
    }

    function resetHighlight(e) {
        const selectedValue = regionSelect.value;
        const name = e.target.feature && e.target.feature.properties.name;
        
        // Jika sedang fokus ke satu kabupaten, abaikan reset untuk kabupaten lain
        if (selectedValue && !(name === selectedValue || selectedValue.includes(name) || name.includes(selectedValue))) {
            return;
        }

        // geoJsonLayer may be a L.GeoJSON (has resetStyle) or L.LayerGroup (doesn't)
        if (geoJsonLayer && typeof geoJsonLayer.resetStyle === 'function') {
            geoJsonLayer.resetStyle(e.target);
        } else {
            // Restore style manually based on the feature's EQI color
            e.target.setStyle({
                fillColor: name ? getFeatureColor(name) : '#94a3b8',
                weight: 1, opacity: 1, color: 'white', dashArray: '3', fillOpacity: 0.75
            });
        }
    }

    function onEachFeature(feature, layer) {
        const name = feature.properties.name;
        const d = eqiData.find(x => x.nama === name || name.includes(x.nama) || x.nama.includes(name));
        const score = d && d.eqi_score != null ? d.eqi_score.toFixed(2) : 'N/A';
        const cat   = d ? (d.kategori || '') : '';
        layer.bindTooltip(`<div class="text-center"><b>${name}</b><br>EQI: <span class="font-bold">${score}</span><br><small>${cat}</small></div>`);
        layer.on({
            mouseover: highlightFeature,
            mouseout:  resetHighlight,
            click: function() {
                const found = eqiData.find(x => x.nama === name || name.includes(x.nama) || x.nama.includes(name));
                if (found) {
                    regionSelect.value = found.nama;
                    regionSelect.dispatchEvent(new Event('change'));
                }
            }
        });
    }

    /* ── Init map ────────────────────────────────────────────────────────── */
    function initMap() {
        // Tampilkan container map dulu agar Leaflet bisa menghitung ukurannya
        loadingOverlay.classList.add('hidden');
        mapWrapper.classList.remove('hidden');

        map = L.map('map').setView([-7.1509, 110.1402], 8);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', { maxZoom: 19 }).addTo(map);

        fetch('/jawa-tengah.geojson')
            .then(r => r.json())
            .then(data => {
                mapData = data;
                geoJsonLayer = L.geoJSON(data, { style: styleFeature, onEachFeature }).addTo(map);
                
                // Pastikan ukuran di-refresh sebelum nge-fit bounds
                map.invalidateSize();
                map.fitBounds(geoJsonLayer.getBounds());
            })
            .catch(err => {
                mapWrapper.classList.add('hidden');
                loadingOverlay.classList.remove('hidden');
                loadingOverlay.textContent = 'Gagal memuat GeoJSON peta.';
                console.error(err);
            });
    }

    /* ── Select kabupaten (from dropdown or rank click) ──────────────────── */
    window.selectKabupaten = function(nama) {
        regionSelect.value = nama;
        regionSelect.dispatchEvent(new Event('change'));
    };

    regionSelect.addEventListener('change', function () {
        const nama = this.value;

        highlightRanking(nama);

        if (!nama) {
            detailSection.classList.add('hidden');
            if (map && mapData) {
                map.removeLayer(geoJsonLayer);
                geoJsonLayer = L.geoJSON(mapData, { style: styleFeature, onEachFeature }).addTo(map);
                map.fitBounds(geoJsonLayer.getBounds());
            }
            return;
        }

        const d = eqiData.find(x => x.nama === nama);
        if (d) showDetail(d);

        if (map && mapData) {
            map.removeLayer(geoJsonLayer);
            const lg = L.layerGroup().addTo(map);
            geoJsonLayer = lg;

            const others = mapData.features.filter(f => {
                return !(f.properties.name === nama || nama.includes(f.properties.name) || f.properties.name.includes(nama));
            });
            const selected = mapData.features.find(f =>
                f.properties.name === nama || nama.includes(f.properties.name) || f.properties.name.includes(nama)
            );

            L.geoJSON(others, {
                style: { fillColor: '#cbd5e1', weight: 1, opacity: 0.4, color: 'white', fillOpacity: 0.2 },
                onEachFeature
            }).addTo(lg);

            if (selected) {
                const selLayer = L.geoJSON(selected, {
                    style: {
                        fillColor: getFeatureColor(selected.properties.name),
                        weight: 3, opacity: 1, color: '#1E3A8A', fillOpacity: 0.92
                    },
                    onEachFeature
                }).addTo(lg);
                map.fitBounds(selLayer.getBounds(), { padding: [40, 40] });
            }
        }
    });

    /* ── Refresh EQI via Laravel API ─────────────────────────────────────── */
    window.refreshEqi = function () {
        const btn = document.getElementById('btnRefresh');
        btn.disabled = true;
        btn.textContent = 'Menghitung...';

        fetch('/api/eqi-refresh', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
        })
        .then(r => r.json())
        .then(res => {
            if (res.status === 'success') {
                location.reload();
            } else {
                alert('Error: ' + res.message);
                btn.disabled = false;
                btn.textContent = 'Hitung Ulang EQI';
            }
        })
        .catch(err => {
            alert('Gagal menghubungi server: ' + err);
            btn.disabled = false;
            btn.textContent = 'Hitung Ulang EQI';
        });
    };

    /* ── Bootstrap: fetch EQI data then init everything ─────────────────── */
    fetch('/api/eqi-data')
        .then(r => r.json())
        .then(res => {
            eqiData = res.data || [];
            buildSelect();
            buildRanking();
            initMap();
        })
        .catch(err => {
            loadingOverlay.textContent = 'Gagal memuat data EQI dari server.';
            console.error(err);
        });
})();
</script>
</body>
</html>
