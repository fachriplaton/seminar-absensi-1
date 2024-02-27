<?php

namespace App\Http\Controllers\data_pendaftaran;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Pendaftaran;
use App\Models\Peserta;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\QrCode;

class DataPendaftaran extends Controller
{
  public function index()
  {
    $kegiatan = Kegiatan::get();
    return view('content.data-pendaftaran.data-pendaftaran-view', compact('kegiatan'));
  }

  public function show($id)
  {
  }

  public function getData()
  {
    $data = Peserta::leftJoin('kegiatan', 'kegiatan.id', '=', 'peserta.kegiatan_id')
      ->select(
        'peserta.no_peserta',
        'peserta.nama_peserta',
        'asal_instansi',
        'no_tlp',
        DB::raw('MAX(kegiatan.nama_kegiatan) as nama_kegiatan')
      )
      ->groupBy('peserta.no_peserta', 'peserta.nama_peserta', 'peserta.asal_instansi', 'peserta.no_tlp');
    // ->query();
    // ->get();

    return DataTables::of($data)
      ->addColumn('action', function ($data) {
        return '
        <button class="btn btn-primary btn-sm" data-id=' .
          $data->no_peserta .
          ' id="qrcode"><i class="bx bx-qr"></i></button>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-id=' .
          $data->no_peserta .
          ' id="editInstansiBtn"><i class="bx bx-edit"></i></button>
        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-id=' .
          $data->no_peserta .
          ' id="kegiatan">daftar kegiatan <span style="margin-left:5px" class="badge bg-success">1</span> </button>
        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete' .
          $data->no_peserta .
          '"><i class="bx bx-trash"></i></button>
        ';
      })
      ->rawColumns(['action'])
      ->make(true);

    // dd($peserta);
    // return $peserta;
  }

  public function generateQr(Request $request)
  {
    $no_peserta = $request->id;
    // Buat QR Code menggunakan Endroid
    $qrCode = QrCode::create($no_peserta)
      ->setEncoding(new Encoding('UTF-8'))
      ->setSize(300)
      ->setMargin(10)
      ->setForegroundColor(new Color(0, 0, 0))
      ->setBackgroundColor(new Color(255, 255, 255));

    // $logo = Logo::create(public_path('/assets/icon/logoblitar.png'))
    //   ->setResizeToWidth(50)
    //   ->setPunchoutBackground(true);

    // Buat URI data QR Code
    $dataUri = (new PngWriter())->write($qrCode)->getDataUri();

    return response()->json(['qrcode' => $dataUri, 'id' => $request->id]);
  }

  public function addKegiatan(Request $request)
  {
    $noPeserta = $request->input('no_peserta');
    $peserta = Peserta::where('no_peserta', $noPeserta)->first();
    // dd($peserta);
    $selectedKegiatan = json_decode($request->input('selectedKegiatan'), true);

    // Simpan data kegiatan ke database
    foreach ($selectedKegiatan as $keg) {
      // Menambahkan validasi untuk memastikan id_kegiatan belum ada
      if (!$this->cekKegiatanAda($keg, $noPeserta)) {
        // dd('error');
        return redirect()
          ->back()
          ->withErrors(['selectedKeg' => 'Kegiatan dengan ID ' . $keg . ' sudah ada.'])
          ->withInput();
      }

      $addData = Peserta::create([
        'nama_peserta' => $peserta->nama_peserta,
        'asal_instansi' => $peserta->asal_instansi,
        'no_tlp' => $peserta->no_tlp,
        'no_urut' => 'xx', // Anda dapat menyesuaikan ini sesuai kebutuhan
        'no_peserta' => $noPeserta,
        'kegiatan_id' => $keg,
      ]);

      $addData->save();
    }
  }

  private function cekKegiatanAda($idKegiatan, $noPeserta)
  {
    // dd('masuk cek kegiatan');
    $peserta = Peserta::where('id', $idKegiatan)
      ->where('no_peserta', $noPeserta)
      ->exists();
    // dd($peserta);
    return Peserta::where('id', $idKegiatan)
      ->where('no_peserta', $noPeserta)
      ->exists();
  }
}
