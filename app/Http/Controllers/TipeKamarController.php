<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class TipeKamarController extends Controller
{
    public function read($id)
    {
                $data = DB::table('kamar')
            ->select('harga.*', DB::raw('`tipe_kamar`.`nama_tipe`'))
            ->leftJoin('tipe_kamar', 'kamar.id_tipe', '=', 'tipe_kamar.id')
            ->leftJoin(DB::raw('(SELECT id_tipe, MAX(id) AS latest_harga_id FROM harga GROUP BY id_tipe) AS latest_harga_ids'), function ($join) {
                $join->on('tipe_kamar.id', '=', 'latest_harga_ids.id_tipe');
            })
            ->leftJoin('harga', 'latest_harga_ids.latest_harga_id', '=', 'harga.id')
            ->where('tipe_kamar.id', '=', $id)
            ->first();


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

    public function roomCheck(Request $request)
    {   $data = $request->all();
        $validation = Validator::make($data, [
            'tgl_cek_in'=> ['required','date'],
            'tgl_cek_out'=> ['required', 'date'],
            'org_dewasa'=> ['required', 'integer'],
            'org_anak'=> ['required', 'integer'],
            'permintaan_khusus' =>['required', 'string'],
        ]);

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'first' => $validation->errors()->first(),
                'message' => $validation->errors()
            ], 400);
        }

        $startDate = $request->input('tgl_cek_in');
        $endDate = $request->input('tgl_cek_out');
        
        $result = DB::table('tipe_kamar AS tk')
        ->select('tk.nama_tipe AS TipeKamar', 'tk.id AS TipeKamarID')
        ->selectRaw('COUNT(k.id) - IFNULL(SUM(CASE WHEN r.tgl_cek_in <= ? AND r.tgl_cek_out >= ? THEN 1 ELSE 0 END), 0) AS JumlahKamarTersedia', [$endDate, $startDate])
        ->leftJoin('kamar AS k', 'tk.id', '=', 'k.id_tipe')
        ->leftJoin('booking_kamar AS bk', 'k.id', '=', 'bk.id_kamar')
        ->leftJoin('reservasi AS r', 'bk.id_reservasi', '=', 'r.id')
        ->where(function ($query) use ($startDate, $endDate) {
            $query->where(function ($q) use ($startDate, $endDate) {
                $q->where(function ($innerQ) use ($startDate, $endDate) {
                    $innerQ->where('r.tgl_cek_in', '>', $endDate)
                        ->orWhere('r.tgl_cek_out', '<', $startDate);
                })
                ->orWhereNull('r.tgl_cek_in');
            });
        })
        ->groupBy('tk.nama_tipe', 'tk.id')
        ->orderBy('tk.id')
        ->get();
            
            if($result){
                return response()->json([
                    'message' => 'Data Kamar',
                    'data' => $result
                ],200);
    
            }
            return response()->json([
                'success' => false,
                'message' => 'Kamar tidak ditemukan',
                'data' => ''
            ], 400);
    
    }
}
