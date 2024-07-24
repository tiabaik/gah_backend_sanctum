<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use Validator;
use Illuminate\Support\Facades\DB;


class KamarController extends Controller
{
    public function add(Request $request)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'id'=>['required', 'numeric', 'unique:kamar'],
            'id_tipe'=>['required'],
            'status_ketersedian_kamar'=>['required'],
            'deskripsi'=>['required'],
            'kapasitas'=>['required'],
            'pilihan_bad'=>['required'],
        ]);

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'first' => $validation->errors()->first(),
                'message' => $validation->errors()
            ], 400);
        }

        $add = $request->all();
        $add = Kamar::create($add);
        
        if($add){
            return response()->json([
                'success' => true,
                'message' => $add
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal menambah kamar'
        ], 400);        
    }

    public function edit(Request $request, $id)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'id'=>['required','numeric'],
            'id_tipe'=>['required'],
            'status_ketersedian_kamar'=>['required'],
            'deskripsi'=>['required'],
            'kapasitas'=>['required'],
            'pilihan_bad'=>['required'],
        ]);

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'first' => $validation->errors()->first(),
                'message' => $validation->errors()
            ], 400);
        }

        $kamar = Kamar::find($id);

        if($kamar){
            $kamar->id = $request->id;
            $kamar->id_tipe = $request->id_tipe;
            $kamar->status_ketersedian_kamar = $request->status_ketersedian_kamar;
            $kamar->deskripsi = $request->deskripsi;
            $kamar->kapasitas = $request->kapasitas;
            $kamar->pilihan_bad = $request->pilihan_bad;
            $kamar->save();

            return response()->json([
                'success' => true,
                'message' => 'Kamar Berhasil Diubah',
                'data' => $kamar
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Kamar Gagal Diubah',
            'data' => ''
        ], 400);
    } 

    public function delete($id)
    {
        $kamar = Kamar::find($id);

        if($kamar){
            $kamar->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kamar Berhasil Dihapus',
                'data' => $kamar
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Kamar Gagal Dihapus',
            'data' => ''
        ], 400);
    }

    public function read()
    {
        $data = DB::table('kamar')
        ->select('kamar.id AS nomor_kamar', 'tipe_kamar.*', 'harga.*', 'kamar.*', 'harga.harga AS harga_akhir')
        ->leftJoin('tipe_kamar', 'kamar.id_tipe', '=', 'tipe_kamar.id')
        ->leftJoin(DB::raw('(SELECT id_tipe, MAX(id) AS latest_harga_id FROM harga GROUP BY id_tipe) latest_harga_ids'), 'tipe_kamar.id', '=', 'latest_harga_ids.id_tipe')
        ->leftJoin('harga', 'latest_harga_ids.latest_harga_id', '=', 'harga.id')
        ->get();
            if($data){
                return response()->json([
                    'message' => 'Data Reservasi',
                    'data' => $data
                ],200);
    
            }
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak ditemukan',
                'data' => ''
            ], 400);
    
    }

    

    public function search($id)
    {
        $Data_kamar = Kamar::with('Tipe_kamar')->find($id);
        if($Data_kamar){
            return response()->json([
                'message' => 'Data Kamar',
                'data' => $Data_kamar
            ],200);

        }
        return response()->json([
            'success' => false,
            'message' => 'Kamar tidak ditemukan',
            'data' => ''
        ], 400);


    }

    public function readKamar($id)
    {
        $data = DB::table('kamar')
        ->select('kamar.id AS nomor_kamar', 'tipe_kamar.*', 'harga.*', 'kamar.*', 'harga.harga AS harga_akhir')
        ->leftJoin('tipe_kamar', 'kamar.id_tipe', '=', 'tipe_kamar.id')
        ->leftJoin('harga', 'harga.id_tipe', '=', 'tipe_kamar.id')
        ->where('kamar.id', $id)
        ->first();
            if($data){
                return response()->json([
                    'message' => 'Data Reservasi',
                    'data' => $data
                ],200);
    
            }
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak ditemukan',
                'data' => ''
            ], 400);
    
    }

    public function readavilable()
    {
        $data =  DB::table('kamar')
        ->select('kamar.id', 'tipe_kamar.nama_tipe', 'kamar.status_ketersedian_kamar')
        ->leftJoin('tipe_kamar', 'kamar.id_tipe', '=', 'tipe_kamar.id')
        ->where('kamar.status_ketersedian_kamar', '=', 'available')
        ->get();
            if($data){
                return response()->json([
                    'message' => 'Data Kamar',
                    'data' => $data
                ],200);
    
            }
            return response()->json([
                'success' => false,
                'message' => 'Kamar tidak ditemukan',
                'data' => ''
            ], 400);
    
    }
    

    

    

}
