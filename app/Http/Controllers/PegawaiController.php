<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Validator;

class PegawaiController extends Controller
{
    public function registerPegawai(Request $request)
    {
        // Validasi data pelanggan yang dikirim melalui request
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'no_identitas' => 'required',
            'no_telp' => 'required|unique:pegawai|unique:pegawai',
            'email' => 'required|email|unique:pegawai|unique:pegawai',
            'alamat' => 'required',
            'password' => 'required|confirmed',
            'role_pegawai' => 'required',
            'tgl_lahir' =>'required|date',
        ]);

        
        $data = $request->all();
        $data['password'] = bcrypt($validatedData['password']); // Anda sebaiknya mengenkripsi password
        $customer = Pegawai::create($data);
        
        

        $token = $customer->CreateToken('Token')->accessToken;

        return response()->json([
            'message' => 'Pegawai berhasil diregistrasi',
            'data' => $customer,
            'token' => $token
        ], 200);
    }

    public function search()
    {
        $id = Auth::user()->id;
        $Data_pegawai = pegawai::find($id);
        if($Data_pegawai){
            return response()->json([
                'message' => 'Data Pegawai',
                'data' => $Data_pegawai
            ],200);

        }
        return response()->json([
            'success' => false,
            'message' => 'Pegawai tidak ditemukan',
            'data' => ''
        ], 400);


    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'nama' => 'required|string',
            'no_identitas' => 'required',
            'no_telp' => 'required|unique:custumer|unique:pegawai',
            'email' => 'required|email|unique:custumer|unique:pegawai',
            'alamat' => 'required',

        ]);

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'first' => $validation->errors()->first(),
                'message' => $validation->errors()
            ], 400);
        }
        $id = Auth::user()->id;
        $pegawai = pegawai::find($id);
         
        if($pegawai){
            $input['nama']= $request->nama;
            $input['email']= $request->email;
            $input['no_identitas'] = $request->no_identitas;
            $input['no_telp']= $request->no_telp;
            $input['alamat'] = $request->alamat;
            $pegawai->update($input);

            return response()->json([
                'success' => true,
                'message' => 'Pegawai Berhasil Diubah',
                'data' => $input
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Pegawai Gagal Diubah',
            'data' => ''
        ], 400);
    } 
}
