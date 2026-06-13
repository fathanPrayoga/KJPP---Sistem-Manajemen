<x-app-layout>
    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <div class="min-h-screen bg-gray-50 pb-12">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <a href="{{ route('properti.fisik') }}"
                        class="text-gray-400 hover:text-gray-600 text-sm flex items-center mb-2 transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali ke Project
                    </a>
                    <h1 class="text-3xl font-bold text-gray-800 font-poppins">Verifikasi Survey</h1>
                    <p class="text-gray-500 mt-1">Project: <span
                            class="font-semibold text-[#82C17D]">{{ $project->nama_project }}</span></p>
                </div>
                <div>
                    {{-- Status Summary (Optional) --}}
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left: Map View --}}
                <div
                    class="lg:col-span-2 bg-white rounded-[40px] shadow-[0_20px_40px_rgba(0,0,0,0.04)] overflow-hidden p-1 relative z-0">
                    <div id="map" class="w-full h-[600px] rounded-[36px] z-0"></div>
                </div>

                {{-- Right: List of Elements to Verify --}}
                <div
                    class="bg-white p-6 rounded-[40px] shadow-[0_20px_40px_rgba(0,0,0,0.04)] max-h-[800px] overflow-y-auto">
                    <h3 class="text-xl font-bold mb-6 text-gray-800 px-2">Daftar Elemen</h3>

                    <div id="elementsContainer" class="space-y-4">
                        <div class="text-center py-10">
                            <span class="loading-spinner text-[#82C17D]">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- REJECT MODAL -->
        <div id="surveyRejectModal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeRejectModal()"></div>
            <div class="relative w-full max-w-md rounded-2xl shadow-2xl bg-white p-8 z-10 border-t-4 border-red-500">
                <h3 class="text-xl font-bold text-gray-800 mb-2">Tolak Elemen Survey</h3>
                <p class="text-sm text-gray-600 mb-4">Silakan masukkan alasan mengapa data survey ini ditolak.</p>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Penolakan (Wajib)</label>
                    <textarea id="rejectNotes" placeholder="Tuliskan catatan revisi di sini..." required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 h-28 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500"></textarea>
                    <p class="text-xs text-red-500 mt-1 hidden" id="rejectError">Catatan penolakan harus diisi.</p>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="submitReject()"
                        class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-bold shadow-md">
                        Kirim Penolakan
                    </button>
                    <button type="button" onclick="closeRejectModal()"
                        class="flex-1 bg-gray-100 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-200 transition font-bold border border-gray-300">
                        Batal
                    </button>
                </div>
            </div>
        </div>

    </div>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        let map;
        let markers = [];
        const projectId = {{ $project->id }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.addEventListener('DOMContentLoaded', () => {
            initMap();
            loadElements();
        });

        function initMap() {
            // Default Jakarta
            const defaultLat = -6.2088;
            const defaultLng = 106.8456;

            map = L.map('map').setView([defaultLat, defaultLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
        }

        async function loadElements() {
            const container = document.getElementById('elementsContainer');
            try {
                const response = await fetch(`/survey/${projectId}/elements`);
                const result = await response.json();

                container.innerHTML = '';
                // Clear existing markers
                markers.forEach(m => map.removeLayer(m));
                markers = [];

                if (result.success && result.data.length > 0) {
                    // Fit bounds logic
                    const bounds = [];

                    result.data.forEach(item => {
                        // Add Marker
                        if (item.latitude && item.longitude) {
                            const marker = L.marker([item.latitude, item.longitude]).addTo(map);
                            marker.bindPopup(`<b>${item.name}</b><br>${item.description || ''}`);
                            markers.push(marker);
                            bounds.push([item.latitude, item.longitude]);
                        }

                        // Add List Item
                        const el = document.createElement('div');
                        el.className = `p-4 rounded-2xl border ${getStatusBorder(item.status)} transition hover:shadow-md bg-white`;
                        el.innerHTML = `
                            <div class="flex items-start space-x-3 mb-3">
                                <div class="w-12 h-12 rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden">
                                     ${item.image_path ? `<img src="/storage/${item.image_path}" class="w-full h-full object-cover">` : '<svg class="w-6 h-6 text-gray-300 m-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'}
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">${item.name}</h4>
                                    <p class="text-xs text-gray-500 line-clamp-2">${item.description || '-'}</p>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center pt-2 border-t border-gray-50">
                                <span class="text-[10px] font-bold uppercase tracking-wider ${getStatusColor(item.status)} px-2 py-1 rounded-full">
                                    ${item.status}
                                </span>
                                <div class="flex space-x-2">
                                    ${item.status === 'pending' ? `
                                        <button onclick="openRejectModal(${item.id})" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition" title="Tolak">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                        <button onclick="verifyElement(${item.id}, 'verified')" class="p-1.5 text-green-500 hover:bg-green-50 rounded-lg transition" title="Setujui">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    ` : '<span class="text-xs text-gray-400 italic">Selesai</span>'}
                                </div>
                            </div>
                        `;
                        container.appendChild(el);
                    });

                    if (bounds.length > 0) {
                        map.fitBounds(bounds, { padding: [50, 50] });
                    }

                } else {
                    container.innerHTML = '<div class="text-center py-8 text-gray-400 italic">Belum ada data survey.</div>';
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        let currentRejectId = null;

        function openRejectModal(id) {
            currentRejectId = id;
            document.getElementById('rejectNotes').value = '';
            document.getElementById('rejectError').classList.add('hidden');
            document.getElementById('surveyRejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            currentRejectId = null;
            document.getElementById('surveyRejectModal').classList.add('hidden');
        }

        function submitReject() {
            const notes = document.getElementById('rejectNotes').value.trim();
            if (!notes) {
                document.getElementById('rejectError').classList.remove('hidden');
                return;
            }
            
            verifyElement(currentRejectId, 'rejected', notes);
            closeRejectModal();
        }

        async function verifyElement(id, status, notes = '') {
            let msg = status === 'verified' ? 'menyetujui' : 'menolak';
            if (status === 'verified') {
                const result = await Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: `Anda akan ${msg} elemen survey ini.`,
                    icon: 'question',
                    showCancelButton: true,
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Setujui!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                });
                if (!result.isConfirmed) return;
            }

            try {
                const response = await fetch(`/survey/element/${id}/verify`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: status, notes: notes })
                });

                const result = await response.json();
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Status elemen berhasil diperbarui.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    loadElements(); // Reload list
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal update status elemen.' });
                }
            } catch (e) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan sistem saat menghubungi server.' });
            }
        }

        function getStatusBorder(status) {
            if (status === 'verified') return 'border-green-200';
            if (status === 'rejected') return 'border-red-200';
            return 'border-gray-100';
        }

        function getStatusColor(status) {
            if (status === 'verified') return 'text-green-600 bg-green-50';
            if (status === 'rejected') return 'text-red-600 bg-red-50';
            return 'text-yellow-600 bg-yellow-50';
        }
    </script>
</x-app-layout>