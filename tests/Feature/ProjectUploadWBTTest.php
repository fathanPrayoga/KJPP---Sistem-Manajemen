<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectDocument;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProjectUploadWBTTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_kategori_kosong(): void
    {
        $user = User::factory()->create(['role' => 'client']);

        Storage::fake('public');

        // Gunakan ukuran 2000 KB (2MB) agar validasi berhasil (batasnya 5MB).
        $fakepdf = UploadedFile::fake()->create('dokumen_dummy.pdf', 2000, 'application/pdf');

        $response = $this->actingAs($user)->post(route('client.projects.store'), [
            'nama_project' => 'Test Project',
            'kategori' => 'rumah tinggal',
            'contract_date' => '2022-01-01',
            'contact_person' => 'Test Person',
            'deskripsi' => 'Test Description',
            'document_categories' => [], // di controller namanya document_categories (bukan documents_categories)
            'documents' => [$fakepdf]
        ]);

        $response->assertRedirect(route('properti.dokumen'));
        $response->assertSessionHas('success');

        Storage::disk('public')->assertExists('documents/' . $fakepdf->hashName());
        $this->assertDatabaseHas('project_documents', [
            'nama_file' => 'dokumen_dummy.pdf',
            'kategori_dokumen' => 'Lainnya',
        ]);
    }
}
