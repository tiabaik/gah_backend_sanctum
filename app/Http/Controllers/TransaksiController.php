<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Reservasi;
use Validator;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function add(Request $request)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'id_reservasi'=>['required'],
            'jumlah_pembayaran'=>['required'],
            'total_pembayaran'=>['required'],
            'tax'=>['required'],
            'diskon'=>['required'],
            'total_akhir_pembayaran' =>['required']
           
        ]);

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'first' => $validation->errors()->first(),
                'message' => $validation->errors()
            ], 400);
        }
        $reservasi = Reservasi::findOrFail($data['id_reservasi']);

        $add = $request->all();
        $add['id_pegawai'] = Auth::user()->id;
        $add['tgl_transaksi'] = now()->format('Y-m-d H:i:s'); 
        $add['id'] = $this->generateid($reservasi->id_jenis_custumer);
        $add = transaksi::create($add);
        
        if($add){
            return response()->json([
                'success' => true,
                'message' => $add
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal menambah transaksi'
        ], 400);        
    }

    private function generateId($idJenisCustumer)
        {
            $formatId = ($idJenisCustumer == 1) ? 'P' : 'G';
            $formatId .= now()->format('ymd');

            // Mendapatkan increment dari id reservasi
            $increment = Reservasi::max('id') + 1;

            // Menggabungkan increment ke dalam format kode booking
            $id = $formatId . '-' . str_pad($increment, 3, '0', STR_PAD_LEFT);

            return $id;
        }

    public function edit(Request $request, $id)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'id'=>['required'],
            'id_pegawai'=>['required'],
            'id_reservasi'=>['required'],
            'tgl_transaksi'=>['required'],
            'jumlah_pembayaran'=>['required'],
            'total_pembayaran'=>['required'],
            'tax'=>['required'],
            'diskon'=>['required'],
            'total_akhir_pembayaran' =>['required'],
        ]);

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'message' => $validation->errors()
            ], 400);
        }

        $transaksi = transaksi::find($id);

        if($transaksi){
            $transaksi->id = $request->id;
            $transaksi->id_pegawai = $request->id_pegawai;
            $transaksi->id_reservasi = $request->id_reservasi;
            $transaksi->tgl_transaski = $request->tgl_transaksi;
            $transaksi->jumlah_pembayaran = $request->jumlah_pembayaran;
            $transaksi->total_pembayaran = $request->total_pembayaran;
            $transaksi->tax = $request->tax;
            $transaksi->diskon = $request->diskon;
            $transaksi->total_akhir_pembayaran = $request->total_akhir_pembayaran;
            
            $transaksi->save();

            return response()->json([
                'success' => true,
                'message' => 'transaksi Berhasil Diubah',
                'data' => $transaksi
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'transaksi Gagal Diubah',
            'data' => ''
        ], 400);
    } 

    public function delete($id)
    {
        $transaksi = transaksi::find($id);

        if($transaksi){
            $transaksi->delete();

            return response()->json([
                'success' => true,
                'message' => 'transaksi Berhasil Dihapus',
                'data' => $transaksi
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'transaksi Gagal Dihapus',
            'data' => ''
        ], 400);
    }

    public function read()
    {
        $Data_transaksi = transaksi::with('Pegawai', 'Reservasi')->get();
        return response()->json([
            'message' => 'Data transaksi',
            'data' => $Data_transaksi
        ],200);
    }

    public function search($id)
    {
        $Data_transaksi = transaksi::with('Pegawai', 'Reservasi')->find($id);
        if($Data_transaksi){
            return response()->json([
                'message' => 'Data transaksi',
                'data' => $Data_transaksi
            ],200);

        }
        return response()->json([
            'success' => false,
            'message' => 'transaksi tidak ditemukan',
            'data' => ''
        ], 400);

    }

    public function notaLunas( $id) {
    
        $reservasi =  DB::table('reservasi')
        ->select(
            'reservasi.kode_booking',
            'reservasi.tgl_reservasi',
            'reservasi.uang_jaminan',
            'reservasi.uang_deposit',
            DB::raw("DATE_FORMAT(reservasi.tgl_cek_in, '%d %M %Y') as tgl_cek_in_formatted"),
            DB::raw("DATE_FORMAT(reservasi.tgl_cek_out, '%d %M %Y') as tgl_cek_out_formatted"),
            'reservasi.org_dewasa',
            'reservasi.org_anak',
            DB::raw("DATE_FORMAT(reservasi.tgl_uang_jaminan, '%d %M %Y') as tgl_uang_jaminan_formatted"),
            'custumer.nama as nama_custumer',
            'custumer.alamat as alamat_custumer',
            'pegawai.nama as nama_pegawai'
        )
        ->leftJoin('custumer', 'reservasi.id_custumer', '=', 'custumer.id')
        ->leftJoin('pegawai', 'reservasi.id_pegawai', '=', 'pegawai.id')
        ->where('reservasi.id', $id)
        ->first();

        

$kamar = DB::table('reservasi')
    ->leftJoin('jumlah_kamar', 'jumlah_kamar.id_reservasi', '=', 'reservasi.id')
    ->leftJoin('tipe_kamar', 'jumlah_kamar.id_tipe', '=', 'tipe_kamar.id')
    ->leftJoin(DB::raw('(SELECT id_tipe, MAX(id) AS latest_harga_id FROM harga GROUP BY id_tipe) latest_harga_ids'), function($join) {
        $join->on('tipe_kamar.id', '=', 'latest_harga_ids.id_tipe');
    })
    ->leftJoin('harga', 'latest_harga_ids.latest_harga_id', '=', 'harga.id')
    ->leftJoin('booking_kamar', 'booking_kamar.id_reservasi', '=', 'reservasi.id')
    ->leftJoin('kamar', 'kamar.id', '=', 'booking_kamar.id_kamar')
    ->select(
        'tipe_kamar.nama_tipe',
        'harga.harga AS harga',
        'jumlah_kamar.jumlah_kamar',
        'kamar.pilihan_bad',
        DB::raw('jumlah_kamar.jumlah_kamar * harga.harga AS total'),
        DB::raw('SUM(jumlah_kamar.jumlah_kamar * harga.harga) OVER () AS total_bayar')
    )
    ->where('reservasi.id', $id)
    ->get();


        $layanan = DB::table('reservasi')
        ->select('reservasi.id', 'booking_fasilitas.*', 'fasilitas.*', 'reservasi.permintaan_khusus',
        DB::raw('booking_fasilitas.jumlah_booking_fasilitas * fasilitas.harga_fasilitas as total'),
        DB::raw('SUM(booking_fasilitas.jumlah_booking_fasilitas * fasilitas.harga_fasilitas) OVER () as total_bayar')
       )
        ->leftJoin('booking_fasilitas', 'booking_fasilitas.id_reservasi', '=', 'reservasi.id')
        ->leftJoin('fasilitas', 'booking_fasilitas.id_fasilitas', '=', 'fasilitas.id')
        ->where('reservasi.id', $id)
        ->get();

    
        $transaksi = DB::table('transaksi')
        ->select('transaksi.*', 'reservasi.id as reservasi_id', 'pegawai.nama')
        ->leftJoin('reservasi', 'transaksi.id_reservasi', '=', 'reservasi.id')
        ->leftJoin('pegawai', 'reservasi.id_pegawai', '=', 'pegawai.id')
        ->where('reservasi.id', $id)
        ->first();

        // dd($transaksi);
      
        
        $pdf = PDF::loadView('NotaLunas', compact('reservasi', 'kamar', 'layanan','transaksi'));
        return $pdf->stream('NotaLunas.pdf');
        
    }

    

}
