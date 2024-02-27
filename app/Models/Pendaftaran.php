<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
  use HasFactory;

  public $table = 'pendaftaran';

  protected $fillable = ['nama_peserta', 'no_peserta', 'asal_instansi', 'no_tlp'];

  // public function pesertas()
  // {
  //   return $this->hasMany(Peserta::class, 'no_peserta', 'no_peserta');
  // }
}
