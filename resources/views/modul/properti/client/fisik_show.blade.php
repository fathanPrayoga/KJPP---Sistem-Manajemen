<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">
        <div class="max-w-5xl mx-auto px-6 py-8">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-800 font-poppins text-[32px]">Detail Fisik Properti</h1>
                <a href="{{ route('properti.fisik') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition shadow-sm">
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>

            <!-- Project Summary Card -->
            <div class="bg-white p-8 rounded-[24px] shadow-[0_10px_30px_rgba(0,0,0,0.04)] mb-8 border border-gray-100">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b border-gray-100 pb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-1 capitalize">{{ $project->nama_project }}</h2>
                        <p class="text-sm text-gray-500 font-medium">Data fisik dan hasil pantauan lapangan</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <span class="px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider bg-gray-100 text-gray-700">
                            Status: {{ $project->status ?? 'Pending' }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Proyek</h3>
                        <p class="text-gray-700 text-sm leading-relaxed">{{ $project->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Lokasi Koordinat</h3>
                        @if($project->latitude && $project->longitude)
                            <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-xl border border-gray-100">
                                <div class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-mono">{{ $project->latitude }}, {{ $project->longitude }}</p>
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $project->latitude }},{{ $project->longitude }}" target="_blank" class="text-sm font-semibold text-blue-600 hover:text-blue-700 hover:underline">Buka di Google Maps</a>
                                </div>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 italic bg-gray-50 p-3 rounded-xl border border-gray-100">Lokasi belum ditentukan oleh surveyor.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Physical Elements List -->
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-[#82C17D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Hasil Pemeriksaan Lapangan
            </h2>

            <div class="space-y-6">
                @forelse($project->physicalElements as $element)
                    <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row">
                        <div class="md:w-1/3 h-48 md:h-auto bg-gray-100 flex-shrink-0 relative group">
                            @if($element->image_path)
                                <img src="{{ asset('storage/' . $element->image_path) }}" alt="{{ $element->name }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <a href="{{ asset('storage/' . $element->image_path) }}" target="_blank" class="px-4 py-2 bg-white/20 backdrop-blur-md rounded-full text-white text-sm font-semibold border border-white/40 hover:bg-white/30 transition">Lihat Penuh</a>
                                </div>
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm font-medium">Tidak ada foto</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold text-gray-800 capitalize">{{ $element->name }}</h3>
                                    @php
                                        $elStatus = strtolower($element->status ?? 'pending');
                                        $elColor = 'bg-yellow-50 text-yellow-700 border-yellow-200';
                                        if($elStatus == 'verified' || $elStatus == 'valid') $elColor = 'bg-green-50 text-green-700 border-green-200';
                                        if($elStatus == 'rejected') $elColor = 'bg-red-50 text-red-700 border-red-200';
                                    @endphp
                                    <span class="text-[10px] uppercase font-bold tracking-wider px-2.5 py-1 rounded-full border {{ $elColor }}">
                                        {{ $element->status ?? 'Pending' }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">{{ $element->description ?? 'Tidak ada deskripsi rinci.' }}</p>
                            </div>
                            
                            @if($element->notes)
                                <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-4 mt-4">
                                    <h4 class="text-xs font-bold text-blue-800 uppercase tracking-wider mb-1 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Catatan Penilai
                                    </h4>
                                    <p class="text-sm text-blue-700">{{ $element->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-[24px] shadow-[0_10px_30px_rgba(0,0,0,0.04)] border border-gray-100 p-12 text-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Belum Ada Data Survei</h3>
                        <p class="text-gray-500 max-w-md mx-auto text-sm">Tim kami belum mengunggah data pemeriksaan fisik lapangan untuk proyek ini. Silakan cek kembali nanti atau hubungi kami via Chat.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
