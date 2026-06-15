<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <h1 class="mt-8 mb-8 text-[32px] font-poppins font-bold text-gray-800">
                Tambah Project
            </h1>

            <div class="bg-white p-8 rounded-[40px] shadow-[0_20px_40px_rgba(0,0,0,0.04)]">
                <form method="POST" action="{{ route('client.projects.store') }}" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <!-- Nama Project -->
                    <div>
                        <label for="nama_project" class="block mb-2 font-medium text-gray-700">
                            Nama Project
                        </label>
                        <input type="text" id="nama_project" name="nama_project" required
                            class="w-full rounded-lg border-gray-300 focus:border-[#82C17D] focus:ring-[#82C17D]">
                    </div>

                    <!-- Contract Date -->
                    <div>
                        <label for="contract_date" class="block mb-2 font-medium text-gray-700">
                            Contract Date
                        </label>
                        <input type="date" id="contract_date" name="contract_date" required
                            class="w-full rounded-lg border-gray-300 focus:border-[#82C17D] focus:ring-[#82C17D]">
                    </div>

                    <!-- Contact Person -->
                    <div>
                        <label for="contact_person" class="block mb-2 font-medium text-gray-700">
                            Contact Person
                        </label>
                        <input type="text" id="contact_person" name="contact_person" required
                            class="w-full rounded-lg border-gray-300 focus:border-[#82C17D] focus:ring-[#82C17D]">
                    </div>

                    <!-- Kategori Project -->
                    <div>
                        <label for="kategori" class="block mb-2 font-medium text-gray-700">
                            Kategori Project
                        </label>
                        <select id="kategori" name="kategori" required
                            class="w-full rounded-lg border-gray-300 focus:border-[#82C17D] focus:ring-[#82C17D]">
                            <option value="" disabled selected>Pilih Kategori Project</option>
                            <option value="Penilaian Rumah Tinggal">Penilaian Rumah Tinggal</option>
                            <option value="Penilaian Tanah Kosong">Penilaian Tanah Kosong</option>
                            <option value="Penilaian Ruko / Rukan">Penilaian Ruko / Rukan</option>
                            <option value="Penilaian Gedung Komersial">Penilaian Gedung Komersial</option>
                            <option value="Penilaian Pabrik / Gudang">Penilaian Pabrik / Gudang</option>
                            <option value="Penilaian Mesin / Peralatan">Penilaian Mesin / Peralatan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block mb-2 font-medium text-gray-700">
                            Deskripsi
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="4"
                            class="w-full rounded-lg border-gray-300 focus:border-[#82C17D] focus:ring-[#82C17D]"></textarea>
                    </div>

                    <!-- Upload Dokumen -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="font-medium text-gray-700">
                                Upload Dokumen <span class="text-xs text-red-500 font-bold ml-1">(Wajib PDF, Maks. 5MB)</span>
                            </label>
                            <button type="button" id="addDocumentBtn"
                                class="text-sm text-green-600 hover:text-green-700 font-medium">
                                + Tambah Dokumen Lain
                            </button>
                        </div>

                        <div id="documentContainer" class="space-y-3">
                            <!-- Default 1 File Input -->
                            <div class="document-row flex flex-col sm:flex-row gap-3 items-start sm:items-center bg-gray-50 p-3 rounded-lg border border-gray-100 relative group">
                                <select id="document_categories" name="document_categories[]" required
                                    class="w-full sm:w-1/3 rounded-lg border-gray-300 focus:border-[#82C17D] focus:ring-[#82C17D] text-sm">
                                    <option value="" disabled selected>Pilih Kategori Dokumen</option>
                                    <option value="Dokumen Kepemilikan (SHM/HGB)">Dokumen Kepemilikan (SHM/HGB)</option>
                                    <option value="Perizinan Bangunan (IMB/PBG)">Perizinan Bangunan (IMB/PBG)</option>
                                    <option value="Tagihan Pajak (PBB)">Tagihan Pajak (PBB)</option>
                                    <option value="Denah / Blueprint Bangunan">Denah / Blueprint Bangunan</option>
                                    <option value="Identitas Pemilik (KTP/NPWP)">Identitas Pemilik (KTP/NPWP)</option>
                                    <option value="Foto Objek Properti">Foto Objek Properti</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>

                                <input id="documents" type="file" name="documents[]" accept="application/pdf" required class="w-full sm:w-2/3 text-sm text-gray-600
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
                            Kirim Dokumen
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>