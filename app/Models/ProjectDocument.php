<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDocument extends Model
{
    protected $fillable = [
        'project_id',
        'nama_file',
        'file_path',
        'kategori_dokumen',
        'status',
        'notes',
        'verified_by',
        'verified_at',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}