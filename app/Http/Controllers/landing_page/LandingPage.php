<?php

namespace App\Http\Controllers\landing_page;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
// use App\Models\Pendaftaran;
use App\Models\Peserta;
use Illuminate\Http\Request;

class LandingPage extends Controller
{
  public function index()
  {
    $data = Kegiatan::get();
    return view('content.landing-page.landing-page', compact('data'));
  }

  public function store(Request $request)
  {
    // dd($request->asal);
    $inisial = 'peserta';
    $random = rand(100, 999);

    $no_peserta = $inisial . $random;

    // Simpan data ke database
    $addData = Peserta::create([
      // 'no_urut' => 'null',
      'nama_peserta' => $request->nama,
      'no_peserta' => $no_peserta,
      'asal_instansi' => $request->asal,
      'no_tlp' => $request->no_tlp,
    ]);

    $addData->save();
  }

  public function getDataKegiatan($id)
  {
    $kegiatan = Kegiatan::find($id);

    return response()->json(['kegiatan' => $kegiatan]);
  }

  public function cekPeserta($id)
  {
    $peserta = peserta::find($id);

    return response()->json(['peserta' => $peserta]);
  }
}
