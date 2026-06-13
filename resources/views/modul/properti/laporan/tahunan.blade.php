<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <h1 class="mt-8 text-3xl font-bold text-gray-800 mb-8 font-poppins text-[32px]">Laporan Tahunan</h1>

            <!-- Top Tabs Navigation -->
            <div class="flex space-x-6 border-b border-gray-200 mb-8">
                <a href="{{ route('laporan.project') }}" 
                   class="pb-3 px-2 font-bold text-sm border-b-2 transition-colors {{ request()->routeIs('laporan.project') ? 'border-[#82C17D] text-[#82C17D]' : 'border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-300' }}">
                   Laporan Project
                </a>
                <a href="{{ route('laporan.tahunan') }}" 
                   class="pb-3 px-2 font-bold text-sm border-b-2 transition-colors {{ request()->routeIs('laporan.tahunan') ? 'border-[#82C17D] text-[#82C17D]' : 'border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-300' }}">
                   Laporan Tahunan
                </a>
            </div>

            <!-- Content Area -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 min-h-[400px] flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Daftar Laporan Tahunan</h3>
                </div>

                    <div class="space-y-4">
                        @forelse($years as $y)
                            <div x-data="{ 
                                    open: false, 
                                    loaded: false, 
                                    loading: false, 
                                    files: [], 
                                    fetchFiles() {
                                        this.loading = true;
                                        fetch(`/laporan/tahunan/{{ $y->tahun }}`)
                                            .then(res => res.json())
                                            .then(data => {
                                                this.files = data.files || [];
                                                this.loaded = true;
                                                this.loading = false;
                                            })
                                            .catch(() => { this.loading = false; });
                                    },
                                    formatDate(dateStr) {
                                        if(!dateStr) return '-';
                                        return new Date(dateStr).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'});
                                    },
                                    getNoLaporan(id) {
                                        if(!id) return '-';
                                        return `No: ${String(id).padStart(3, '0')}/KJPP/{{ $y->tahun }}`;
                                    },
                                    getClientName(item) {
                                        if(item.client && item.client.name) return item.client.name;
                                        if(item.contact_person) return item.contact_person;
                                        return 'Instansi/Klien Umum';
                                    },
                                    getCleanName(item) {
                                        let name = item.nama_project || item.nama_file || 'Document';
                                        if (name.toLowerCase().endsWith('.pdf')) {
                                            return name.substring(0, name.length - 4);
                                        }
                                        return name;
                                    },
                                    getPath(item) {
                                        return item.dokumen || item.file_path || '#';
                                    }
                                }" 
                                class="border border-gray-100 rounded-xl mb-3 overflow-hidden bg-white hover:border-gray-200 transition-colors shadow-sm">
                                
                                <!-- Header Row -->
                                <div @click="open = !open; if(!loaded) fetchFiles()"
                                    class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50/50 group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center transition-transform"
                                             :class="open ? 'bg-[#82C17D] text-white shadow-md' : ''">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                        </div>
                                        <span class="text-gray-700 font-bold text-sm transition-colors" :class="open ? 'text-[#82C17D]' : ''">Laporan {{ $y->tahun }}</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <svg class="w-5 h-5 text-gray-300 transition-transform duration-300" 
                                             :class="open ? 'rotate-90 text-[#82C17D]' : 'group-hover:text-[#82C17D]'"
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Accordion Panel -->
                                <div x-show="open" x-collapse class="border-t border-gray-100 bg-gray-50/50">
                                    <div class="p-5 space-y-4">
                                        <!-- Loading state -->
                                        <div x-show="loading" class="flex justify-center items-center py-6 text-gray-400">
                                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-[#82C17D]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">Memuat laporan...</span>
                                        </div>

                                        <!-- Empty state -->
                                        <div x-show="loaded && files.length === 0" class="text-center py-6">
                                            <p class="text-gray-500 font-medium text-sm">Belum ada file di tahun ini.</p>
                                        </div>

                                        <!-- Files List -->
                                        <template x-for="item in files" :key="item.id || item.nama_file">
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-5 bg-white border border-gray-100 rounded-xl hover:border-[#82C17D]/40 hover:bg-green-50/30 transition-all group shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                                                <div class="flex items-start gap-4">
                                                    <div class="mt-1">
                                                        <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <span class="text-base font-bold text-gray-800 group-hover:text-[#82C17D] transition-colors" x-text="getCleanName(item)"></span>
                                                        <div class="flex flex-wrap items-center gap-x-3 gap-y-2 mt-2 text-xs text-gray-500 font-medium">
                                                            <span class="bg-gray-100 px-2 py-1 rounded text-gray-600" x-text="getNoLaporan(item.id)"></span>
                                                            <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> <span x-text="getClientName(item)"></span></span>
                                                            <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> <span x-text="formatDate(item.tanggal_mulai)"></span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a :href="`/storage/${getPath(item)}`" target="_blank" class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-[#82C17D] hover:bg-[#82C17D] hover:text-white text-gray-700 rounded-xl text-sm font-bold transition-colors shrink-0 shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                                    Unduh PDF
                                                </a>
                                            </div>
                                        </template>

                                        <!-- Download ZIP Button -->
                                        <div x-show="loaded && files.length > 0" class="flex justify-end pt-2 gap-3">
                                            <!-- Tombol Download Rekap Excel/CSV (Baru) -->
                                            <a :href="`/laporan/tahunan/download-rekap/{{ $y->tahun }}`"
                                                class="bg-[#82C17D] hover:bg-[#6ba867] text-white px-6 py-2.5 rounded-full text-sm font-bold shadow-md transition-all flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                                Unduh Laporan {{ $y->tahun }}
                                            </a>

                                            <!-- Tombol Download ZIP (Lama) -->
                                            <a :href="`/laporan/tahunan/download-zip/{{ $y->tahun }}`"
                                                class="bg-white border-2 border-[#82C17D] text-[#82C17D] hover:bg-green-50 px-6 py-2.5 rounded-full text-sm font-bold shadow-sm transition-all flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                                Unduh Semua (ZIP)
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="flex-grow flex flex-col items-center justify-center text-center py-20">
                                <p class="text-gray-500 font-medium text-lg">Belum ada Laporan</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>