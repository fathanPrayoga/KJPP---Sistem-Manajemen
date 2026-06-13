<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <h1 class="mt-8 text-3xl font-bold text-gray-800 mb-8 font-poppins text-[32px]">Laporan</h1>

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
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Daftar Project</h3>
                </div>

                    @if($projects->isEmpty())
                        <div class="flex flex-col items-center justify-center py-10 px-4 text-center bg-gray-50 rounded-2xl border border-gray-100 border-dashed">
                            <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            <p class="text-sm text-gray-500">Belum ada project.</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($projects as $i => $project)
                                @php
                                    $statusBadge = strtolower($project->status ?? '');
                                    $statusColor = 'bg-gray-100 text-gray-700';
                                    $canGeneratePdf = false;
                                    if ($statusBadge === 'pending' || $statusBadge === 'menunggu') $statusColor = 'bg-yellow-100 text-yellow-700';
                                    elseif ($statusBadge === 'selesai' || $statusBadge === 'approved' || $statusBadge === 'verified') {
                                        $statusColor = 'bg-green-100 text-green-700';
                                        $canGeneratePdf = true;
                                    }
                                    elseif ($statusBadge === 'rejected' || $statusBadge === 'ditolak') $statusColor = 'bg-red-100 text-red-700';
                                @endphp
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-gray-200 hover:bg-gray-50/50 transition bg-white group gap-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 text-sm font-bold">
                                            {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800 text-sm mb-0.5 capitalize">{{ $project->nama_project }}</h4>
                                            <p class="text-xs text-gray-500 font-medium">Diupdate: {{ $project->updated_at->format('d M Y, H.i') }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center shrink-0 ml-auto">
                                        <div class="w-[110px] min-w-[110px] shrink-0 flex justify-center pr-3">
                                            <span class="px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $statusColor }}">
                                                {{ $project->status ?? '-' }}
                                            </span>
                                        </div>
                                        
                                        <div class="flex items-center justify-end gap-2 border-l border-gray-200 pl-5 w-[170px] min-w-[170px] shrink-0">
                                            @if($canGeneratePdf)
                                                <a href="{{ route('laporan.project.pdf', $project->id) }}" target="_blank"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 border-2 border-[#82C17D] text-[#82C17D] hover:bg-[#82C17D] hover:text-white rounded-lg text-xs font-bold transition-colors"
                                                    title="Generate & Download PDF">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                                                    PDF
                                                </a>
                                            @endif
                                            
                                            <button onclick="openModal({{ $project->id }})"
                                                class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-colors" title="Upload Laporan Manual">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                            </button>
                                            <button onclick="confirmDelete({{ $project->id }})"
                                                class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-colors" title="Hapus Laporan">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                            <form id="delete-form-{{ $project->id }}" action="{{ route('laporan.project.delete', $project->id) }}" method="POST" class="hidden">
                                                @csrf @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div id="laporanModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl mx-4">

            <!-- HEADER -->
            <div class="bg-[#82C17D] px-6 py-4 flex justify-between text-white">
                <h3 id="modalTitle" class="font-bold text-lg">Laporan Project</h3>
                <button onclick="closeModal()">✖</button>
            </div>

            <!-- BODY -->
            <form id="uploadForm" method="POST" action="{{ route('laporan.upload') }}" enctype="multipart/form-data"
                class="p-8 space-y-5">
                @csrf

                <input type="hidden" id="project_id" name="project_id">

                <div class="space-y-1">
                    <label class="text-sm font-semibold">Nama Project</label>
                    <input id="projectName" type="text" readonly class="w-full px-4 py-2 bg-gray-100 border rounded-xl">
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-semibold">Asal Instansi</label>
                    <input id="asal_instansi" name="asal_instansi" type="text"
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-[#82C17D]">
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-semibold">Tanggal Mulai</label>
                    <input id="tanggal_mulai" name="tanggal_mulai" type="date"
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-[#82C17D]">
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-semibold">Dokumen (PDF)</label>
                    <input type="file" name="file" accept="application/pdf" class="w-full text-sm">
                </div>

                <button type="submit" class="w-full bg-[#82C17D] hover:bg-[#6ba867]
                           text-white font-bold py-3 rounded-full">
                    Simpan
                </button>
            </form>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Variabel untuk menyimpan data asli
        let originalData = {};

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('uploadForm');
            const asalInput = document.getElementById('asal_instansi');
            const tanggalInput = document.getElementById('tanggal_mulai');
            const fileInput = document.querySelector('input[name="file"]');

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const asalVal = asalInput.value;
                const tanggalVal = tanggalInput.value;
                const fileCount = fileInput.files.length;

                // Cek apakah ada perubahan
                if (
                    asalVal === (originalData.asal_instansi || '') &&
                    tanggalVal === (originalData.tanggal_mulai || '') &&
                    fileCount === 0
                ) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Tidak Ada Perubahan',
                        text: 'Silakan ubah data atau upload file terlebih dahulu.',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Simpan Laporan?',
                    text: 'Pastikan data yang diisi sudah benar.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#82C17D'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        function openModal(id) {
            const modal = document.getElementById('laporanModal');
            const projectIdInput = document.getElementById('project_id');
            const projectNameInput = document.getElementById('projectName');
            const asalInput = document.getElementById('asal_instansi');
            const tanggalInput = document.getElementById('tanggal_mulai');

            fetch(`/laporan/project/${id}`)
                .then(res => res.json())
                .then(data => {
                    modal.classList.remove('hidden');

                    projectIdInput.value = data.id;
                    projectNameInput.value = data.nama_project;
                    asalInput.value = data.asal_instansi ?? '';
                    tanggalInput.value = data.tanggal_mulai ?? '';

                    // Simpan data awal untuk perbandingan di fungsi submit
                    originalData = {
                        asal_instansi: data.asal_instansi ?? '',
                        tanggal_mulai: data.tanggal_mulai ?? ''
                    };

                    // Reset input file
                    document.querySelector('input[name="file"]').value = '';
                })
                .catch(err => {
                    console.error('Error fetching data:', err);
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal mengambil data project.' });
                });
        }

        function closeModal() {
            document.getElementById('laporanModal').classList.add('hidden');
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin hapus?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!'
            }).then(res => {
                if (res.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>