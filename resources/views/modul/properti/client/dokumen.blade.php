<x-app-layout>
    @php
        $activeMenu = 'dokumen';
    @endphp

    <div class="min-h-screen bg-gray-50 pb-12">

        <div class="max-w-7xl mx-auto px-6 py-8">

            <h1 class="mt-8 text-3xl font-bold text-gray-800 mb-8 font-poppins text-[32px]">
                Dokumen Properti
            </h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- ================= LEFT MENU ================= -->
                <div class="lg:col-span-1 space-y-6">

                    <!-- Dokumen -->
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

                <!-- ================= RIGHT CONTENT ================= -->
                <div class="lg:col-span-2 bg-white p-8 rounded-[40px] shadow-[0_20px_40px_rgba(0,0,0,0.04)]">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-800">
                            Daftar Dokumen
                        </h3>
                        <a href="{{ route('client.projects.create') }}"
                            class="bg-[#82C17D] hover:bg-[#6fa86a] text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-lg shadow-green-100 flex items-center gap-2">
                            <span>+ Tambah</span>
                        </a>
                    </div>

                    <div class="overflow-x-auto overflow-y-auto max-h-[400px] pr-2">
                        <table class="w-full text-left">
                            <thead class="sticky top-0 bg-white z-10">
                                <tr class="text-gray-400 text-sm border-b">
                                    <th class="pb-4 font-semibold w-12 text-center">No</th>
                                    <th class="pb-4 font-semibold">Nama Project</th>
                                    <th class="pb-4 font-semibold">Contract Date</th>
                                    <th class="pb-4 font-semibold">Dokumen</th>
                                    <th class="pb-4 font-semibold text-center">Status</th>
                                    <th class="pb-4 font-semibold text-right">Update Terakhir</th>
                                    <th class="pb-4 font-semibold text-right">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="text-sm">
                                @forelse ($projects as $index => $project)
                                    <tr class="border-b hover:bg-green-50/50 cursor-pointer transition" 
                                        onclick="openProjectModal(JSON.parse(this.dataset.project))"
                                        data-project="{{ json_encode([
                                            'nama' => $project->nama_project,
                                            'deskripsi' => $project->deskripsi,
                                            'kategori' => $project->kategori ?? 'Tidak ada kategori',
                                            'contract_date' => $project->contract_date->format('d M Y'),
                                            'contact' => $project->contact_person,
                                            'status' => strtolower($project->status ?? 'pending'),
                                            'notes' => $project->documents->first()?->notes ?? null,
                                            'documents' => $project->documents->map(fn($d) => [
                                                'nama' => $d->nama_file,
                                                'url' => asset($d->file_path),
                                                'size' => file_exists(public_path($d->file_path)) ? round(filesize(public_path($d->file_path)) / 1024) : 0,
                                                'kategori' => $d->kategori_dokumen ?? 'Lainnya'
                                            ])->toArray()
                                        ]) }}">
                                        <td class="py-4 font-semibold text-gray-500 text-center">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="py-4 font-bold text-gray-800 capitalize">
                                            {{ $project->nama_project }}
                                        </td>
                                        <td class="py-4 text-gray-600">
                                            {{ $project->contract_date->format('d M Y') }}
                                        </td>
                                        <td class="py-4 font-medium">
                                            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold border border-gray-200 shadow-sm">
                                                {{ $project->documents->count() }} File
                                            </span>
                                        </td>
                                        <td class="py-4 text-center">
                                            @php
                                                $status = strtolower($project->status ?? 'pending');
                                            @endphp
                                            @if($status === 'verified')
                                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Verified</span>
                                            @elseif($status === 'rejected')
                                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">Rejected</span>
                                            @else
                                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Pending</span>
                                            @endif
                                        </td>
                                        <td class="py-4 text-right text-gray-600 pr-2">
                                            {{ $project->updated_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="py-4 text-right" onclick="event.stopPropagation();">
                                            @php $status = strtolower($project->status ?? ''); @endphp
                                            @if($status === 'rejected')
                                                <a href="{{ route('client.projects.clientEdit', $project->id) }}" class="inline-block text-blue-500 hover:text-blue-700 transition p-2 bg-blue-50 hover:bg-blue-100 rounded-lg shadow-sm mr-1" title="Edit/Revisi Project">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </a>
                                            @endif
                                            @if(in_array($status, ['pending', 'menunggu', 'rejected']))
                                                <form action="{{ route('client.projects.destroy', $project->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan dan menghapus pengajuan project ini secara permanen?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 transition p-2 bg-red-50 hover:bg-red-100 rounded-lg shadow-sm" title="Batalkan & Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-16 text-center text-gray-400 italic">
                                            Belum ada data dokumen
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= MODAL (VANILLA JS) ================= -->
        <div id="projectModal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeProjectModal()"></div>

            <!-- Modal Card -->
            <div class="relative w-full max-w-xl rounded-3xl shadow-2xl bg-white overflow-hidden z-10">
                <!-- Header -->
                <div class="bg-[#82C17D] px-6 py-4 flex justify-between items-center">
                    <h3 class="text-white text-lg font-bold">
                        Detail Proyek
                    </h3>

                    <button onclick="closeProjectModal()" class="text-white text-2xl leading-none hover:text-green-100">
                        &times;
                    </button>
                </div>

                <!-- Content -->
                <div class="p-4 space-y-4 text-sm text-gray-700 max-h-[65vh] overflow-y-auto overflow-x-hidden">

                    <!-- Nama Proyek -->
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <p class="font-semibold text-gray-900">Nama Proyek</p>
                            <span id="modalKategori" class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wide"></span>
                        </div>
                        <p id="modalNama" class="break-all whitespace-pre-wrap max-w-full"></p>
                    </div>

                    <!-- Status & Catatan -->
                    <div id="modalStatusContainer" class="rounded-lg p-3 border">
                        <p class="font-bold text-sm mb-1" id="modalStatusTitle">Status</p>
                        <p id="modalStatusNotes" class="text-xs"></p>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <p class="font-semibold text-gray-900">Deskripsi</p>
                        <p id="modalDeskripsi" class="break-all whitespace-pre-wrap max-w-full leading-relaxed"></p>
                    </div>

                    <!-- Contract Date -->
                    <div>
                        <p class="font-semibold text-gray-900">Contract Date</p>
                        <p id="modalDate"></p>
                    </div>

                    <!-- Contact -->
                    <div>
                        <p class="font-semibold text-gray-900">Contact</p>
                        <p id="modalContact" class="break-all max-w-full"></p>
                    </div>

                    <!-- Dokumen -->
                    <div>
                        <p class="font-semibold text-gray-900 mb-3">Dokumen</p>

                        <div id="modalDocs" class="space-y-2">
                            <!-- JS akan mengisi daftar dokumen disini -->
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

    <!-- SCRIPT VANILLA JS UNTUK MODAL -->
    <script>
        function openProjectModal(project) {
            document.getElementById('modalNama').textContent = project.nama || '-';
            document.getElementById('modalKategori').textContent = project.kategori || 'Tidak ada kategori';
            document.getElementById('modalDeskripsi').textContent = project.deskripsi || '-';
            document.getElementById('modalDate').textContent = project.contract_date || '-';
            document.getElementById('modalContact').textContent = project.contact || '-';

            const statusContainer = document.getElementById('modalStatusContainer');
            const statusTitle = document.getElementById('modalStatusTitle');
            const statusNotes = document.getElementById('modalStatusNotes');
            
            statusContainer.classList.remove('bg-red-50', 'border-red-200', 'bg-yellow-50', 'border-yellow-200', 'bg-green-50', 'border-green-200');
            statusTitle.classList.remove('text-red-800', 'text-yellow-800', 'text-green-800');
            statusNotes.classList.remove('text-red-600', 'text-yellow-600', 'text-green-600');

            if (project.status === 'rejected') {
                statusContainer.classList.add('bg-red-50', 'border-red-200');
                statusTitle.textContent = 'Ditolak (Perlu Revisi)';
                statusTitle.classList.add('text-red-800');
                statusNotes.textContent = project.notes || 'Tidak ada catatan penolakan.';
                statusNotes.classList.add('text-red-600');
            } else if (project.status === 'verified') {
                statusContainer.classList.add('bg-green-50', 'border-green-200');
                statusTitle.textContent = 'Terverifikasi';
                statusTitle.classList.add('text-green-800');
                statusNotes.textContent = 'Dokumen telah diverifikasi dan disetujui.';
                statusNotes.classList.add('text-green-600');
            } else {
                statusContainer.classList.add('bg-yellow-50', 'border-yellow-200');
                statusTitle.textContent = 'Menunggu (Pending)';
                statusTitle.classList.add('text-yellow-800');
                statusNotes.textContent = 'Dokumen Anda sedang menunggu verifikasi dari Admin/Karyawan.';
                statusNotes.classList.add('text-yellow-600');
            }

            const docsContainer = document.getElementById('modalDocs');
            docsContainer.innerHTML = ''; // Kosongkan dulu

            if (!project.documents || project.documents.length === 0) {
                docsContainer.innerHTML = '<p class="text-gray-400 italic text-sm">Tidak ada dokumen</p>';
            } else {
                project.documents.forEach(doc => {
                    docsContainer.innerHTML += `
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gray-50 rounded-xl px-4 py-3 overflow-hidden">
                            <div class="flex flex-col min-w-0">
                                <span class="text-[10px] uppercase font-bold text-gray-500 tracking-wider mb-1">${doc.kategori || 'Lainnya'}</span>
                                <div class="flex items-center gap-2">
                                    <i class="fa fa-file-pdf text-red-500 shrink-0"></i>
                                    <a href="${doc.url}" target="_blank"
                                        class="text-green-600 font-medium hover:underline break-all">
                                        ${doc.nama || 'Dokumen'}
                                    </a>
                                </div>
                            </div>
                            <span class="text-xs font-semibold text-gray-400 shrink-0 bg-white px-2 py-1 rounded-md border border-gray-100">${doc.size} KB</span>
                        </div>
                    `;
                });
            }

            document.getElementById('projectModal').classList.remove('hidden');
        }

        function closeProjectModal() {
            document.getElementById('projectModal').classList.add('hidden');
        }
    </script>
</x-app-layout>