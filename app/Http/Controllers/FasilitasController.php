<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas;
use Validator;

class FasilitasController extends Controller
{
    public function add(Request $request)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'nama_fasilitas'=>['required'],
            'harga_fasilitas'=>['required'],
            
        ]);

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'first' => $validation->errors()->first(),
                'message' => $validation->errors()
            ], 400);
        }

        $add = $request->all();
        $add = fasilitas::create($add);
        
        if($add){
            return response()->json([
                'success' => true,
                'first' => $validation->errors()->first(),
                'message' => $add
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal menambah fasilitas'
        ], 400);        
    }

    public function edit(Request $request, $id)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'nama_fasilitas'=>['required'],
            'harga_fasilitas'=>['required'],
        ]);

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'first' => $validation->errors()->first(),
                'message' => $validation->errors()
            ], 400);
        }

        $fasilitas = fasilitas::find($id);
         
        if($fasilitas){
            $fasilitas->nama_fasilitas= $request->nama_fasilitas;
            $fasilitas->harga_fasilitas = $request->harga_fasilitas;
            $fasilitas->save();

            return response()->json([
                'success' => true,
                'message' => 'fasilitas Berhasil Diubah',
                'data' => $fasilitas
            ], 200);
        }

        return response()->json([
            'success' => false,
            'first' => $validation->errors()->first(),
            'message' => 'fasilitas Gagal Diubah',
            'data' => ''
        ], 400);
    } 

    public function delete($id)
    {
        $fasilitas = fasilitas::find($id);

        if($fasilitas){
            $fasilitas->delete();

            return response()->json([
                'success' => true,
                'message' => 'fasilitas Berhasil Dihapus',
                'data' => $fasilitas
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'fasilitas Gagal Dihapus',
            'data' => ''
        ], 400);
    }

    public function read()
    {
        $Data_fasilitas = fasilitas::all();
        return response()->json([
            'message' => 'Data fasilitas',
            'data' => $Data_fasilitas
        ],200);
    }

    public function search($id)
    {
        $Data_fasilitas = fasilitas::find($id);
        if($Data_fasilitas){
            return response()->json([
                'message' => 'Data fasilitas',
                'data' => $Data_fasilitas
            ],200);

        }
        return response()->json([
            'success' => false,
            'message' => 'fasilitas tidak ditemukan',
            'data' => ''
        ], 400);


    }

    

}
