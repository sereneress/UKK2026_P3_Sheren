<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $table = 'aspirasi';
    protected $primaryKey = 'id_aspirasi';

    protected $fillable = [
        'user_id',
        'id_kategori',
        'id_ruangan', // 🔥 INI YANG KURANG
        'lokasi',
        'keterangan',
        'foto',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // RELASI
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }

    public function progres()
    {
        return $this->hasMany(Progres::class, 'id_aspirasi', 'id_aspirasi');
    }

    public function historyStatus()
    {
        return $this->hasMany(HistoryStatus::class, 'id_aspirasi', 'id_aspirasi');
    }
}