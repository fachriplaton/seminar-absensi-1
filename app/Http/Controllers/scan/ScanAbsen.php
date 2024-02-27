<?php

namespace App\Http\Controllers\scan;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ScanAbsen extends Controller
{
  public function index()
  {
    return view('content.scan.scan-absen-view');
  }

  public function store(Request $request)
  {
    // dd($request->asal);
    $inisial = 'peserta';
    $random = rand(100, 999);

    $no_peserta = $inisial . $random;

    // Simpan data ke database
    $addData = Peserta::create([
      'nama_peserta' => $request->nama,
      'no_peserta' => $no_peserta,
      'asal_instansi' => $request->asal,
      'no_tlp' => $request->no_tlp,
    ]);

    $addData->save();
  }

  public function DataPeserta($no_peserta)
  {
    $data = Peserta::where('no_peserta', $no_peserta)->first();
    // dd($data);
    return response()->json(['data' => $data]);
  }
  public function ScanPeserta($id)
  {
    $id_kegiatan = $id;
    $data_kegiatan = Kegiatan::find($id);
    // dd($data_kegiatan->nama_kegiatan);

    return view('content.scan.scan-absen-view', compact('data_kegiatan'));
  }

  public function UpdateAbsenPeserta(Request $request)
  {
    $id_peserta = $request->id_peserta;
    $id_kegiatan = $request->id_kegiatan;

    $waktu_sekarang = Carbon::now();
    $waktu_30_menit_sebelumnya = $waktu_sekarang->copy()->subMinutes(30);
    $peserta = Peserta::leftJoin('kegiatan', 'peserta.kegiatan_id', '=', 'kegiatan.id')
      ->where('peserta.no_peserta', '=', $id_peserta)
      ->where('status_absen', '=', 0)
      ->where('kegiatan.id', '=', $id_kegiatan)
      // ->whereTime('kegiatan.jam_mulai', '>=', $waktu_30_menit_sebelumnya)
      // ->where('kegiatan.tgl_selesai', '<=', $waktu_sekarang)
      ->select('peserta.*')
      ->first();

    // dd($peserta);

    if ($peserta) {
      $peserta->status_absen = 1;
      $peserta->save();

      return response()->json(
        [
          'message' => 'Peserta berhasil melakukan absen',
          'nama_peserta' => $peserta->nama_peserta,
          'nama_kegiatan' => $peserta->nama_kegiatan,
        ],
        200
      );
    } else {
      return response()->json(
        ['message' => 'Absen gagal, peserta tidak dapat melakukan absen dalam rentang waktu yang diperbolehkan'],
        400
      );
    }
    // dd($request->id);
  }
}
