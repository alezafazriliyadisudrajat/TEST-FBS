<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HariKerja extends Model
{
    use HasFactory;

    protected $table = 'hari_kerja_jam_kerja';
    protected $fillable = [
        'hari_dalam_seminggu', 
        'mulai',
        'selesai'
    ];
}
