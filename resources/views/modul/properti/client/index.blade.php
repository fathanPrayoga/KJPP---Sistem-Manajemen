<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <h1 class="mt-8 text-3xl font-bold text-gray-800 mb-8 font-poppins text-[32px]">
                Properti Saya
            </h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- LEFT MENU -->
                <div class="lg:col-span-1 space-y-6">

                    <!-- Dokumen -->
                    <a href="{{ route('properti.dokumen') }}" class="block group">
                        <div class="bg-white p-8 rounded-[35px] shadow-[0_20px_40px_rgba(0,0,0,0.06)]
                                    hover:shadow-[0_20px_40px_rgba(0,0,0,0.12)]
                                    transition-all cursor-pointer border {{ request()->routeIs('properti.dokumen') ? 'border-[#82C17D] ring-1 ring-[#82C17D] bg-green-50/30' : 'border-gray-50' }}">
                            <div class="flex items-center space-x-4">
                                <div class="bg-[#82C17D] p-4 rounded-[22px] text-white shadow-lg
                                            group-hover:scale-105 transition-transform">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg">Dokumen</h3>
                                    <p class="text-gray-400 text-sm">Upload & Kelola Berkas</p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Fisik -->
                    <a href="{{ route('properti.fisik') }}" class="block group">
                        <div class="bg-white p-8 rounded-[35px] shadow-[0_20px_40px_rgba(0,0,0,0.06)]
                                    hover:shadow-[0_20px_40px_rgba(0,0,0,0.12)]
                                    transition-all cursor-pointer border {{ request()->routeIs('properti.fisik') ? 'border-[#82C17D] ring-1 ring-[#82C17D] bg-green-50/30' : 'border-gray-50' }}">
                            <div class="flex items-center space-x-4">
                                <div class="bg-[#82C17D] p-4 rounded-[22px] text-white shadow-lg
                                            group-hover:scale-105 transition-transform">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg">Fisik</h3>
                                    <p class="text-gray-400 text-sm">Status Objek Properti</p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Penilaian -->
                    <a href="{{ route('properti.penilaian') }}" class="block group">
                        <div class="bg-white p-8 rounded-[35px] shadow-[0_20px_40px_rgba(0,0,0,0.06)]
                                    hover:shadow-[0_20px_40px_rgba(0,0,0,0.12)]
                                    transition-all cursor-pointer border {{ request()->routeIs('properti.penilaian') ? 'border-[#82C17D] ring-1 ring-[#82C17D] bg-green-50/30' : 'border-gray-50' }}">
                            <div class="flex items-center space-x-4">
                                <div class="bg-[#82C17D] p-4 rounded-[22px] text-white shadow-lg
                                            group-hover:scale-105 transition-transform">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg">Penilaian</h3>
                                    <p class="text-gray-400 text-sm">Hasil & Review Penilaian</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- RIGHT CONTENT -->
                <div class="lg:col-span-2 bg-white p-8 rounded-[40px]
                            shadow-[0_20px_40px_rgba(0,0,0,0.04)] border border-gray-50">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-800">
                            Riwayat Project Terbaru
                        </h3>
                        <div class="flex items-center gap-3">
                            <!-- Status -->
                            <span class="text-xs bg-green-100 text-green-700 px-3 py-1
                                        rounded-full font-bold uppercase">
                                Aktif
                            </span>

                            <!-- Tambah Project -->
                                <a href="{{ route('client.projects.create') }}"
                                class="inline-flex items-center gap-2
                                        bg-[#82C17D] hover:bg-[#6cad67]
                                        text-white text-xs font-bold
                                        px-3 py-1 rounded-full
                                        transition shadow">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tambah
                                </a>

                        </div>
                    </div>

                    <div class="overflow-x-auto overflow-y-auto max-h-[400px] pr-2">
                        <div class="space-y-3">
                            @forelse ($projects as $project)
                                @php
                                    $statusBadge = strtolower($project->status ?? '');
                                    $statusColor = 'bg-gray-100 text-gray-700';
                                    if ($statusBadge === 'pending' || $statusBadge === 'menunggu') $statusColor = 'bg-yellow-100 text-yellow-700';
                                    elseif ($statusBadge === 'selesai' || $statusBadge === 'approved' || $statusBadge === 'verified') $statusColor = 'bg-green-100 text-green-700';
                                    elseif ($statusBadge === 'rejected' || $statusBadge === 'ditolak') $statusColor = 'bg-red-100 text-red-700';
                                @endphp
                                <div class="flex items-center justify-between p-4 rounded-2xl border border-gray-100 hover:shadow-md hover:border-[#82C17D]/30 transition bg-white group">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-gray-50 group-hover:bg-green-50 flex items-center justify-center text-gray-400 group-hover:text-[#82C17D] transition">
                                            <span class="font-bold text-sm">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800 text-sm mb-0.5 capitalize">{{ $project->nama_project }}</h4>
                                            <p class="text-xs text-gray-500 font-medium">Diupdate: {{ $project->updated_at->format('d M Y, H.i') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider {{ $statusColor }}">
                                            {{ $project->status ?? '-' }}
                                        </span>
                                        @if(strtolower($project->status ?? '') === 'pending' || strtolower($project->status ?? '') === 'menunggu')
                                            <form action="{{ route('client.projects.destroy', $project->id) }}" method="POST" class="inline-block" onsubmit="confirmDelete(event, this, 'Yakin ingin membatalkan dan menghapus project ini permanen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600 transition p-2 bg-red-50 hover:bg-red-100 rounded-lg shadow-sm" title="Hapus Project">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-10 px-4 text-center bg-gray-50 rounded-2xl border border-gray-100 border-dashed">
                                    <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    <p class="text-sm text-gray-500">Anda belum memiliki pengajuan project.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
