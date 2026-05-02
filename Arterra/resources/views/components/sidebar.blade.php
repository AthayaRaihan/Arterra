<aside class="w-full lg:w-72 bg-white/95 backdrop-blur border-b lg:border-b-0 lg:border-r border-slate-200/80 lg:fixed lg:left-0 lg:top-0 lg:h-screen lg:overflow-y-auto">
    @php
        $isDashboard = Route::is('dashboard');
        $isEqi = Route::is('eqi');
        $isPrediction = Route::is('prediction');
        $isSimulation = Route::is('simulation.index');
    @endphp
    <div class="px-6 pt-7 pb-5">
        <div class="flex items-center gap-3">
            <img src="{{ asset('assets/icon.png') }}" class="w-11 h-11 object-contain" alt="Arterra Logo">
            <div>
                <p class="text-lg font-semibold tracking-wide">Arterra</p>
                <p class="text-xs text-slate-500">Jawa Tengah Analytics</p>
            </div>
        </div>
    </div>
    <nav class="px-4 pb-6">
        <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Menu Utama</p>
        <div class="mt-3 grid grid-cols-2 gap-2 lg:flex lg:flex-col">
            <a class="group px-3 py-2 rounded-xl {{ $isDashboard ? 'bg-[#1D4ED8] text-white font-semibold shadow-sm' : 'text-slate-700 hover:bg-[#1D4ED8]/10 hover:text-[#1D4ED8] transition' }}" href="{{ route('dashboard') }}">
                <span class="flex items-center gap-2">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg {{ $isDashboard ? 'bg-white/15 text-white' : 'bg-[#1D4ED8]/10 text-[#1D4ED8]' }}">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 10.5L12 4L20 10.5V19a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1v-8.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                        </svg>
                    </span>
                    Dashboard
                </span>
            </a>
            <a class="group px-3 py-2 rounded-xl {{ $isEqi ? 'bg-[#22C55E] text-white font-semibold shadow-sm' : 'text-slate-700 hover:bg-[#22C55E]/10 hover:text-[#22C55E] transition' }}" href="{{ route('eqi') }}">
                <span class="flex items-center gap-2">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg {{ $isEqi ? 'bg-white/15 text-white' : 'bg-[#22C55E]/10 text-[#22C55E]' }}">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 5H11V11H5V5Z" stroke="currentColor" stroke-width="1.5" />
                            <path d="M13 5H19V9H13V5Z" stroke="currentColor" stroke-width="1.5" />
                            <path d="M13 11H19V19H13V11Z" stroke="currentColor" stroke-width="1.5" />
                            <path d="M5 13H11V19H5V13Z" stroke="currentColor" stroke-width="1.5" />
                        </svg>
                    </span>
                    Education Quality Index
                </span>
            </a>
            <a class="group px-3 py-2 rounded-xl {{ $isPrediction ? 'bg-[#F59E0B] text-white font-semibold shadow-sm' : 'text-slate-700 hover:bg-[#F59E0B]/10 hover:text-[#B45309] transition' }}" href="{{ route('prediction') }}">
                <span class="flex items-center gap-2">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg {{ $isPrediction ? 'bg-white/15 text-white' : 'bg-[#F59E0B]/10 text-[#B45309]' }}">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 18L9 12L13 15L20 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M20 7V12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </span>
                    Prediction
                </span>
            </a>
            <a class="group px-3 py-2 rounded-xl {{ $isSimulation ? 'bg-[#14B8A6] text-white font-semibold shadow-sm' : 'text-slate-700 hover:bg-[#14B8A6]/10 hover:text-[#0F766E] transition' }}" href="{{ route('simulation.index') }}">
                <span class="flex items-center gap-2">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg {{ $isSimulation ? 'bg-white/15 text-white' : 'bg-[#14B8A6]/10 text-[#0F766E]' }}">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 7H20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M4 12H20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M4 17H20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <circle cx="8" cy="7" r="2" fill="currentColor" />
                            <circle cx="16" cy="12" r="2" fill="currentColor" />
                            <circle cx="12" cy="17" r="2" fill="currentColor" />
                        </svg>
                    </span>
                    Simulation
                </span>
            </a>
        </div>
        @php
            $sidebarEqiData = \App\Models\EduQuality::whereNotNull('eqi_score')->get();
            $sidebarRataRata = $sidebarEqiData->avg('eqi_score');
            $sidebarPrioritas = $sidebarEqiData->where('kategori', 'Rendah')->count();
        @endphp
        
        <p class="mt-6 px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Ringkasan</p>
        <div class="mt-3 space-y-3 px-3">
            <div class="rounded-xl border border-slate-200 bg-white px-3 py-3">
                <p class="text-xs text-slate-500">Wilayah Prioritas</p>
                <p class="text-lg font-semibold text-[#DC2626]">{{ $sidebarPrioritas }} <span class="text-xs font-normal text-slate-400">kab/kota</span></p>
            </div>
        </div>
    </nav>
</aside>
