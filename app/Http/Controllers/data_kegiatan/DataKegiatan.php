<?php

namespace App\Http\Controllers\data_kegiatan;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DataKegiatan extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('content.data-kegiatan.data-kegiatan-view');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // dd($request->jam_mulai);
    $addData = Kegiatan::create([
      'format_no' => 'tes',
      'nama_kegiatan' => $request->nama_keg,
      'slug' => 'slug',
      'penyelenggara' => $request->penyelenggara,
      'tempat' => $request->tempat,
      'tgl_mulai' => $request->tgl_mulai,
      'tgl_selesai' => $request->tgl_selesai,
      'jumlah_jam' => $request->jumlah_jam,
      'jam_mulai' => $request->jam_mulai,
      'tgl_sertifikat' => '',
      'pejabat' => $request->pejabat,
      'jabatan' => '',
      'nip' => '123',
      'nik' => '345',
      'template' => '',
    ]);

    $addData->save();
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    //
  }

  public function getDataKegiatan()
  {
    $data = $data = Kegiatan::select('*')->withCount('pesertas');
    // dd($data->kegiatan_id);
    // dd($data);
    return DataTables::of($data)

      ->addColumn('action', function ($data) {
        return '<a href="' .
          route('data-kegiatan-peserta.show', ['data_kegiatan_pesertum' => $data['id']]) .
          '"><button class="btn btn-secondary btn-sm" style="margin:5px" data-id="' .
          $data['id'] .
          '"> <i class="bx bxs-user"></i> <span style="margin-left:5px" class="badge bg-success">' .
          $data['pesertas_count'] .
          '</span></button></a>' .
          '<a href="' .
          route('ScanPeserta', ['id' => $data['id']]) .
          '"><button class="btn btn-success btn-sm" style="margin:5px" ><i class="bx bx-scan"></i></button></a>' .
          '<button class="btn btn-primary btn-sm" style="margin:5px" data-bs-toggle="modal" data-id="' .
          $data['id'] .
          '" id="editInstansiBtn"><i class="bx bx-edit"></i></button>' .
          '<button class="btn btn-danger btn-sm" style="margin:5px" data-bs-toggle="modal" data-bs-target="#delete' .
          $data['id'] .
          '"><i class="bx bx-trash"></i></button>';
      })
      ->rawColumns(['action'])
      ->make(true);
  }
}
