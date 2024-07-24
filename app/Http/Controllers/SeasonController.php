<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Season;
use Validator;
use Carbon\Carbon;

class SeasonController extends Controller
{
    public function add(Request $request)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'nama_season'=>['required'],
            'tanggal_mulai'=>['required','date','after:now + 2 months'],
            'tanggal_selesai'=>['required', 'date', 'after:tanggal_mulai'],
    
        ]);

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'first' => $validation->errors()->first(),
                'message' => $validation->errors()
            ], 400);
        }

        $add = $request->all();
        $add = season::create($add);
        
        if($add){
            return response()->json([
                'success' => true,
                'message' => $add
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal menambah season'
        ], 400);        
    }

    public function edit(Request $request, $id)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'nama_season'=>['required'],
            'tanggal_mulai'=>['required','date','after:now + 2 months'],
            'tanggal_selesai'=>['required', 'date', 'after:tanggal_mulai'],
        ]);

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'first' => $validation->errors()->first(),
                'message' => $validation->errors()
            ], 400);
        }

        $season = season::find($id);
         
        if($season){
            $season->nama_season= $request->nama_season;
            $season->tanggal_mulai = $request->tanggal_mulai;
            $season->tanggal_selesai = $request->tanggal_selesai;
            $season->save();

            return response()->json([
                'success' => true,
                'message' => 'season Berhasil Diubah',
                'data' => $season
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'season Gagal Diubah',
            'data' => ''
        ], 400);
    } 

    public function delete($id)
    {
        $season = season::find($id);
        // Get the current date and time
        $now = Carbon::now();


        // Add 2 months to the current date
        $twoMonthsFromNow = $now->addMonths(2);
        if($season->tanggal_mulai<$twoMonthsFromNow ){

            return response()->json([
                'success' => false,
                'message' => 'Hapus season harus lebih dari 2 bulan sebalum season itu dimulai',
                'data' => ""
            ], 400);
        }
        else if($season){
            $season->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'season Berhasil Dihapus',
                'data' => $season
            ], 200);
            
            
        }

        return response()->json([
            'success' => false,
            'message' => 'season Gagal Dihapus',
            'data' => ''
        ], 400);
    }

    public function read()
    {
        $Data_season = season::all();
        return response()->json([
            'message' => 'Data season',
            'data' => $Data_season
        ],200);
    }

    public function search($id)
    {
        $Data_season = season::find($id);
        if($Data_season){
            return response()->json([
                'message' => 'Data season',
                'data' => $Data_season
            ],200);

        }
        return response()->json([
            'success' => false,
            'message' => 'season tidak ditemukan',
            'data' => ''
        ], 400);


    }

    

}
