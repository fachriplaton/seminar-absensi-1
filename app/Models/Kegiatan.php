<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Peserta;

class Kegiatan extends Model
{
  use HasFactory;

  public $table = 'kegiatan';

  protected $fillable = [
    'format_no',
    'nama_kegiatan',
    'slug',
    'penyelenggara',
    'tempat',
    'tgl_mulai',
    'tgl_selesai',
    'jam_mulai',
    'jumlah_jam',
    'tgl_sertifikat',
    'pejabat',
    'jabatan',
    'nip',
    'nik',
    'template',
    'user_id',
  ];

  public function pesertas()
  {
    return $this->hasMany(Peserta::class, 'kegiatan_id', 'id');
  }
}
