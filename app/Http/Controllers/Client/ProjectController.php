<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function create()
    {
        return view('modul.properti.client.tambah');
    }

    public function store(Request $request)
    {
        $project = Project::create([
            'client_id'      => auth()->id(),
            'nama_project'   => $request->nama_project,
            'kategori'       => $request->kategori,
            'contract_date'  => $request->contract_date,
            'contact_person' => $request->contact_person,
            'deskripsi'      => $request->deskripsi,
            'status'         => 'pending',
            'latitude'       => $request->latitude ?? null,
            'longitude'      => $request->longitude ?? null,
        ]);

        $request->validate([
            'documents' => 'required|array',
            'documents.*' => 'required|file|mimes:pdf|max:5120',
        ], [
            'documents.required' => 'Minimal satu dokumen harus diunggah.',
            'documents.*.mimes' => 'Seluruh file dokumen wajib berformat PDF.',
            'documents.*.max' => 'Ukuran maksimal setiap file adalah 5MB.'
        ]);

        if ($request->hasFile('documents')) {
            $categories = $request->input('document_categories', []);
            foreach ($request->file('documents') as $index => $file) {
                $path = Storage::disk('public')->putFile('documents', $file);

                $docCategory = isset($categories[$index]) ? $categories[$index] : 'Lainnya';

                $project->documents()->create([
                    'nama_file' => $file->getClientOriginalName(),
                    'file_path' => 'storage/' . $path,
                    'kategori_dokumen' => $docCategory,
                ]);
            }
        }

        return redirect()->route('properti.dokumen')
            ->with('success', 'Dokumen berhasil ditambahkan');
    }

    public function edit(Project $project)
    {
        return view('modul.properti.karyawan.fisik_edit', compact('project'));
    }

    public function show(Project $project)
    {
        return view('modul.properti.karyawan.fisik_show', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'nama_project' => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'status'       => 'nullable|string|in:pending,proses,selesai',
            'latitude'     => 'nullable|numeric',
            'longitude'    => 'nullable|numeric',
        ]);

        // Update core fields (keep existing behaviour)
        $project->update(
            array_intersect_key($data, array_flip(['nama_project', 'deskripsi', 'status']))
        );

        // Only update coordinates if the request provided them (allow keeping existing values)
        $coordsChanged = false;
        if ($request->filled('latitude')) {
            $project->latitude = $request->input('latitude');
            $coordsChanged = true;
        }

        if ($request->filled('longitude')) {
            $project->longitude = $request->input('longitude');
            $coordsChanged = true;
        }

        if ($coordsChanged) {
            $project->save();
        }

        return redirect()->route('properti.karyawan')->with('success', 'Project updated');
    }

    public function destroy(Project $project)
    {
        if ($project->client_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $status = strtolower($project->status ?? '');
        if (!in_array($status, ['pending', 'menunggu'])) {
            return back()->with('error', 'Hanya project berstatus PENDING yang dapat dihapus.');
        }

        foreach ($project->documents as $doc) {
            $filePath = str_replace('storage/', '', $doc->file_path);
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        $project->documents()->delete();
        $project->delete();

        return back()->with('success', 'Project berhasil dibatalkan dan dihapus.');
    }
}
