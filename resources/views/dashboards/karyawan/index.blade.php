<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <h1 class="mt-8 text-3xl font-bold text-gray-800 mb-8 font-poppins text-[32px]">Selamat Datang,
                {{ Auth::user()->name }}!
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 text-[15px]">
                <a href="{{ route('properti.karyawan') }}" class="group">
                    <div
                        class="bg-white p-8 rounded-[35px] shadow-[0_20px_40px_rgba(0,0,0,0.06)] flex items-center space-x-6 border border-gray-50 group-hover:shadow-[0_20px_40px_rgba(0,0,0,0.12)] transition-all cursor-pointer">
                        <div
                            class="bg-[#82C17D] p-3 rounded-[22px] text-white shadow-lg group-hover:scale-105 transition-transform">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Properti</h3>
                            <p class="text-gray-400 font-medium">{{ $stats['properti_count'] ?? 0 }} Project sedang
                                dikelola</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('laporan.project') }}" class="group">
                    <div
                        class="bg-white p-8 rounded-[35px] shadow-[0_20px_40px_rgba(0,0,0,0.06)] flex items-center space-x-6 border border-gray-50 group-hover:shadow-[0_20px_40px_rgba(0,0,0,0.12)] transition-all cursor-pointer">
                        <div
                            class="bg-[#82C17D] p-3 rounded-[22px] text-white shadow-lg group-hover:scale-105 transition-transform">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Laporan</h3>
                            <p class="text-gray-400 font-medium">{{ $stats['laporan_count'] ?? 0 }} Laporan harus
                                diselesaikan</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('chats.index') }}" class="group">
                    <div
                        class="bg-white p-8 rounded-[35px] shadow-[0_20px_40px_rgba(0,0,0,0.06)] flex items-center space-x-6 border border-gray-50 group-hover:shadow-[0_20px_40px_rgba(0,0,0,0.12)] transition-all cursor-pointer">
                        <div
                            class="bg-[#82C17D] p-3 rounded-[22px] text-white shadow-lg group-hover:scale-105 transition-transform">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Obrolan</h3>
                            <p class="text-gray-400 font-medium">{{ $stats['pesan_count'] ?? 0 }} pesan masuk</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white p-8 rounded-[40px] shadow-[0_20px_40px_rgba(0,0,0,0.04)]">
                    <h3 class="text-xl font-bold mb-6">Daftar Tugas</h3>
                    <div class="overflow-x-auto overflow-y-auto max-h-[400px] pr-2">
                        <table class="w-full text-left">

                                @forelse($recentProjects as $index => $project)
                                    @php
                                        // 1. Status Dokumen
                                        $dokStatus = 'Belum Lengkap';
                                        $dokColor = 'bg-gray-100 text-gray-600';
                                        if ($project->documents->count() > 0) {
                                            $allDocVer = $project->documents->every(fn($d) => strtolower($d->status) === 'verified');
                                            $hasDocRej = $project->documents->some(fn($d) => strtolower($d->status) === 'rejected');
                                            if ($allDocVer) { $dokStatus = 'Verified'; $dokColor = 'bg-green-100 text-green-800'; }
                                            elseif ($hasDocRej) { $dokStatus = 'Rejected'; $dokColor = 'bg-red-100 text-red-800'; }
                                            else { $dokStatus = 'Pending'; $dokColor = 'bg-yellow-100 text-yellow-800'; }
                                        }

                                        // 2. Status Fisik
                                        $fisikStatus = 'Belum Disurvey';
                                        $fisikColor = 'bg-gray-100 text-gray-600';
                                        if ($project->physicalElements->count() > 0) {
                                            $allFisVer = $project->physicalElements->every(fn($e) => strtolower($e->status) === 'verified' || strtolower($e->status) === 'selesai');
                                            $hasFisRej = $project->physicalElements->some(fn($e) => strtolower($e->status) === 'rejected');
                                            if ($allFisVer) { $fisikStatus = 'Verified'; $fisikColor = 'bg-green-100 text-green-800'; }
                                            elseif ($hasFisRej) { $fisikStatus = 'Rejected'; $fisikColor = 'bg-red-100 text-red-800'; }
                                            else { $fisikStatus = 'Pending'; $fisikColor = 'bg-yellow-100 text-yellow-800'; }
                                        }

                                        // 3. Status Penilaian
                                        $nilStatus = 'belum dinilai';
                                        if ($project->nilai) {
                                            $nilObj = $project->nilai->status_penilaian;
                                            $nilStatus = $nilObj instanceof \UnitEnum ? $nilObj->value : ($nilObj ?? 'belum dinilai');
                                        }
                                        $nilStatus = strtolower($nilStatus);
                                        $nilColor = 'bg-red-100 text-red-800';
                                        if ($nilStatus === 'sedang dinilai') $nilColor = 'bg-yellow-100 text-yellow-800';
                                        if ($nilStatus === 'sudah dinilai') $nilColor = 'bg-green-100 text-green-800';
                                    @endphp
                                    <tr class="flex flex-col md:table-row border-b border-gray-100 last:border-0 hover:bg-gray-50 transition cursor-pointer group p-4 md:p-0" onclick="toggleRow('row-{{ $project->id }}', 'icon-{{ $project->id }}')">
                                        <td class="hidden md:table-cell py-4 font-medium text-gray-400 text-center w-12">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                        <td class="block md:table-cell py-2 md:py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="bg-gray-50 p-2 rounded-lg text-gray-400 group-hover:text-[#82C17D] group-hover:bg-green-50 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                                    </svg>
                                                </div>
                                                <span class="font-bold text-gray-800 capitalize text-[15px]">{{ $project->nama_project ?? ($project->name ?? 'Project') }}</span>
                                            </div>
                                        </td>
                                        <td class="block md:table-cell py-2 md:py-4 md:pl-0 pl-[52px]">
                                            <x-status-badge :status="$project->status ?? 'pending'" />
                                        </td>
                                        <td class="hidden md:table-cell py-2 md:py-4 text-center">
                                            <svg id="icon-{{ $project->id }}" class="w-5 h-5 text-gray-400 transition-transform duration-200 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </td>
                                        <td class="block md:hidden py-2 md:py-4 md:pl-0 pl-[52px] mt-2">
                                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1">Ketuk untuk rincian <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></span>
                                        </td>
                                    </tr>
                                    <tr id="row-{{ $project->id }}" class="hidden bg-gray-50/50">
                                        <td colspan="4" class="block md:table-cell p-0 border-b border-gray-100">
                                            <div class="px-6 py-5 grid grid-cols-1 md:grid-cols-3 gap-4 border-l-4 border-[#82C17D]">
                                                <!-- Dokumen Card -->
                                                <a href="{{ route('properti.dokumen') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md hover:-translate-y-1 transition block cursor-pointer">
                                                    <div>
                                                        <div class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Dokumen Verifikasi</div>
                                                        <div class="font-bold text-gray-800 mb-3">{{ $project->documents->count() }} <span class="font-medium text-gray-400 text-sm">File</span></div>
                                                    </div>
                                                    <div><span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $dokColor }} uppercase tracking-wider">{{ $dokStatus }}</span></div>
                                                </a>
                                                <!-- Fisik Card -->
                                                <a href="{{ route('survey.verification.page', $project->id) }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md hover:-translate-y-1 transition block cursor-pointer">
                                                    <div>
                                                        <div class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Fisik & Survey</div>
                                                        <div class="font-bold text-gray-800 mb-3">{{ $project->physicalElements->count() }} <span class="font-medium text-gray-400 text-sm">Titik Lokasi</span></div>
                                                    </div>
                                                    <div><span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $fisikColor }} uppercase tracking-wider">{{ $fisikStatus }}</span></div>
                                                </a>
                                                <!-- Penilaian Card -->
                                                <a href="{{ route('properti.penilaian') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md hover:-translate-y-1 transition block cursor-pointer">
                                                    <div>
                                                        <div class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Penilaian Akhir</div>
                                                        <div class="font-bold text-gray-800 mb-3">{{ $project->nilai ? 'Tersedia' : 'Kosong' }} <span class="font-medium text-gray-400 text-sm">Data</span></div>
                                                    </div>
                                                    <div><span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $nilColor }} uppercase tracking-wider">{{ str_replace('_', ' ', $nilStatus) }}</span></div>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="block md:table-row">
                                        <td colspan="4" class="block md:table-cell p-4 md:p-0">
                                            <div class="flex flex-col items-center justify-center py-16 px-4 text-center bg-gray-50/50 rounded-[24px] border-2 border-dashed border-gray-200 my-4 md:my-8">
                                                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-sm mb-6 relative">
                                                    <div class="absolute inset-0 bg-[#82C17D]/10 rounded-full animate-pulse"></div>
                                                    <svg class="w-12 h-12 text-[#82C17D] relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                                    </svg>
                                                </div>
                                                <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">Kerja Bagus! Semuanya Selesai.</h3>
                                                <p class="text-gray-500 max-w-sm mx-auto text-sm md:text-base leading-relaxed">Saat ini belum ada tugas baru atau project yang perlu diproses. Bersantailah sejenak!</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white p-8 rounded-[28px] shadow-[0_18px_30px_rgba(0,0,0,0.04)] relative overflow-hidden">
                        <!-- Decorative background element -->
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-green-50 to-blue-50 rounded-full blur-2xl opacity-70"></div>
                        
                        @php
                            $notifications = auth()->user()->unreadNotifications;
                        @endphp
                        
                        <div class="flex items-center justify-between mb-6 relative z-10">
                            <h3 class="text-xl font-bold text-gray-800">Notifikasi</h3>
                            @if($notifications->count() > 0)
                                <span class="bg-red-50 text-red-500 text-xs font-bold px-2.5 py-1 rounded-full">{{ $notifications->count() }} Baru</span>
                            @endif
                        </div>
                        
                        <div class="space-y-2 relative z-10">
                            @forelse($notifications->take(5) as $notification)
                                <div class="group flex items-start gap-3 p-3 -mx-3 rounded-2xl hover:bg-gray-50 transition-colors cursor-pointer border border-transparent hover:border-gray-100 relative">
                                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-[#82C17D] rounded-r-full"></div>
                                    
                                    @php
                                        $type = $notification->data['type'] ?? 'info';
                                        $bgColor = $type == 'success' ? 'bg-green-50 text-green-500' : ($type == 'error' ? 'bg-red-50 text-red-500' : 'bg-blue-50 text-blue-500');
                                    @endphp
                                    
                                    <div class="{{ $bgColor }} p-2.5 rounded-full shrink-0 shadow-sm group-hover:scale-110 transition-transform">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-800 font-medium leading-snug">{!! $notification->data['message'] ?? 'Notifikasi baru' !!}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="group flex items-start gap-3 p-3 -mx-3 rounded-2xl hover:bg-gray-50 transition-colors cursor-pointer border border-transparent hover:border-gray-100 opacity-60 hover:opacity-100">
                                    <div class="bg-gray-100 p-2.5 rounded-full text-gray-500 shrink-0 shadow-sm group-hover:scale-110 transition-transform">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-800 font-medium leading-snug">Tidak ada pesan atau notifikasi baru.</p>
                                        <p class="text-xs text-gray-400 mt-1">Saat ini</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        
                        @if($notifications->count() > 0)
                            <button onclick="markAllNotificationsAsRead()" class="w-full mt-4 py-2.5 rounded-xl text-xs font-bold text-[#82C17D] hover:bg-green-50 transition-colors uppercase tracking-wider border border-green-100">
                                Tandai Semua Dibaca
                            </button>
                        @endif
                    </div>

                    <div class="bg-white p-8 rounded-[28px] shadow-[0_18px_30px_rgba(0,0,0,0.04)]">
                        <h3 class="text-xl font-bold mb-4">Project Terbaru</h3>
                        <div class="space-y-4 text-sm overflow-y-auto max-h-[300px] pr-2 custom-scrollbar">
                            @forelse($recentProjects as $project)
                                <div class="flex items-start gap-3 border-b border-gray-50 pb-3 last:border-0 hover:bg-gray-50 transition p-2 rounded-lg -mx-2">
                                    <div class="bg-green-50 p-2 rounded-full text-[#82C17D] shrink-0 mt-0.5 shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $project->client->name ?? 'User' }}</p>
                                        <p class="text-xs text-gray-400 capitalize truncate mt-0.5">Project {{ $project->nama_project ?? $project->name }}</p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="block text-xs font-bold text-gray-400">{{ $project->created_at?->format('d M') ?? '--' }}</span>
                                        <span class="block text-[10px] text-gray-300 mt-0.5">{{ $project->created_at?->format('H.i') ?? '--.--' }}</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-400 italic text-center py-4">Belum ada project terbaru.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Expandable Row -->
    <script>
        function toggleRow(rowId, iconId) {
            const row = document.getElementById(rowId);
            const icon = document.getElementById(iconId);
            
            if (row.classList.contains('hidden')) {
                row.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                row.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</x-app-layout>

<script>
    function markAllNotificationsAsRead() {
        fetch('{{ route('notifications.markAllAsRead') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(res => res.json()).then(data => {
            if(data.success) {
                window.location.reload();
            }
        });
    }
</script>