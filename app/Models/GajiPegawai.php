<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GajiPegawai extends Model
{
    use HasFactory;

    protected $table = 'gaji_pegawai'; 


    protected $fillable = [
        'user_id',
        'gaji_pokok',
        'denda_telat'
    ];

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
