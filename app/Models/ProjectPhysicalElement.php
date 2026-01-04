<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectPhysicalElement extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'description',
        'latitude',
        'longitude',
        'image_path',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
