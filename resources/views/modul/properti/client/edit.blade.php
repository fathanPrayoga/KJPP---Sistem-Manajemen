<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <h1 class="mt-8 mb-8 text-[32px] font-poppins font-bold text-gray-800">
                Revisi Project
            </h1>

            <div class="bg-white p-8 rounded-[40px] shadow-[0_20px_40px_rgba(0,0,0,0.04)]">
                <form method="POST" action="{{ route('client.projects.clientUpdate', $project->id) }}" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    @if(strtolower($project->status) === 'rejected')
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Project Ditolak (Perlu Revisi)</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p><strong>Catatan:</strong> {{ $project->documents->first()?->notes ?? 'Tidak ada catatan penolakan spesifik.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Nama Project -->
                    <div>
                        <label class="block mb-2 font-medium text-gray-700">
                            Nama Project
                        </label>
                        <input type="text" name="nama_project" required value="{{ $project->nama_project }}"
                            class="w-full rounded-lg border-gray-300 focus:border-[#82C17D] focus:ring-[#82C17D]">
                    </div>

                    <!-- Contract Date -->
                    <div>
                        <label class="block mb-2 font-medium text-gray-700">
                            Contract Date
                        </label>
                        <input type="date" name="contract_date" required value="{{ $project->contract_date ? \Carbon\Carbon::parse($project->contract_date)->format('Y-m-d') : '' }}"
                            class="w-full rounded-lg border-gray-300 focus:border-[#82C17D] focus:ring-[#82C17D]">
                    </div>

                    <!-- Contact Person -->
                    <div>
                        <label class="block mb-2 font-medium text-gray-700">
                            Contact Person
                        </label>
                        <input type="text" name="contact_person" required value="{{ $project->contact_person }}"
                            class="w-full rounded-lg border-gray-300 focus:border-[#82C17D] focus:ring-[#82C17D]">
                    </div>

                    <!-- Kategori Project -->
                    <div>
                        <label class="block mb-2 font-medium text-gray-700">
                            Kategori Project
                        </label>
                        <select name="kategori" required
                            class="w-full rounded-lg border-gray-300 focus:border-[#82C17D] focus:ring-[#82C17D]">
                            <option value="" disabled>Pilih Kategori Project</option>
                            <option value="Contoh Kategori Project 1" {{ $project->kategori === 'Contoh Kategori Project 1' ? 'selected' : '' }}>Contoh Kategori Project 1</option>
                            <option value="Contoh Kategori Project 2" {{ $project->kategori === 'Contoh Kategori Project 2' ? 'selected' : '' }}>Contoh Kategori Project 2</option>
                            <option value="Contoh Kategori Project 3" {{ $project->kategori === 'Contoh Kategori Project 3' ? 'selected' : '' }}>Contoh Kategori Project 3</option>
                            <option value="Lainnya" {{ $project->kategori === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block mb-2 font-medium text-gray-700">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" rows="4"
                            class="w-full rounded-lg border-gray-300 focus:border-[#82C17D] focus:ring-[#82C17D]">{{ $project->deskripsi }}</textarea>
                    </div>

                    <!-- Dokumen Saat Ini (Histori) -->
                    @if($project->documents->count() > 0)
                    <div class="mb-6 bg-gray-50/50 p-4 rounded-xl border border-gray-100">
                        <label class="block mb-3 font-medium text-gray-700">
                            Dokumen Saat Ini (Riwayat)
                        </label>
                        <div class="space-y-2">
                            @foreach($project->documents as $doc)
                            <div class="flex items-center justify-between bg-white p-3 rounded-lg border border-gray-200 shadow-sm">
                                <div class="flex flex-col">
                                    <span class="text-[10px] uppercase font-bold text-gray-500 tracking-wider mb-1">{{ $doc->kategori_dokumen ?? 'Lainnya' }}</span>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                                        <a href="{{ asset($doc->file_path) }}" target="_blank" class="text-green-600 font-medium hover:underline text-sm">
                                            {{ $doc->nama_file }}
                                        </a>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold text-gray-400 bg-gray-50 px-2 py-1 rounded-md">{{ $doc->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Upload Dokumen -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="font-medium text-gray-700">
                                Upload Dokumen Revisi (Opsional) <span class="text-xs text-red-500 font-bold ml-1">(Wajib PDF, Maks. 5MB)</span>
                            </label>
                            <button type="button" id="addDocumentBtn"
                                class="text-sm text-green-600 hover:text-green-700 font-medium">
                                + Tambah Dokumen Lain
                            </button>
                        </div>
                        <p class="text-xs text-blue-600 font-semibold mb-3 bg-blue-50 p-2 rounded-md border border-blue-100">
                            ℹ️ Perhatian: Dokumen lama tidak akan dihapus dan akan disimpan sebagai riwayat (history). Dokumen baru yang Anda unggah akan ditambahkan ke dalam daftar dokumen project ini.
                        </p>

                        <div id="documentContainer" class="space-y-3">
                            <!-- Default 1 File Input -->
                            <div class="document-row flex flex-col sm:flex-row gap-3 items-start sm:items-center bg-gray-50 p-3 rounded-lg border border-gray-100 relative group">
                                <select name="document_categories[]" required
                                    class="w-full sm:w-1/3 rounded-lg border-gray-300 focus:border-[#82C17D] focus:ring-[#82C17D] text-sm">
                                    <option value="" disabled selected>Pilih Kategori Dokumen</option>
                                    <option value="Contoh Kategori Dokumen A">Contoh Kategori Dokumen A</option>
                                    <option value="Contoh Kategori Dokumen B">Contoh Kategori Dokumen B</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>

                                <input type="file" name="documents[]" accept="application/pdf" class="w-full sm:w-2/3 text-sm text-gray-600
                                           file:mr-4 file:rounded-full file:border-0
                                           file:bg-green-50 file:px-4 file:py-2
                                           file:text-green-700 hover:file:bg-green-100">

                                <button type="button"
                                    class="remove-doc-btn hidden absolute -right-2 -top-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    &times;
                                </button>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const container = document.getElementById('documentContainer');
                            const addBtn = document.getElementById('addDocumentBtn');

                            function updateRemoveButtons() {
                                const rows = container.querySelectorAll('.document-row');
                                rows.forEach(row => {
                                    const btn = row.querySelector('.remove-doc-btn');
                                    if (rows.length > 1) {
                                        btn.classList.remove('hidden');
                                    } else {
                                        btn.classList.add('hidden');
                                    }
                                });
                            }

                            addBtn.addEventListener('click', function() {
                                const firstRow = container.querySelector('.document-row');
                                const newRow = firstRow.cloneNode(true);
                                
                                newRow.querySelector('select').selectedIndex = 0;
                                newRow.querySelector('input[type="file"]').value = '';
                                
                                container.appendChild(newRow);
                                updateRemoveButtons();
                            });
                            
                            container.addEventListener('click', function(e) {
                                const btn = e.target.closest('.remove-doc-btn');
                                if(btn) {
                                    const rows = container.querySelectorAll('.document-row');
                                    if (rows.length > 1) {
                                        btn.closest('.document-row').remove();
                                        updateRemoveButtons();
                                    }
                                }
                            });

                            // File Validation Listener
                            container.addEventListener('change', function(e) {
                                if (e.target.type === 'file') {
                                    const file = e.target.files[0];
                                    if (file) {
                                        if (file.type !== 'application/pdf') {
                                            Swal.fire({ icon: 'error', title: 'Format Ditolak!', text: 'Pastikan Anda hanya mengunggah dokumen berformat PDF.' });
                                            e.target.value = ''; // Reset input
                                            return;
                                        }
                                        
                                        if (file.size > 5 * 1024 * 1024) {
                                            Swal.fire({ icon: 'warning', title: 'Ukuran Terlalu Besar!', text: 'Batas maksimal untuk satu file adalah 5MB.' });
                                            e.target.value = ''; // Reset input
                                            return;
                                        }
                                    }
                                }
                            });
                        });
                    </script>

                    <!-- Submit -->
                    <div class="pt-4 text-right">
                        <x-primary-button>
                            Simpan Perubahan & Ajukan Ulang
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>