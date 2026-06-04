<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <h1 class="mt-8 text-3xl font-bold text-gray-800 mb-8 font-poppins text-[32px]">Fisik Properti</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Side: 3 Cards -->
                <div class="lg:col-span-1 space-y-6">
                        <!-- Dokumen Card -->
                        <a href="{{ route('properti.dokumen') }}" class="block group">
                            <div class="bg-white p-8 rounded-[35px] shadow-[0_20px_40px_rgba(0,0,0,0.06)]
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
                            <div class="bg-white p-8 rounded-[35px] shadow-[0_20px_40px_rgba(0,0,0,0.06)]
                                    hover:shadow-[0_20px_40px_rgba(0,0,0,0.12)]
                                    transition-all cursor-pointer border {{ request()->routeIs('properti.fisik') ? 'border-[#82C17D] ring-1 ring-[#82C17D] bg-green-50/30' : 'border-gray-50' }}">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-[#82C17D] p-4 rounded-[22px] text-white shadow-lg
                                            group-hover:scale-105 transition-transform">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
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
                            <div class="bg-white p-8 rounded-[35px] shadow-[0_20px_40px_rgba(0,0,0,0.06)]
                                    hover:shadow-[0_20px_40px_rgba(0,0,0,0.12)]
                                    transition-all cursor-pointer border {{ request()->routeIs('properti.penilaian') ? 'border-[#82C17D] ring-1 ring-[#82C17D] bg-green-50/30' : 'border-gray-50' }}">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-[#82C17D] p-4 rounded-[22px] text-white shadow-lg
                                            group-hover:scale-105 transition-transform">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
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
                    <h3 class="text-xl font-bold mb-6">Terbaru</h3>
                    <div class="overflow-x-auto overflow-y-auto max-h-[400px] pr-2">
                        <table class="w-full text-left">
                            <thead class="sticky top-0 bg-white z-10">
                                <tr class="text-gray-400 text-sm border-b">
                                    <th class="pb-4 font-semibold text-gray-700">Nama Client</th>
                                    <th class="pb-4 font-semibold text-gray-700">Nama Project</th>
                                    <th class="pb-4 font-semibold text-gray-700">Status</th>
                                    <th class="pb-4 font-semibold text-gray-700">Waktu</th>
                                    <th class="pb-4 font-semibold text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse($projects as $project)
                                    <tr class="border-b last:border-0 hover:bg-gray-50 transition">
                                        <td class="py-4 font-medium text-gray-800">
                                            {{ $project->client->name ?? 'Unknown Client' }}</td>
                                        <td class="py-4 text-gray-600">{{ $project->nama_project ?? 'Project' }}</td>
                                        <td class="py-4 text-sm font-medium text-gray-700">
                                            {{ ucfirst($project->status ?? '-') }}</td>
                                        <td class="py-4 font-semibold text-gray-800">
                                            {{ $project->created_at->format('H.i') }}</td>
                                        <td class="py-4">
                                            @if(\Illuminate\Support\Facades\Route::has('projects.show'))
                                                <a href="{{ route('projects.show', $project->id) }}"
                                                    class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-green-50 text-green-700 hover:bg-green-100 mr-2">View</a>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-gray-100 text-gray-400 mr-2 cursor-not-allowed">View</span>
                                            @endif

                                            @if(\Illuminate\Support\Facades\Route::has('projects.edit'))
                                                <a href="{{ route('projects.edit', $project->id) }}"
                                                    class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-yellow-50 text-yellow-700 hover:bg-yellow-100 mr-2">Edit</a>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-gray-100 text-gray-400 mr-2 cursor-not-allowed">Edit</span>
                                            @endif

                                            {{-- Verification Button --}}
                                            <a href="{{ route('survey.verification.page', $project->id) }}"
                                                class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-blue-50 text-blue-700 hover:bg-blue-100 shadow-sm transition">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Verifikasi Survey
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-8 text-gray-400 italic">Belum ada project.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>