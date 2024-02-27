<?php

namespace App\Http\Controllers\data_kegiatan;

use App\Http\Controllers\Controller;
use App\Imports\ImportPeserta;
use App\Models\Kegiatan;
use App\Models\Pendaftaran;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class DataPesertaKegiatan extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('content.data-kegiatan.data-peserta-kegiatan-view');
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
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
  {
    $id_kegiatan = $id;
    // dd($id_kegiatan);
    return view('content.data-kegiatan.data-peserta-kegiatan-view', compact('id_kegiatan'));
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

  public function getDataPesertaKegiatan($id)
  {
    $id_peserta = $id;
    // $data = Peserta::select('no_peserta')
    //   ->with('pendaftaran:id, nama_peserta, asal_instansi, no_tlp')
    //   ->with('kegiatan:id,nama_kegiatan')
    //   ->groupBy('no_peserta')
    //   ->get();
    $data = Peserta::select('*')->where('kegiatan_id', $id_peserta);

    return DataTables::of($data)
      ->addIndexColumn() // Kembalikan nomor urut
      ->addColumn(
        'check',
        function ($data) {
          return '<input type="checkbox" class="sub_chk" data-id="' . $data['id'] . '">';
        },
        false
      )
      ->addColumn('action', function ($data) {
        return '
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-id=' .
          $data['id'] .
          ' id="editInstansiBtn"><i class="bx bx-edit"></i></button>
            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete' .
          $data['id'] .
          '"><i class="bx bx-trash"></i></button>';
      })
      ->rawColumns(['DT_RowIndex', 'check', 'action'])
      ->make(true);
  }

  public function cekDataPeserta($id)
  {
    $peserta = Peserta::where('no_peserta', $id)->get();
    // dd($pendaftaran);
    return response()->json(['peserta' => $peserta]);
  }

  public function getDataDropdown()
  {
    $kegiatan = Kegiatan::get();
    // dd($kegiatan);
    // dd($pendaftaran);
    return response()->json(['kegiatan' => $kegiatan]);
  }

  public function import(Request $request)
  {
    $id_kegiatan = $request->id_kegiatan;

    ini_set('memory_limit', '512M');

    Excel::import(new ImportPeserta($id_kegiatan), request()->file('file'));
    return back();
  }

  public function deleteMultiSelect(Request $request)
  {
    // dd($request->id);
    $id = $request->id;

    // dd($id); // Hapus atau komentar kode ini karena sudah tidak diperlukan

    Peserta::whereIn('no_peserta', $id)->delete();
  }
}
