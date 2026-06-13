<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Nilai;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
class PropertiController extends Controller
{

    // ===== FUNGSI INDEX BERDASARKAN ROLE =====

    public function karyawan()
    {
        $projects = Project::latest()->take(10)->get();
        return view('modul.properti.karyawan.index', compact('projects'));
    }

    public function client()
    {
        $projects = Project::with('documents')
            ->where('client_id', Auth::id())
            ->latest()
            ->take(10)
            ->get();

        return view('modul.properti.client.index', compact('projects'));
    }

    // ===== MODULE DOKUMEN =====

    public function dokumen()
    {
        $role = auth()->user()->role;

        if ($role === 'karyawan') {
            $projects = Project::latest()->get();
            return view('modul.properti.karyawan.dokumen', compact('projects'));
        } else {
            $projects = Project::with('documents')
                ->where('client_id', auth()->id())
                ->latest()
                ->get();
            return view('modul.properti.client.dokumen', compact('projects'));
        }
    }

    // ===== MODULE FISIK =====

    public function fisik()
    {
        $role = auth()->user()->role;

        if ($role === 'karyawan') {
            $projects = Project::latest()->take(10)->get();
            return view('modul.properti.karyawan.fisik', compact('projects'));
        }

        $projects = Project::with('documents')
            ->where('client_id', auth()->id())
            ->latest()
            ->take(10)
            ->get();

        return view('modul.properti.client.fisik', compact('projects'));
    }

    // ===== MODULE PENILAIAN =====

    public function penilaian()
    {
        $role = auth()->user()->role;

        if ($role === 'karyawan') {
            $projects = Project::with('client')->latest()->get();
            return view('modul.properti.karyawan.penilaian', compact('projects'));
        } else {
            $projects = Project::where('client_id', auth()->id())->latest()->get();
            return view('modul.properti.client.penilaian', compact('projects'));
        }
    }

    // ===== LOGIKA PENILAIAN (PINDAH KE NilaiController) =====
    // Code moved to App\Http\Controllers\NilaiController.php for Hybrid Architecture


    // ===== MODULE LAPORAN =====
    public function laporanProject()
    {
        $role = auth()->user()->role;

        if ($role === 'karyawan') {
            $projects = Project::with('client')
                ->whereIn('status', ['verified', 'Selesai', 'selesai'])
                ->latest()
                ->get();
            return view('modul.properti.laporan.project', compact('projects'));
        } else {
            // Client - Read Only & Own Data
            $projects = Project::where('client_id', auth()->id())
                ->whereIn('status', ['verified', 'Selesai', 'selesai'])
                ->latest()
                ->get();
            return view('modul.properti.client.laporan', compact('projects'));
        }
    }

    public function getProject($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }

    public function generatePdf($id)
    {
        $project = Project::with(['client', 'documents', 'physicalElements'])->findOrFail($id);
        $nilai = Nilai::where('project_id', $id)->first();

        // Buat data untuk di-pass ke view template PDF
        $data = [
            'project' => $project,
            'client' => $project->client,
            'documents' => $project->documents,
            'fisik' => $project->physicalElements->first(),
            'nilai' => $nilai,
            'tanggal_cetak' => \Carbon\Carbon::now()->translatedFormat('d F Y')
        ];

        // Load view & generate output PDF
        $pdf = Pdf::loadView('modul.properti.laporan.template_pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        $output = $pdf->output();

        // Tentukan nama file dan path
        $fileName = 'Laporan_Penilaian_' . str_replace(' ', '_', $project->nama_project) . '.pdf';
        $filePath = 'laporan_project/' . $fileName;

        // Jika sudah ada file dokumen lama, hapus agar direplace (overwrite)
        if ($project->dokumen && \Illuminate\Support\Facades\Storage::disk('public')->exists($project->dokumen)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($project->dokumen);
        }

        // Simpan file PDF ke storage
        \Illuminate\Support\Facades\Storage::disk('public')->put($filePath, $output);

        // Update record project
        $project->dokumen = $filePath;
        if (empty($project->tanggal_mulai)) {
            $project->tanggal_mulai = \Carbon\Carbon::now();
        }
        if ($project->status !== 'Selesai') {
            $project->status = 'Selesai';
        }
        $project->save();

        // Sinkronisasi ke Laporan Tahunan
        if ($project->tanggal_mulai) {
            try {
                $year = \Carbon\Carbon::parse($project->tanggal_mulai)->year;
                \App\Models\LaporanTahunan::updateOrCreate(
                    [
                        'tahun' => $year,
                        'nama_file' => 'Laporan Project ' . $project->nama_project
                    ],
                    [
                        'file_path' => $filePath
                    ]
                );
            } catch (\Exception $e) {
                \Log::error("Gagal simpan ke LaporanTahunan dari generatePdf: " . $e->getMessage());
            }
        }

        // Stream (tampilkan) PDF ke user
        return $pdf->stream($fileName);
    }

    public function uploadLaporan(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'asal_instansi' => 'nullable|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'file' => 'nullable|mimes:pdf|max:2048',
        ]);

        $project = Project::findOrFail($request->project_id);

        // SIMPAN TEXT
        $project->asal_instansi = $request->asal_instansi;
        $project->tanggal_mulai = $request->tanggal_mulai;

        // FILE
        if ($request->hasFile('file')) {
            if ($project->dokumen) {
                Storage::disk('public')->delete($project->dokumen);
            }

            $project->dokumen = $request->file('file')
                ->store('laporan_project', 'public');
        }

        $project->status = 'Selesai';
        $project->save();

        // [FIX] Sinkronisasi ke tabel Laporan Tahunan
        if ($request->hasFile('file') && $project->tanggal_mulai) {
            try {
                // Ambil tahun dari tanggal mulai
                $year = \Carbon\Carbon::parse($project->tanggal_mulai)->year;

                // Cek apakah sudah ada laporan untuk tahun ini & file ini (opsional, bisa create baru terus)
                // Disini kita create baru saja sebagai log arsip
                \App\Models\LaporanTahunan::create([
                    'tahun' => $year,
                    'nama_file' => 'Laporan Project ' . $project->nama_project,
                    'file_path' => $project->dokumen, // Pakai path yang sama
                ]);
            } catch (\Exception $e) {
                \Log::error("Gagal simpan ke LaporanTahunan: " . $e->getMessage());
            }
        }

        return back()->with('success', 'Laporan berhasil diperbarui');
    }


    public function laporanTahunan()
    {
        $years = Project::whereNotNull('tanggal_mulai')
            ->selectRaw('YEAR(tanggal_mulai) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->get();

        return view('modul.properti.laporan.tahunan', compact('years'));
    }

    public function getTahunanByYear($year)
    {
        $projects = Project::with('client')
            ->whereYear('tanggal_mulai', $year)
            ->whereNotNull('dokumen')
            ->get();
        return response()->json(['tahun' => $year, 'files' => $projects]);
    }

    public function deleteProject($id)
    {
        $project = Project::findOrFail($id);
        if ($project->dokumen) {
            Storage::disk('public')->delete($project->dokumen);
        }
        $project->delete();

        return back()->with('success', 'Project dan laporan berhasil dihapus');
    }
    public function downloadZipTahunan($year)
    {
        $projects = Project::whereYear('tanggal_mulai', $year)
            ->whereNotNull('dokumen')
            ->get();

        if ($projects->isEmpty()) {
            return back()->with('error', 'Tidak ada dokumen untuk diunduh pada tahun ini.');
        }

        $zipFileName = 'Laporan_Tahunan_' . $year . '.zip';
        $zipFilePath = public_path($zipFileName); // Gunakan public_path
        $zip = new \ZipArchive;

        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            foreach ($projects as $project) {
                $filePath = storage_path('app/public/' . $project->dokumen);

                if (file_exists($filePath)) {
                    // Gunakan nama project sebagai nama file di dalam ZIP
                    $namaFileDalamZip = str_replace(' ', '_', $project->nama_project) . '.pdf';
                    $zip->addFile($filePath, $namaFileDalamZip);
                }
            }
            $zip->close();
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function downloadRekapTahunan($year)
    {
        $projects = Project::with(['client', 'nilai'])
            ->whereYear('tanggal_mulai', $year)
            ->whereIn('status', ['Selesai', 'selesai'])
            ->get();

        if ($projects->isEmpty()) {
            return back()->with('error', 'Tidak ada data project yang selesai pada tahun ini.');
        }

        $data = [
            'year' => $year,
            'projects' => $projects
        ];

        $pdf = Pdf::loadView('modul.properti.laporan.tahunan_pdf', $data);
        $pdf->setPaper('A4', 'landscape');

        $fileName = 'Laporan_Tahunan_' . $year . '.pdf';

        return $pdf->download($fileName);
    }
}