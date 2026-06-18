<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">

        <div class="max-w-7xl mx-auto px-6 py-8">
            <h1 class="mt-8 text-3xl font-bold text-gray-800 mb-8 font-poppins text-[32px]">Dokumen Properti</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Side: 3 Cards -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Dokumen Card -->
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
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg">Dokumen</h3>
                                    <p class="text-gray-400 text-sm">Upload & Kelola Berkas</p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Fisik Card -->
                    <a href="{{ route('properti.fisik') }}" class="block group">
                        <div
                            class="bg-white p-8 rounded-[35px] shadow-[0_20px_40px_rgba(0,0,0,0.06)]
                                    hover:shadow-[0_20px_40px_rgba(0,0,0,0.12)]
                                    transition-all cursor-pointer border {{ request()->routeIs('properti.fisik') ? 'border-[#82C17D] ring-1 ring-[#82C17D] bg-green-50/30' : 'border-gray-50' }}">
                            <div class="flex items-center space-x-4">
                                <div class="bg-[#82C17D] p-4 rounded-[22px] text-white shadow-lg
                                            group-hover:scale-105 transition-transform">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg">Fisik</h3>
                                    <p class="text-gray-400 text-sm">Status Objek Properti</p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Penilaian Card -->
                    <a href="{{ route('properti.penilaian') }}" class="block group">
                        <div
                            class="bg-white p-8 rounded-[35px] shadow-[0_20px_40px_rgba(0,0,0,0.06)]
                                    hover:shadow-[0_20px_40px_rgba(0,0,0,0.12)]
                                    transition-all cursor-pointer border {{ request()->routeIs('properti.penilaian') ? 'border-[#82C17D] ring-1 ring-[#82C17D] bg-green-50/30' : 'border-gray-50' }}">
                            <div class="flex items-center space-x-4">
                                <div class="bg-[#82C17D] p-4 rounded-[22px] text-white shadow-lg
                                            group-hover:scale-105 transition-transform">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
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

                <!-- Right Side: Project List -->
                <div class="lg:col-span-2 bg-white p-8 rounded-[40px] shadow-[0_20px_40px_rgba(0,0,0,0.04)]">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold">Daftar Project</h3>
                        <label
                            class="flex items-center space-x-2 text-sm text-gray-500 cursor-pointer hover:text-gray-800 transition">
                            <input id="selectAll" type="checkbox"
                                class="w-5 h-5 rounded border-gray-300 text-[#82C17D] focus:ring-[#82C17D]"
                                onchange="toggleSelectAll()">
                            <span>Pilih Semua</span>
                        </label>
                    </div>
                    <div class="overflow-x-auto overflow-y-auto max-h-[400px] pr-2">
                        <div class="space-y-3">
                            @forelse($projects as $project)
                                                        @php
                                                            $allVerified = $project->documents->every(fn($d) => $d->status === 'verified');
                                                            $hasRejected = $project->documents->some(fn($d) => $d->status === 'rejected');
                                                            $hasPending = $project->documents->some(fn($d) => $d->status === 'pending');
                                                            $statusColor = $allVerified ? 'bg-green-100 text-green-800' : ($hasRejected ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800');
                                                            $statusText = $allVerified ? 'Verified' : ($hasRejected ? 'Rejected' : 'Pending');
                                                        @endphp
                                                        <div
                                                            class="flex items-center justify-between p-4 rounded-2xl border border-gray-100 hover:shadow-md hover:border-[#82C17D]/30 transition bg-white group">
                                                            <div class="flex items-center gap-4">
                                                                <div class="flex items-center">
                                                                    <input type="checkbox" id="checkbox-project-{{ $project->id }}"
                                                                        data-testid="checkbox-project-{{ $project->id }}"
                                                                        class="w-5 h-5 projectCheckbox rounded border-gray-300 text-[#82C17D] focus:ring-[#82C17D] mr-2"
                                                                        value="{{ $project->id }}" onchange="updateActionButtons()">
                                                                </div>
                                                                <div
                                                                    class="w-12 h-12 rounded-xl bg-gray-50 group-hover:bg-green-50 flex items-center justify-center text-gray-400 group-hover:text-[#82C17D] transition hidden md:flex">
                                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                                <div>
                                                                    <h4 class="font-bold text-gray-800 text-sm mb-0.5 capitalize">
                                                                        {{ $project->nama_project }}</h4>
                                                                    <p class="text-xs text-gray-500 font-medium">
                                                                        {{ $project->client->name ?? 'Unknown' }} &bull;
                                                                        {{ $project->created_at->format('H.i') }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="flex items-center gap-3">
                                                                <span
                                                                    class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-[11px] font-bold uppercase tracking-wider hidden sm:block">
                                                                    {{ $project->documents->count() }} File
                                                                </span>
                                                                <span
                                                                    class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider {{ $statusColor }}">
                                                                    {{ $statusText }}
                                                                </span>
                                                                <button onclick="openDocumentModal(this.dataset.project)" data-project="{{ json_encode([
                                    'id' => $project->id,
                                    'nama' => $project->nama_project,
                                    'documents' => $project->documents->map(fn($d) => [
                                        'id' => $d->id,
                                        'nama' => $d->nama_file,
                                        'url' => route('karyawan.document.download', $d->id),
                                        'created_at' => $d->created_at->format('d M Y'),
                                    ])->toArray()
                                ]) }}"
                                                                    class="inline-flex items-center px-4 py-2 bg-[#82C17D] hover:bg-[#6ba867] text-white text-xs font-bold rounded-full transition shadow-sm">
                                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                    </svg>
                                                                    Lihat
                                                                </button>
                                                            </div>
                                                        </div>
                            @empty
                                <div
                                    class="flex flex-col items-center justify-center py-10 px-4 text-center bg-gray-50 rounded-2xl border border-gray-100 border-dashed">
                                    <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                        </path>
                                    </svg>
                                    <p class="text-sm text-gray-500">Belum ada project.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div id="actionButtons" class="mt-6 pt-6 border-t flex gap-3 justify-end hidden">
                        <div class="max-w-md w-full flex gap-4 justify-end">
                            <button id="btn-bulk-reject" data-testid="btn-bulk-reject" onclick="openBulkRejectModal()"
                                class="px-8 py-3 bg-white text-black rounded-full font-bold shadow-[0_4px_14px_0_rgba(0,0,0,0.1)] hover:shadow-[0_6px_20px_rgba(0,0,0,0.15)] transition-all text-red-600">
                                Tolak
                            </button>
                            <button id="btn-bulk-verify" data-testid="btn-bulk-verify"
                                onclick="verifySelected('approve')"
                                class="px-8 py-3 bg-[#82C17D] text-white rounded-full font-bold shadow-[0_4px_14px_0_rgba(130,193,125,0.39)] hover:shadow-[0_6px_20px_rgba(130,193,125,0.23)] hover:bg-[#6cad67] transition-all">
                                Verifikasi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL DOKUMEN (Vanilla JS) -->
        <div id="documentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeDocumentModal()"></div>
            <div
                class="relative w-full max-w-lg rounded-[30px] shadow-2xl bg-white overflow-hidden z-10 max-h-[80vh] overflow-y-auto">
                <div class="bg-[#82C17D] px-8 py-4 flex justify-between items-center sticky top-0">
                    <h3 id="docModalTitle" class="text-white text-lg font-bold"></h3>
                    <button onclick="closeDocumentModal()"
                        class="text-white text-3xl leading-none hover:text-gray-100">&times;</button>
                </div>

                <div class="p-6 space-y-4">
                    <!-- Dokumen List -->
                    <div>
                        <h4 class="text-sm font-bold text-gray-600 uppercase mb-3">Dokumen</h4>
                        <div id="docModalList" class="space-y-2">
                            <!-- JS will populate this -->
                        </div>
                    </div>

                    <!-- Download All Button -->
                    <button id="docModalDownloadAll"
                        class="w-full bg-[#82C17D] text-white px-4 py-3 rounded-lg hover:bg-[#6cad67] transition font-semibold text-sm">
                        Unduh Semua
                    </button>

                    <!-- Tindakan Verifikasi -->
                    <div class="mt-6 border-t pt-4">
                        <h4 class="text-sm font-bold text-gray-600 uppercase mb-3">Tindakan Verifikasi</h4>
                        <div class="flex gap-4">
                            <button id="docModalReject"
                                class="flex-1 px-8 py-3 bg-white text-black rounded-full font-bold shadow-[0_4px_14px_0_rgba(0,0,0,0.1)] hover:shadow-[0_6px_20px_rgba(0,0,0,0.15)] transition-all text-sm">
                                Tolak
                            </button>
                            <button id="docModalApprove"
                                class="flex-1 px-8 py-3 bg-[#82C17D] text-white rounded-full font-bold shadow-[0_4px_14px_0_rgba(130,193,125,0.39)] hover:shadow-[0_6px_20px_rgba(130,193,125,0.23)] hover:bg-[#6cad67] transition-all text-sm">
                                Verifikasi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL VERIFIKASI PROJECT -->
        <div id="verifyModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
                onclick="document.getElementById('verifyModal').classList.add('hidden')"></div>
            <div class="relative w-full max-w-md rounded-2xl shadow-2xl bg-white p-8 z-10">
                <h3 class="text-xl font-bold text-gray-800 mb-2">Verifikasi Project</h3>
                <p class="text-sm text-gray-600 mb-4">Project: <span id="verifyProjectName"
                        class="font-semibold text-gray-800"></span></p>

                <form method="POST" id="verifyForm">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Verifikasi</label>
                        <textarea name="notes" id="notes" placeholder="Masukkan catatan..."
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 h-24 focus:outline-none focus:border-[#82C17D] focus:ring-1 focus:ring-[#82C17D]"></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" name="action" id="btnApprove" value="approve"
                            class="flex-1 bg-[#82C17D] text-white px-4 py-2 rounded-lg hover:bg-[#6cad67] transition font-bold hidden">
                            ✓ Setujui
                        </button>
                        <button type="submit" name="action" id="btnReject" value="reject"
                            class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-bold hidden">
                            ✕ Tolak
                        </button>
                        <button type="button" onclick="document.getElementById('verifyModal').classList.add('hidden')"
                            class="flex-1 bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition font-bold">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL TOLAK MASSAL -->
        <div id="bulkRejectModal" class="hidden fixed inset-0 z-[70] flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
                onclick="document.getElementById('bulkRejectModal').classList.add('hidden')"></div>
            <div class="relative w-full max-w-md rounded-2xl shadow-2xl bg-white p-8 z-10 border-t-4 border-red-500">
                <h3 class="text-xl font-bold text-gray-800 mb-2">Tolak Banyak Project</h3>
                <p class="text-sm text-gray-600 mb-4">Anda akan menolak <span id="bulkRejectCount"
                        class="font-bold text-red-600"></span> project sekaligus.</p>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Penolakan (Wajib)</label>
                    <textarea id="bulkRejectNotes" placeholder="Tuliskan alasan mengapa dokumen-dokumen ini ditolak..."
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 h-28 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500"></textarea>
                    <p class="text-xs text-red-500 mt-1 hidden" id="bulkRejectError">Catatan penolakan harus diisi.</p>
                </div>

                <div class="flex gap-3">
                    <button id="btn-submit-reject" data-testid="btn-submit-reject" type="button"
                        onclick="submitBulkReject()"
                        class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-bold shadow-md">
                        Kirim Penolakan
                    </button>
                    <button type="button" onclick="document.getElementById('bulkRejectModal').classList.add('hidden')"
                        class="flex-1 bg-gray-100 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-200 transition font-bold border border-gray-300">
                        Batal
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script>
        const verifyBatchUrl = "{{ route('karyawan.verify-batch') }}";

        // --- NEW VANILLA JS MODAL LOGIC ---
        function openDocumentModal(projectDataStr) {
            const project = JSON.parse(projectDataStr);

            document.getElementById('docModalTitle').innerText = project.nama;

            const docList = document.getElementById('docModalList');
            if (project.documents.length === 0) {
                docList.innerHTML = '<p class="text-center text-gray-400 text-sm py-4">Tidak ada dokumen</p>';
            } else {
                docList.innerHTML = project.documents.map(doc => `
                    <div class="flex items-center justify-between gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <i class="fa fa-file-pdf text-red-500 text-2xl shrink-0"></i>
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-gray-800 truncate">${doc.nama}</div>
                                <div class="text-xs text-gray-500">${doc.created_at}</div>
                            </div>
                        </div>
                        <a href="${doc.url}" target="_blank" class="text-gray-400 hover:text-[#82C17D] transition" title="Unduh Dokumen">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                `).join('');
            }

            document.getElementById('docModalDownloadAll').onclick = function () {
                window.location.href = '/karyawan/projects/' + project.id + '/download-all';
            };

            document.getElementById('docModalApprove').onclick = function () {
                closeDocumentModal();
                openVerifyModal(project.id, project.nama, 'approve');
            };

            document.getElementById('docModalReject').onclick = function () {
                closeDocumentModal();
                openVerifyModal(project.id, project.nama, 'reject');
            };

            document.getElementById('documentModal').classList.remove('hidden');
        }

        function closeDocumentModal() {
            document.getElementById('documentModal').classList.add('hidden');
        }
        // --- END VANILLA JS MODAL LOGIC ---

        function toggleSelectAll() {
            const sel = document.getElementById('selectAll');
            document.querySelectorAll('.projectCheckbox').forEach(cb => cb.checked = sel.checked);
            updateActionButtons();
        }

        function updateActionButtons() {
            const any = document.querySelectorAll('.projectCheckbox:checked').length > 0;
            document.getElementById('actionButtons').classList.toggle('hidden', !any);
        }

        function getSelectedProjects() {
            return Array.from(document.querySelectorAll('.projectCheckbox:checked')).map(cb => cb.value);
        }

        function verifySelected(action, notes = '') {
            const selected = getSelectedProjects();
            if (selected.length === 0) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih minimal 1 project terlebih dahulu.' });
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = verifyBatchUrl;

            const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
            let inputs = `<input type="hidden" name="_token" value="${csrf}">`;
            inputs += `<input type="hidden" name="action" value="${action}">`;
            if (notes) {
                inputs += `<input type="hidden" name="notes" value="${notes}">`;
            }
            selected.forEach(id => inputs += `<input type="hidden" name="project_ids[]" value="${id}">`);
            form.innerHTML = inputs;

            document.body.appendChild(form);
            form.submit();
        }

        function openBulkRejectModal() {
            const selected = getSelectedProjects();
            if (selected.length === 0) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih minimal 1 project yang ingin ditolak.' });
                return;
            }
            document.getElementById('bulkRejectCount').innerText = selected.length;
            document.getElementById('bulkRejectNotes').value = '';
            document.getElementById('bulkRejectError').classList.add('hidden');
            document.getElementById('bulkRejectModal').classList.remove('hidden');
        }

        function submitBulkReject() {
            const notes = document.getElementById('bulkRejectNotes').value.trim();
            if (!notes) {
                document.getElementById('bulkRejectError').classList.remove('hidden');
                return;
            }
            verifySelected('reject', notes);
        }

        function openVerifyModal(projectId, projectName, actionType = null) {
            document.getElementById('verifyProjectName').innerText = projectName;
            document.getElementById('verifyForm').action = `/karyawan/projects/${projectId}/verify`;

            const btnApprove = document.getElementById('btnApprove');
            const btnReject = document.getElementById('btnReject');

            if (actionType === 'approve') {
                btnApprove.classList.remove('hidden');
                btnReject.classList.add('hidden');
            } else if (actionType === 'reject') {
                btnReject.classList.remove('hidden');
                btnApprove.classList.add('hidden');
            } else {
                btnApprove.classList.remove('hidden');
                btnReject.classList.remove('hidden');
            }

            document.getElementById('verifyModal').classList.remove('hidden');
        }

        // We can keep submitVerify for direct calls if needed, but the form handles its own submit
        function submitVerify(projectId, action) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/karyawan/projects/${projectId}/verify`;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            form.innerHTML = `
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="action" value="${action}">
            `;
            document.body.appendChild(form);
            form.submit();
        }

        document.getElementById('verifyForm').addEventListener('submit', function (e) {
            const submitter = e.submitter;
            if (submitter && submitter.value === 'reject') {
                const notes = document.getElementById('notes').value.trim();
                if (!notes) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Catatan Diperlukan',
                        text: 'Anda wajib memberikan catatan jika ingin menolak dokumen.'
                    });
                }
            }
        });
    </script>
</x-app-layout>