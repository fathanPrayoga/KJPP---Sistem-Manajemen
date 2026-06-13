<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <h1 class="mt-8 text-3xl font-bold text-gray-800 mb-8 font-poppins text-[32px]">Laporan</h1>

            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 min-h-[400px] flex flex-col">


                    @if($projects->isEmpty())
                        <div class="text-center text-gray-400 py-10">
                            Belum ada laporan project
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($projects as $i => $project)
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
                                            <x-status-badge :status="$project->status" />
                                        </div>
                                        
                                        <div class="flex items-center w-[130px] min-w-[130px] shrink-0 border-l border-gray-200 pl-5">
                                            @if($project->dokumen)
                                                <button onclick="openDownloadModal('{{ $project->nama_project }}', '{{ asset('storage/' . $project->dokumen) }}')"
                                                    class="p-1.5 text-gray-400 hover:text-[#82C17D] hover:bg-green-50 rounded-md transition-colors" title="Unduh/Lihat Dokumen">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                </button>
                                            @else
                                                <span class="text-xs text-gray-400 italic">Belum ada file</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
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