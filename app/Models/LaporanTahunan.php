<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanTahunan extends Model
{
    use HasFactory;

    protected $table = 'laporan_tahunans';

    protected $fillable = [
        'tahun',
        'nama_file',
        'file_path',
    ];
}
