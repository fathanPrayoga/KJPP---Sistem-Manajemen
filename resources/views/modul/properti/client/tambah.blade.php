<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <h1 class="mt-8 mb-8 text-[32px] font-poppins font-bold text-gray-800">
                Tambah Projek
            </h1>

            <div class="bg-white p-8 rounded-[40px] shadow-[0_20px_40px_rgba(0,0,0,0.04)]">
                <form
                    method="POST"
                    action="{{ route('client.projects.store') }}"
                    enctype="multipart/form-data"
                    class="space-y-6"
                >
                    @csrf

                    <!-- Nama Project -->
                    <div>
                        <label class="block mb-2 font-medium text-gray-700">
                            Nama Project
                        </label>
                        <input
                            type="text"
                            name="nama_project"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        >
                    </div>

                    <!-- Contract Date -->
                    <div>
                        <label class="block mb-2 font-medium text-gray-700">
                            Contract Date
                        </label>
                        <input
                            type="date"
                            name="contract_date"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        >
                    </div>

                    <!-- Contact Person -->
                    <div>
                        <label class="block mb-2 font-medium text-gray-700">
                            Contact Person
                        </label>
                        <input
                            type="text"
                            name="contact_person"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        >
                    </div>

                    <!-- Kategori Project -->
                    <div>
                        <label class="block mb-2 font-medium text-gray-700">
                            Kategori Project
                        </label>
                        <select
                            name="kategori"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        >
                            <option value="" disabled selected>Pilih Kategori Project</option>
                            <option value="Contoh Kategori Project 1">Contoh Kategori Project 1</option>
                            <option value="Contoh Kategori Project 2">Contoh Kategori Project 2</option>
                            <option value="Contoh Kategori Project 3">Contoh Kategori Project 3</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block mb-2 font-medium text-gray-700">
                            Deskripsi
                        </label>
                        <textarea
                            name="deskripsi"
                            rows="4"
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        ></textarea>
                    </div>

                    <!-- Upload Dokumen -->
                    <div x-data="{ documents: [{ id: 1 }] }">
                        <div class="flex justify-between items-center mb-2">
                            <label class="font-medium text-gray-700">
                                Upload Dokumen (PDF)
                            </label>
                            <button type="button" @click="documents.push({ id: Date.now() })" class="text-sm text-green-600 hover:text-green-700 font-medium">
                                + Tambah Dokumen Lain
                            </button>
                        </div>
                        
                        <div class="space-y-3">
                            <template x-for="(doc, index) in documents" :key="doc.id">
                                <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center bg-gray-50 p-3 rounded-lg border border-gray-100 relative group">
                                    <select name="document_categories[]" required class="w-full sm:w-1/3 rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 text-sm">
                                        <option value="" disabled selected>Pilih Kategori Dokumen</option>
                                        <option value="Contoh Kategori Dokumen A">Contoh Kategori Dokumen A</option>
                                        <option value="Contoh Kategori Dokumen B">Contoh Kategori Dokumen B</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    
                                    <input
                                        type="file"
                                        name="documents[]"
                                        accept="application/pdf"
                                        required
                                        class="w-full sm:w-2/3 text-sm text-gray-600
                                               file:mr-4 file:rounded-full file:border-0
                                               file:bg-green-50 file:px-4 file:py-2
                                               file:text-green-700 hover:file:bg-green-100"
                                    >
                                    
                                    <button type="button" x-show="documents.length > 1" @click="documents.splice(index, 1)" class="absolute -right-2 -top-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        &times;
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

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
