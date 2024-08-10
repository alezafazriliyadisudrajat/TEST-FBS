<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi_karyawan';
    protected $fillable = [
        'user_id',
        'tanggal',
        'check_in',
        'check_out',
    ];

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
