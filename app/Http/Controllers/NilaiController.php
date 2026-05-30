<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Enums\StatusPenilaian;

class NilaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get Nilai Data from Laravel database
     */
    public function show($projectId)
    {
        $nilai = Nilai::where('project_id', $projectId)->first();

        if ($nilai) {
            return response()->json([
                'exists' => true,
                'id' => $nilai->id,
                'status_penilaian' => $nilai->status_penilaian?->value ?? 'belum dinilai',
                'nilai_pasar_final' => $nilai->nilai_pasar_final ?? 0,
                'nilai_tanah' => $nilai->nilai_tanah ?? 0,
                'nilai_indikasi_dari_pasar' => $nilai->nilai_indikasi_dari_pasar ?? 0,
                'nilai_indikasi_dari_biaya' => $nilai->nilai_indikasi_dari_biaya ?? 0,
                'nilai_likuidasi' => $nilai->nilai_likuidasi ?? 0,
                'nilai_bangunan' => $nilai->nilai_bangunan ?? 0,
                'nilai_per_m2_tanah' => $nilai->nilai_per_m2_tanah ?? 0,
                'nilai_per_m2_bangunan' => $nilai->nilai_per_m2_bangunan ?? 0,
                'source' => 'Laravel Database'
            ]);
        }

        return response()->json(['exists' => false]);
    }

    /**
     * Store/Update Nilai Data in Laravel database
     */
    public function store(Request $request, $projectId)
    {
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

        // Helper to clean formatted numbers (remove dots used as thousands separator)
        $cleanNumber = function ($value) {
            if ($value === null || $value === '') return null;
            $cleaned = preg_replace('/[^0-9]/', '', (string) $value);
            return $cleaned === '' ? null : (int) $cleaned;
        };

        $hasAnyValue = false;
        foreach ($nilaiFields as $field) {
            $cleaned = $cleanNumber($request->input($field));
            if ($cleaned !== null && $cleaned !== 0) {
                $hasAnyValue = true;
                break;
            }
        }

        $inputStatus = $request->input('status_penilaian', 'sedang dinilai');
        $finalStatus = 'sedang dinilai'; // Default fallback

        if (!$hasAnyValue && !$request->has('status_penilaian')) {
            $finalStatus = 'belum dinilai';
        } else if ($inputStatus === 'sudah dinilai') {
            $finalStatus = 'sudah dinilai';
        } else {
            $finalStatus = 'sedang dinilai';
        }

        $data = [];
        foreach ($nilaiFields as $field) {
            $value = $request->input($field);
            $data[$field] = $cleanNumber($value);
        }
        $data['status_penilaian'] = $finalStatus;

        // Find existing or create new
        $nilai = Nilai::where('project_id', $projectId)->first();

        if ($nilai) {
            // Only allow update if not finalized
            if ($nilai->status_penilaian === StatusPenilaian::SUDAH_DINILAI && $finalStatus === 'sudah dinilai') {
                return response()->json(['success' => false, 'error' => 'Nilai tidak dapat diubah karena status sudah "Sudah Dinilai"'], 403);
            }
            $nilai->update($data);
        } else {
            $data['project_id'] = $projectId;
            $nilai = Nilai::create($data);
        }

        return response()->json(['success' => true, 'data' => $nilai]);
    }
}
