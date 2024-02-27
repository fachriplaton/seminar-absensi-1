<?php

namespace App\Imports;

use App\Models\Peserta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ImportPeserta implements ToModel, WithChunkReading
{
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  private $id_kegiatan;
  public function __construct($id_kegiatan)
  {
    $this->id_kegiatan = $id_kegiatan; // Mengatur nilai id_kegiatan
  }
  public function model(array $row)
  {
    $inisial = 'peserta';
    $random = rand(100, 999);

    $no_peserta = $inisial . $random;

    return new Peserta([
      'nama_peserta' => $row[0],
      'no_peserta' => $no_peserta,
      'asal_instansi' => $row[1],
      'no_urut' => 'xx',
      'kegiatan_id' => $this->id_kegiatan,
      'no_tlp' => $row[2],
      'status_absen' => 0,
      //
    ]);
  }

  public function chunkSize(): int
  {
    return 10000; // Sesuaikan dengan ukuran chunk yang diinginkan
  }
}
