<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <h1 class="mt-8 text-3xl font-bold text-gray-800 mb-8 font-poppins text-[32px]">Penilaian Properti</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1 space-y-6">
                    <!-- Dokumen -->
                    <a href="{{ route('properti.dokumen') }}" class="block group">
                        <div
                            class="bg-white p-8 rounded-[35px] shadow-[0_20px_40px_rgba(0,0,0,0.06)]
                                hover:shadow-[0_20px_40px_rgba(0,0,0,0.12)]
                                transition-all cursor-pointer border {{ request()->routeIs('properti.dokumen') ? 'border-[#82C17D] ring-1 ring-[#82C17D] bg-green-50/30' : 'border-gray-50' }}">
                            <div class="flex items-center space-x-4">
                                <div class="bg-[#82C17D] p-4 rounded-[22px] text-white shadow-lg
                                        group-hover:scale-105 transition-transform">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
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
                        <div
                            class="bg-white p-8 rounded-[35px] shadow-[0_20px_40px_rgba(0,0,0,0.06)]
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
                        <div
                            class="bg-white p-8 rounded-[35px] shadow-[0_20px_40px_rgba(0,0,0,0.06)]
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

                <div class="lg:col-span-2 bg-white p-8 rounded-[40px] shadow-[0_20px_40px_rgba(0,0,0,0.04)]">
                    <h3 class="text-xl font-bold mb-6">Terbaru</h3>
                    <div class="overflow-x-auto overflow-y-auto max-h-[400px] pr-2">
                        <div class="space-y-3">
                            @if(isset($projects))
                                @forelse($projects as $project)
                                    @php
                                        $nilaiStatus = 'belum dinilai';
                                        if ($project->nilai) {
                                            $nilaiStatus = $project->nilai->status_penilaian?->value ?? 'belum dinilai';
                                        }
                                        $statusColor = 'bg-red-100 text-red-700';
                                        if ($nilaiStatus === 'sedang dinilai') $statusColor = 'bg-yellow-100 text-yellow-700';
                                        elseif ($nilaiStatus === 'sudah dinilai') $statusColor = 'bg-green-100 text-green-700';
                                    @endphp
                                    <div class="flex items-center justify-between p-4 rounded-2xl border border-gray-100 hover:shadow-md hover:border-[#82C17D]/30 transition bg-white group cursor-pointer"
                                        onclick="openNilaiModal({{ $project->id }}, {{ Js::from($project->nama_project) }}, {{ Js::from($project->deskripsi) }}, {{ Js::from($project->contact_person) }})">
                                        
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-xl bg-gray-50 group-hover:bg-green-50 flex items-center justify-center text-gray-400 group-hover:text-[#82C17D] transition hidden md:flex">
                                                <span class="font-bold text-sm">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-800 text-sm mb-0.5 capitalize">{{ $project->nama_project ?? '-' }}</h4>
                                                <p class="text-xs text-gray-500 font-medium">Jam: {{ optional($project->created_at)->format('H.i') ?? '-' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider {{ $statusColor }}">
                                                {{ strtoupper(str_replace('_', ' ', $nilaiStatus)) }}
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="flex flex-col items-center justify-center py-10 px-4 text-center bg-gray-50 rounded-2xl border border-gray-100 border-dashed">
                                        <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        <p class="text-sm text-gray-500">Belum ada project.</p>
                                    </div>
                                @endforelse
                            @else
                                <div class="flex flex-col items-center justify-center py-10 px-4 text-center bg-red-50 rounded-2xl border border-red-100 border-dashed">
                                    <p class="text-sm text-red-500 font-bold">Error: Data project tidak ditemukan.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nilai Properti (Read-Only for Client) -->
    <div id="nilaiModal"
        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-[30px] shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-8">
                <!-- Modal Header -->
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Nilai Properti</h2>

                <!-- Project Info Section -->
                <div class="bg-gray-50 p-6 rounded-[20px] mb-6 border border-gray-200">
                    <div class="mb-4">
                        <label class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Nama Project</label>
                        <p id="projectName" class="text-lg font-bold text-gray-800 mt-1">-</p>
                    </div>
                    <div class="mb-4">
                        <label class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Deskripsi</label>
                        <p id="projectDesc" class="text-gray-700 mt-1">-</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Contact
                            Person</label>
                        <p id="projectContact" class="text-gray-700 mt-1">-</p>
                    </div>
                </div>

                <!-- Form Section (Read-Only) -->
                <form id="nilaiForm" class="space-y-5">
                    <input type="hidden" id="projectId" name="project_id">

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Status Penilaian</label>
                        <div class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                            <p id="statusPenilaian" class="text-gray-700 py-1">-</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Nilai Pasar Final</label>
                        <div class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                            <p id="nilaiPasarFinal" class="text-gray-700 py-1">-</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Nilai Tanah</label>
                        <div class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                            <p id="nilaiTanah" class="text-gray-700 py-1">-</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Nilai Indikasi Pasar</label>
                        <div class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                            <p id="nilaiIndikasiPasar" class="text-gray-700 py-1">-</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Nilai Indikasi Biaya</label>
                        <div class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                            <p id="nilaiIndikasiBiaya" class="text-gray-700 py-1">-</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Nilai Likuidasi</label>
                        <div class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                            <p id="nilaiLikuidasi" class="text-gray-700 py-1">-</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Nilai Bangunan</label>
                        <div class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                            <p id="nilaiBangunan" class="text-gray-700 py-1">-</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Nilai Per m² Tanah</label>
                        <div class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                            <p id="nilaiPerM2Tanah" class="text-gray-700 py-1">-</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Nilai Per m² Bangunan</label>
                        <div class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                            <p id="nilaiPerM2Bangunan" class="text-gray-700 py-1">-</p>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex gap-3 mt-8 pt-6 border-t border-gray-200">
                        <button type="button" onclick="closeNilaiModal()"
                            class="w-full px-4 py-3 bg-[#82C17D] text-white font-semibold rounded-lg hover:bg-[#6fa86a] transition">
                            Tutup
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Format number with Rp prefix and thousands separator (.)
        function formatNumberDisplay(value) {
            if (!value || value === 0 || value === '') {
                return '-';
            }
            // Convert to string and remove non-digits
            const cleanValue = value.toString().replace(/\D/g, '');
            // Add . separator every 3 digits from the right
            const formatted = cleanValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return 'Rp ' + formatted;
        }

        function openNilaiModal(projectId, projectName, projectDesc, projectContact) {
            document.getElementById('projectId').value = projectId;
            document.getElementById('projectName').textContent = projectName;
            document.getElementById('projectDesc').textContent = projectDesc;
            document.getElementById('projectContact').textContent = projectContact;

            document.getElementById('nilaiModal').classList.remove('hidden');

            // Fetch existing nilai data
            fetchNilaiData(projectId);
        }

        function closeNilaiModal() {
            document.getElementById('nilaiModal').classList.add('hidden');
        }

        function fetchNilaiData(projectId) {
            fetch(`/properti/nilai/${projectId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        document.getElementById('statusPenilaian').textContent = data.status_penilaian ? data.status_penilaian.replace('_', ' ').charAt(0).toUpperCase() + data.status_penilaian.slice(1).replace('_', ' ') : '-';
                        document.getElementById('nilaiPasarFinal').textContent = formatNumberDisplay(data.nilai_pasar_final);
                        document.getElementById('nilaiTanah').textContent = formatNumberDisplay(data.nilai_tanah);
                        document.getElementById('nilaiIndikasiPasar').textContent = formatNumberDisplay(data.nilai_indikasi_dari_pasar);
                        document.getElementById('nilaiIndikasiBiaya').textContent = formatNumberDisplay(data.nilai_indikasi_dari_biaya);
                        document.getElementById('nilaiLikuidasi').textContent = formatNumberDisplay(data.nilai_likuidasi);
                        document.getElementById('nilaiBangunan').textContent = formatNumberDisplay(data.nilai_bangunan);
                        document.getElementById('nilaiPerM2Tanah').textContent = formatNumberDisplay(data.nilai_per_m2_tanah);
                        document.getElementById('nilaiPerM2Bangunan').textContent = formatNumberDisplay(data.nilai_per_m2_bangunan);
                    } else {
                        document.getElementById('statusPenilaian').textContent = 'Belum Dinilai';
                        document.getElementById('nilaiPasarFinal').textContent = '-';
                        document.getElementById('nilaiTanah').textContent = '-';
                        document.getElementById('nilaiIndikasiPasar').textContent = '-';
                        document.getElementById('nilaiIndikasiBiaya').textContent = '-';
                        document.getElementById('nilaiLikuidasi').textContent = '-';
                        document.getElementById('nilaiBangunan').textContent = '-';
                        document.getElementById('nilaiPerM2Tanah').textContent = '-';
                        document.getElementById('nilaiPerM2Bangunan').textContent = '-';
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Close modal when clicking outside of it
        document.getElementById('nilaiModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeNilaiModal();
            }
        });
    </script>
</x-app-layout>