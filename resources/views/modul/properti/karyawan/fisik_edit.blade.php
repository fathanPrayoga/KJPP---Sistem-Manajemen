<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">
        <div class="max-w-3xl mx-auto px-6 py-8">
            <h1 class="mt-8 mb-6 text-[28px] font-poppins font-bold text-gray-800">Edit Project</h1>

            <div class="bg-white p-8 rounded-[20px] shadow-[0_10px_30px_rgba(0,0,0,0.04)]">
                <form method="POST" action="{{ route('projects.update', $project->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-gray-700">Nama Project</label>
                        <input type="text" name="nama_project" value="{{ old('nama_project', $project->nama_project) }}"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-[#82C17D] focus:ring-[#82C17D]">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" rows="4"
                            class="w-full rounded-lg border-gray-300 focus:border-[#82C17D] focus:ring-[#82C17D]">{{ old('deskripsi', $project->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-gray-700">Status</label>
                        <select name="status" class="w-full rounded-lg border-gray-300">
                            <option value="pending" {{ (old('status', $project->status) == 'pending') ? 'selected' : '' }}>Menunggu Review Dokumen</option>
                            <option value="menunggu_survei" {{ (old('status', $project->status) == 'menunggu_survei') ? 'selected' : '' }}>Dokumen Valid - Menunggu Survei</option>
                            <option value="menunggu_verifikasi_fisik" {{ (old('status', $project->status) == 'menunggu_verifikasi_fisik') ? 'selected' : '' }}>Survei Selesai - Menunggu Review Fisik</option>
                            <option value="proses_penilaian" {{ (old('status', $project->status) == 'proses_penilaian') ? 'selected' : '' }}>Data Fisik Valid - Proses Penilaian</option>
                            <option value="selesai" {{ (old('status', $project->status) == 'selesai') ? 'selected' : '' }}>Laporan Selesai</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-gray-700">Tugaskan ke Pekerja Tambahan (Assignee)</label>
                        <select name="pekerja_id" class="w-full rounded-lg border-gray-300">
                            <option value="">-- Belum Ditugaskan / Pilih Pekerja --</option>
                            @foreach($pekerjas as $pekerja)
                                <option value="{{ $pekerja->id }}" {{ (old('pekerja_id', $project->pekerja_id) == $pekerja->id) ? 'selected' : '' }}>
                                    {{ $pekerja->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-gray-700">Lokasi / Alamat (opsional)</label>
                        <div class="flex gap-2">
                            <input type="text" id="address-input" name="address" value="{{ old('address') }}"
                                placeholder="Cari alamat (contoh: Jalan, Kota)"
                                class="w-full rounded-lg border-gray-300 focus:border-[#82C17D] focus:ring-[#82C17D]">
                            <button type="button" id="fetch-location"
                                class="inline-flex items-center px-4 py-2  bg-gray-100 text-gray-700 rounded-md text-sm">Cari</button>
                        </div>
                        <p id="location-message" class="mt-2 text-sm text-gray-600"></p>
                        <!-- Editable coordinates (pre-populated from project if available) -->
                        <div class="mt-3 grid grid-cols-2 gap-3">
                            <div>
                                <label class="block mb-1 text-sm text-gray-600">Latitude</label>
                                <input type="text" id="latitude" name="latitude"
                                    value="{{ old('latitude', $project->latitude ?? '') }}" placeholder="-6.2000000"
                                    class="w-full rounded-lg border-gray-300 focus:border-[#82C17D] focus:ring-[#82C17D] text-sm">
                            </div>
                            <div>
                                <label class="block mb-1 text-sm text-gray-600">Longitude</label>
                                <input type="text" id="longitude" name="longitude"
                                    value="{{ old('longitude', $project->longitude ?? '') }}" placeholder="106.8166667"
                                    class="w-full rounded-lg border-gray-300 focus:border-[#82C17D] focus:ring-[#82C17D] text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 text-right">
                        <x-primary-button>
                            Simpan
                        </x-primary-button>
                        <a href="{{ route('properti.karyawan') }}"
                            class="ml-2 inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md text-sm">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const btn = document.getElementById('fetch-location');
            const input = document.getElementById('address-input');
            const msg = document.getElementById('location-message');
            const latField = document.getElementById('latitude');
            const lonField = document.getElementById('longitude');
            let lastFetch = 0;

            btn.addEventListener('click', async function () {
                const address = (input.value || '').trim();
                msg.textContent = '';

                if (!address) {
                    msg.textContent = 'Masukkan alamat terlebih dahulu.';
                    msg.className = 'mt-2 text-sm text-red-600';
                    return;
                }

                // Basic client-side rate limiting (Nominatim policy)
                const now = Date.now();
                if (now - lastFetch < 1100) { // at most ~1 request per second
                    msg.textContent = 'Tunggu sebentar sebelum mencoba lagi.';
                    msg.className = 'mt-2 text-sm text-red-600';
                    return;
                }
                lastFetch = now;

                btn.disabled = true;
                btn.classList.add('opacity-60');
                msg.textContent = 'Mencari lokasi...';
                msg.className = 'mt-2 text-sm text-gray-600';

                try {
                    const params = new URLSearchParams({
                        format: 'json',
                        limit: '1',
                        q: address,
                        addressdetails: '1',
                        email: 'admin@example.com' // identify client per Nominatim usage policy
                    });

                    const res = await fetch('https://nominatim.openstreetmap.org/search?' + params.toString(), {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    if (!res.ok) throw new Error('Network response was not ok');

                    const data = await res.json();
                    if (!Array.isArray(data) || data.length === 0) {
                        msg.textContent = 'Lokasi tidak ditemukan.';
                        msg.className = 'mt-2 text-sm text-red-600';
                        return;
                    }

                    const place = data[0];
                    // populate hidden fields, keep precision reasonable
                    latField.value = parseFloat(place.lat).toFixed(7);
                    lonField.value = parseFloat(place.lon).toFixed(7);

                    msg.textContent = 'Lokasi ditemukan dan disimpan (lat: ' + latField.value + ', lon: ' + lonField.value + ').';
                    msg.className = 'mt-2 text-sm text-green-600';

                } catch (err) {
                    console.error(err);
                    msg.textContent = 'Gagal mengambil lokasi. Silakan coba lagi nanti.';
                    msg.className = 'mt-2 text-sm text-red-600';
                } finally {
                    btn.disabled = false;
                    btn.classList.remove('opacity-60');
                }
            });
        })();
    </script>
</x-app-layout>