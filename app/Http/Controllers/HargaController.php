<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harga;
use Validator;
use Illuminate\Support\Facades\DB;

class HargaController extends Controller
{
    public function add(Request $request)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'id_tipe'=>['required'],
            'id_season'=>['required'],
            'harga'=>['required'],
           
        ]);

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'first' => $validation->errors()->first(),
                'message' => $validation->errors()
            ], 400);
        }

        $add = $request->all();
        $add = harga::create($add);
        
        if($add){
            return response()->json([
                'success' => true,
                'message' => $add
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal menambah harga'
        ], 400);        
    }

    public function edit(Request $request, $id)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'id_tipe'=>['required'],
            'id_season'=>['required'],
            'harga'=>['required'],
        ]);

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'first' => $validation->errors()->first(),
                'message' => $validation->errors()
            ], 400);
        }

        $harga = harga::find($id);

        if($harga){
            $harga->id_tipe = $request->id_tipe;
            $harga->id_season = $request->id_season;
            $harga->harga = $request->harga;
            $harga->save();

            return response()->json([
                'success' => true,
                'message' => 'harga Berhasil Diubah',
                'data' => $harga
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'harga Gagal Diubah',
            'data' => ''
        ], 400);
    } 

    public function delete($id)
    {
        $harga = harga::find($id);

        if($harga){
            $harga->delete();

            return response()->json([
                'success' => true,
                'message' => 'harga Berhasil Dihapus',
                'data' => $harga
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'harga Gagal Dihapus',
            'data' => ''
        ], 400);
    }

    public function read()
    {
        $data =  DB::table('harga')
        ->select('harga.*', 'season.*', 'tipe_kamar.*', 'tipe_kamar.harga AS Harga_Kamar', 'harga.harga AS harga_akhir', 'harga.id as id')
        ->leftJoin('season', 'harga.id_season', '=', 'season.id')
        ->leftJoin('tipe_kamar', 'harga.id_tipe', '=', 'tipe_kamar.id')
        ->get();
            if($data){
                return response()->json([
                    'message' => 'Data Harga',
                    'data' => $data
                ],200);
    
            }
            return response()->json([
                'success' => false,
                'message' => 'Harga tidak ditemukan',
                'data' => ''
            ], 400);
    }

    public function search($id)
    {
        $Data_harga = harga::with('Tipe_kamar', 'Season')->find($id);
        if($Data_harga){
            return response()->json([
                'message' => 'Data harga',
                'data' => $Data_harga
            ],200);

        }
        return response()->json([
            'success' => false,
            'message' => 'harga tidak ditemukan',
            'data' => ''
        ], 400);


    }

    public function readHarga($id){
        $data = DB::table('harga')
        ->select('harga.*', 'season.*', 'tipe_kamar.*', 'tipe_kamar.harga AS Harga_Kamar', 'harga.harga AS harga_akhir')
        ->leftJoin('season', 'harga.id_season', '=', 'season.id')
        ->leftJoin('tipe_kamar', 'harga.id_tipe', '=', 'tipe_kamar.id')
        ->where('harga.id', $id)
        ->first();
            if($data){
                return response()->json([
                    'message' => 'Data HARGA',
                    'data' => $data
                ],200);
    
            }
            return response()->json([
                'success' => false,
                'message' => 'HARGA tidak ditemukan',
                'data' => ''
            ], 400);
        
    }

    

}
