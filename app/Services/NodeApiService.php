<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NodeApiService
{
    protected $baseUrl;

    public function __construct()
    {
        // Default to localhost:3000 if not set in .env
        $this->baseUrl = env('NODE_API_URL', 'http://localhost:3000/api');
    }

    /**
     * Update document verification status via Node.js API
     */
    public function verifyDocument($id, $data)
    {
        try {
            $response = Http::put("{$this->baseUrl}/dokumen/{$id}/verify", $data);
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            \Log::error("Node API Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get documents by project ID
     */
    public function getDocuments($projectId)
    {
        try {
            $response = Http::get("{$this->baseUrl}/dokumen/{$projectId}");
            return $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            return [];
        }
    }
    /**
     * Update physical element verification status via Node.js API
     */
    public function verifyPhysicalElement($id, $data)
    {
        try {
            $response = Http::put("{$this->baseUrl}/fisik/{$id}/verify", $data);
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            \Log::error("Node API Error (Fisik): " . $e->getMessage());
            return null;
        }
    }
    /**
     * [INTEGRASI API NODE.JS] Ambil Laporan Project
     */
    public function getReport($projectId)
    {
        try {
            $response = Http::get("{$this->baseUrl}/laporan/project/{$projectId}");
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * [INTEGRASI API NODE.JS] Ambil Laporan Tahunan
     */
    public function getYearlyReport($year)
    {
        try {
            $response = Http::get("{$this->baseUrl}/laporan/tahunan/{$year}");
            return $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * [INTEGRASI API NODE.JS] Ambil Nilai Appraisal Project
     */
    public function getAppraisal($projectId)
    {
        try {
            $response = Http::get("{$this->baseUrl}/nilai/{$projectId}");
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * [INTEGRASI API NODE.JS] Simpan / Update Nilai Appraisal
     */
    public function saveAppraisal($projectId, $data)
    {
        try {
            $response = Http::post("{$this->baseUrl}/nilai/{$projectId}", $data);
            return $response->successful() ? $response->json() : ['success' => false];
        } catch (\Exception $e) {
            \Log::error("Node API Error (Save Nilai): " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * [INTEGRASI API NODE.JS] Ambil Riwayat Chat
     */
    public function getChatHistory($user1, $user2)
    {
        try {
            $response = Http::get("{$this->baseUrl}/chats/{$user1}/{$user2}");
            return $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            return [];
        }
    }
}
