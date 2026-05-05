<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NilaiController extends Controller
{
    protected $nodeApi;

    public function __construct(\App\Services\NodeApiService $nodeApi)
    {
        $this->middleware('auth');
        $this->nodeApi = $nodeApi;
    }

    /**
     * Get Nilai Data from Node.js API
     */
    public function show($projectId)
    {
        // Call Node.js API via Service
        $data = $this->nodeApi->getAppraisal($projectId);

        if ($data) {
            return response()->json([
                'exists' => true,
                'id' => $data['id'] ?? null,
                'status_penilaian' => $data['status_penilaian'] ?? 'belum dinilai',
                'nilai_pasar_final' => $data['nilai_pasar_final'] ?? 0,
                'nilai_tanah' => $data['nilai_tanah'] ?? 0,
                'nilai_indikasi_dari_pasar' => $data['nilai_indikasi_dari_pasar'] ?? 0,
                'nilai_indikasi_dari_biaya' => $data['nilai_indikasi_dari_biaya'] ?? 0,
                'nilai_likuidasi' => $data['nilai_likuidasi'] ?? 0,
                'nilai_bangunan' => $data['nilai_bangunan'] ?? 0,
                'nilai_per_m2_tanah' => $data['nilai_per_m2_tanah'] ?? 0,
                'nilai_per_m2_bangunan' => $data['nilai_per_m2_bangunan'] ?? 0,
                'source' => 'Node.js API (Hybrid)'
            ]);
        }

        return response()->json(['exists' => false]);
    }

    /**
     * Store/Update Nilai Data via Node.js API
     */
    public function store(Request $request, $projectId)
    {
        // We can still validate input in Laravel for security


        $data = $request->except(['_token', 'project_id']);



        // Check "status logic" existing in previous controller:
        /*
           if (!$hasAnyValue) status = 'belum';
           else if selected == sudah status = sudah;
           else status = sedang;
        */


        $nilaiFields = [
            'nilai_pasar_final',
            'nilai_tanah',
            'nilai_indikasi_dari_pasar',
            'nilai_indikasi_dari_biaya',
            'nilai_likuidasi',
            'nilai_bangunan',
            'nilai_per_m2_tanah',
            'nilai_per_m2_bangunan'
        ];

        $hasAnyValue = false;
        foreach ($nilaiFields as $field) {
            if ($request->input($field)) {
                $hasAnyValue = true;
                break;
            }
        }

        $inputStatus = $request->input('status_penilaian');
        $finalStatus = 'sedang dinilai'; // Default fallback

        if (!$hasAnyValue) {
            $finalStatus = 'belum dinilai';
        } else if ($inputStatus === 'sudah dinilai') {
            $finalStatus = 'sudah dinilai';
        } else {
            $finalStatus = 'sedang dinilai';
        }

        $payload = $request->all();
        $payload['status_penilaian'] = $finalStatus;

        // Send to Node.js
        $result = $this->nodeApi->saveAppraisal($projectId, $payload);

        if (isset($result['success']) && $result['success']) {
            return response()->json(['success' => true]);
        }

        return response()->json([
            'success' => false,
            'error' => $result['error'] ?? 'Gagal menyimpan ke Node.js API'
        ], 500);
    }
}
