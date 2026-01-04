<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectPhysicalElement;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class SurveyController extends Controller
{
    protected $nodeApi;

    public function __construct(\App\Services\NodeApiService $nodeApi)
    {
        $this->nodeApi = $nodeApi;
    }

    /**
     * Get all physical elements for a specific project.
     */
    public function getElements($projectId)
    {
        $elements = ProjectPhysicalElement::where('project_id', $projectId)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $elements
        ]);
    }

    /**
     * Store a new physical element.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'file' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $data = $request->only(['project_id', 'name', 'description', 'latitude', 'longitude']);

        // Handle File Upload
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('survey-elements', 'public');
            $data['image_path'] = $path;
        }

        $element = ProjectPhysicalElement::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Elemen berhasil ditambahkan!',
            'data' => $element
        ]);
    }
    /**
     * [INTEGRASI API NODE.JS] Update status elemen - Menggunakan API Node.js untuk Verifikasi Fisik
     */
    public function verifyElement(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected', // verified = Selesai/Approved
        ]);

        // Call Node.js API
        $result = $this->nodeApi->verifyPhysicalElement($id, [
            'status' => $request->status
        ]);

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui (via Node.js API).',
                'data' => $result
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal verifikasi via Node.js API.',
            ], 500);
        }
    }
}
