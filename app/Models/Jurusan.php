<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';
    protected $primaryKey = 'id_jurusan';

    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan',
        'deskripsi'
    ];

    // relasi (optional tapi bagus)
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id_jurusan');
    }
}
