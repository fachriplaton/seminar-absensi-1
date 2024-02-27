<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kegiatan;

class Peserta extends Model
{
  use HasFactory;

  public $table = 'peserta';

  protected $fillable = ['nama_peserta', 'asal_instansi', 'no_tlp', 'no_peserta', 'no_urut', 'kegiatan_id'];

  // public function kegiatan()
  // {
  //   return $this->belongsTo(Kegiatan::class);
  // }

  // public function pendaftaran()
  // {
  //   return $this->belongsTo(Pendaftaran::class);
  // }
}
