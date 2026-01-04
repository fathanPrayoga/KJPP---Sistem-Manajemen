<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <h1 class="mt-8 text-3xl font-bold text-gray-800 mb-8 font-poppins text-[32px]">Laporan</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1 space-y-6">
                    <a href="{{ route('laporan.project') }}" class="block">
                        <div
                            class="bg-white p-8 rounded-[35px] shadow-[0_20px_40px_rgba(0,0,0,0.06)] border border-gray-50 ring-2 ring-[#82C17D] ring-offset-2">
                            <div class="flex items-center space-x-4">
                                <div class="bg-[#82C17D] p-4 rounded-[22px] text-white shadow-lg">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5h6m2 0h1a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h1m2-2h6a2 2 0 012 2v2H7V5a2 2 0 012-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg">Project</h3>
                                    <p class="text-gray-400 text-sm">Laporan</p>
                                </div>
                            </div>
                        </div>
                    </a>


                </div>

                <div class="lg:col-span-2 bg-white p-8 rounded-3xl shadow">
                    <h3 class="text-xl font-bold mb-6">Status</h3>

                    @if($projects->isEmpty())
                        <div class="text-center text-gray-400 py-10">
                            Belum ada laporan project
                        </div>
                    @else
                        <table class="w-full text-sm">
                            <thead class="border-b text-gray-500">
                                <tr>
                                    <th class="py-2 text-left w-16">No</th>
                                    <th class="text-left">Laporan</th>
                                    <th class="text-right">Status</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $i => $project)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-4">{{ $i + 1 }}.</td>
                                        <td class="py-4 font-medium text-gray-800">Laporan {{ $project->nama_project }}</td>
                                        <td class="py-4 text-right">
                                            <x-status-badge :status="$project->status" />
                                        </td>
                                        <td class="py-4 text-right">
                                            @if($project->dokumen)
                                                <button
                                                    onclick="openDownloadModal('{{ $project->nama_project }}', '{{ asset('storage/' . $project->dokumen) }}')"
                                                    class="inline-flex items-center px-4 py-2 bg-[#82C17D] hover:bg-[#6ba867] text-white text-xs font-bold rounded-full transition shadow-sm">
                                                    Lihat
                                                </button>
                                            @else
                                                <span class="text-gray-400 text-xs italic">Tidak ada file</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Download Similar to Tahunan -->
    <div id="downloadModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white w-full max-w-md rounded-[25px] shadow-2xl overflow-hidden mx-4">

            <div class="bg-[#82C17D] px-6 py-4 flex justify-between items-center text-white">
                <h3 id="modalProjectTitle" class="font-bold text-lg">Laporan Project</h3>
                <button onclick="closeDownloadModal()" class="hover:rotate-90 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span id="modalFileName" class="text-[15px] text-gray-800 font-semibold">nama_file.pdf</span>
                    <a id="modalDownloadLink" href="#" target="_blank"
                        class="text-gray-400 hover:text-[#82C17D] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="p-6 pt-0 flex justify-end">
                <a id="btnDownloadFull" href="#" target="_blank"
                    class="bg-[#82C17D] hover:bg-[#6ba867] text-white px-8 py-2.5 rounded-full text-sm font-bold shadow-md transition-all">
                    Unduh File
                </a>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        function openDownloadModal(projectName, fileUrl) {
            const modal = document.getElementById('downloadModal');
            document.getElementById('modalProjectTitle').innerText = 'Laporan ' + projectName;
            document.getElementById('modalFileName').innerText = 'Laporan ' + projectName + '.pdf';
            document.getElementById('modalDownloadLink').href = fileUrl;
            document.getElementById('btnDownloadFull').href = fileUrl;

            modal.classList.remove('hidden');
        }

        function closeDownloadModal() {
            document.getElementById('downloadModal').classList.add('hidden');
        }
    </script>
</x-app-layout>