<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'karyawan') {

            $recentProjects = \App\Models\Project::with(['client', 'documents', 'nilai', 'physicalElements'])->latest()->take(5)->get();

            // Mengambil data statistik secara dinamis
            $stats = [
                'properti_count' => \App\Models\Project::count(),
                'laporan_count' => \App\Models\Project::where('status', '!=', 'Selesai')->count(),
                'pesan_count' => \App\Models\Message::where('recipient_id', $user->id)->where('is_read', false)->count()
            ];


            return view('dashboards.karyawan.index', compact('recentProjects', 'stats'));
        }

        if ($user->role === 'client') {
            return view('dashboards.client.index');
        }

        if ($user->role === 'pekerjaTambahan') {
            // TODO: Filter by actual assignment if table exists. For now show all 'pending' projects or similar.
            $assignedProjects = \App\Models\Project::latest()->get();
            return view('dashboards.pekerjaTambahan.index', compact('assignedProjects'));
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
