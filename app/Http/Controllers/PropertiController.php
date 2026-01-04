<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Nilai;
use Illuminate\Support\Facades\Auth;

class PropertiController extends Controller
{
    protected $nodeApi;

    public function __construct(\App\Services\NodeApiService $nodeApi)
    {
        $this->nodeApi = $nodeApi;
    }

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
            $projects = Project::with('client')->latest()->get();
            return view('modul.properti.laporan.project', compact('projects'));
        } else {
            // Client - Read Only & Own Data
            $projects = Project::where('client_id', auth()->id())->latest()->get();
            return view('modul.properti.client.laporan', compact('projects'));
        }
    }

    // [INTEGRASI API NODE.JS] Ambil Detail Laporan Project
    public function getProject($id)
    {
        // $project = Project::findOrFail($id);
        // return response()->json($project);

        // Panggil Node.js API
        $data = $this->nodeApi->getReport($id);
        // Node.js queries 'SELECT * FROM projects WHERE id = ?', returns array
        $project = (!empty($data) && isset($data[0])) ? $data[0] : null;

        if ($project) {
            return response()->json($project);
        }
        return response()->json(['error' => 'Project not found (Node API)'], 404);
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

    // [INTEGRASI API NODE.JS] Ambil Laporan Tahunan
    public function getTahunanByYear($year)
    {
        // OLD CODE (Laravel Native)
        // $projects = Project::whereYear('tanggal_mulai', $year)
        //     ->whereNotNull('dokumen')
        //     ->get();
        // return response()->json(['tahun' => $year, 'files' => $projects]);

        // NEW CODE (Node API)
        $projects = $this->nodeApi->getYearlyReport($year);

        // Note: Node API saat ini query ke tabel 'laporan_tahunans'.
        // Pastikan data sinkron atau logika Node.js disesuaikan jika ingin tetap ambil dari 'projects'.

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
}