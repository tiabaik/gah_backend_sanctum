<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jumlah_Kamar;
use Validator;

class JumlahKamarController extends Controller
{
    public function add(Request $request)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'id_tipe'=>['required'],
            'id_reservasi'=>['required'],
            'jumlah_Kamar'=>['required'],
           
        ]);

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'message' => $validation->errors()
            ], 400);
        }

        $add = $request->all();
        $add = Jumlah_Kamar::create($add);
        
        if($add){
            return response()->json([
                'success' => true,
                'message' => $add
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal menambah jumlah Kamar'
        ], 400);        
    }

    public function edit(Request $request, $id)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'id_tipe'=>['required'],
            'id_reservasi'=>['required'],
            'jumlah_Kamar'=>['required'],
        ]);

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'message' => $validation->errors()
            ], 400);
        }

        $Jumlah_Kamar = Jumlah_Kamar::find($id);

        if($Jumlah_Kamar){
            $Jumlah_Kamar->id_tipe = $request->id_tipe;
            $Jumlah_Kamar->id_reservasi = $request->id_reservasi;
            $Jumlah_Kamar->jumlah_kamar = $request->jumlah_kamar;
            $Jumlah_Kamar->save();

            return response()->json([
                'success' => true,
                'message' => 'jumlah Kamar Berhasil Diubah',
                'data' => $Jumlah_Kamar
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'jumlah Kamar Gagal Diubah',
            'data' => ''
        ], 400);
    } 

    public function delete($id)
    {
        $Jumlah_Kamar = Jumlah_Kamar::find($id);

        if($Jumlah_Kamar){
            $Jumlah_Kamar->delete();

            return response()->json([
                'success' => true,
                'message' => 'jumlah Kamar Berhasil Dihapus',
                'data' => $Jumlah_Kamar
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'jumlah Kamar Gagal Dihapus',
            'data' => ''
        ], 400);
    }

    public function read()
    {
        $Data_Jumlah_Kamar = Jumlah_Kamar::with('Tipe_kamar', 'Reservasi')->get();
        return response()->json([
            'message' => 'Data jumlah Kamar',
            'data' => $Data_Jumlah_Kamar
        ],200);
    }

    public function search($id)
    {
        $Data_Jumlah_Kamar = Jumlah_Kamar::with('Tipe_kamar', 'Reservasi')->find($id);
        if($Data_Jumlah_Kamar){
            return response()->json([
                'message' => 'Data jumlah Kamar',
                'data' => $Data_Jumlah_Kamar
            ],200);

        }
        return response()->json([
            'success' => false,
            'message' => 'jumlah Kamar tidak ditemukan',
            'data' => ''
        ], 400);


    }

    

}
