<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;
use App\Models\Booking_Kamar;
use App\Models\Kamar;

class ReservasiController extends Controller
{
    public function addPersonal(Request $request)
    {
        $data = $request->all();
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
        // dd(Auth::user()->id);

        $add = $request->all();
        $add['id_custumer'] = Auth::user()->id;
        $add['id_jenis_custumer'] = 1;
        $add['tgl_reservasi'] = now()->format('Y-m-d H:i:s'); 
        $add['status_reservasi']= 'ON GOING';
        $add = Reservasi::create($add);


        if($request->input('superior')>0 ){
            DB::table('jumlah_kamar')->insert([
                'id_tipe' => 1,
                'id_reservasi' => $add->id,
                'jumlah_kamar' => $request->input('superior')

            ]);
        }

        if($request->input('double_deluxe')>0 ){
            DB::table('jumlah_kamar')->insert([
                'id_tipe' => 2,
                'id_reservasi' => $add->id,
                'jumlah_kamar' => $request->input('double_deluxe')

            ]);
        }

        if($request->input('exclusive_deluxe')>0 ){
            DB::table('jumlah_kamar')->insert([
                'id_tipe' => 3,
                'id_reservasi' => $add->id,
                'jumlah_kamar' => $request->input('exclusive_deluxe')

            ]);
        }

        if($request->input('junior_suite')>0 ){
            DB::table('jumlah_kamar')->insert([
                'id_tipe' => 4,
                'id_reservasi' => $add->id,
                'jumlah_kamar' => $request->input('junior_suite')

            ]);
        }
        if($request->input('fasilitas')){
            foreach ($request->input('fasilitas') as $data) {
                $input['id_reservasi'] = $add->id;
                $input['tgl_booking_fasilitas'] = now();
                $input['id_fasilitas'] = $data['id'];
                $input['jumlah_booking_fasilitas'] = $data['jumlah_booking_fasilitas'];
                DB::table('booking_fasilitas')->insert($input);
            }   
        }
        
        if($add){
            return response()->json([
                'success' => true,
                'message' => $add
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal menambah Reservasi'
        ], 400);        
    }

    public function edit(Request $request, $id)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'id_custumer'=> ['required'],
            'id_pegawai'=> ['required'],
            'id_jenis_custumer'=> ['required'],
            'tgl_reservasi'=> ['required'],
            'tgl_cek_in'=> ['required'],
            'tgl_cek_out'=> ['required'],
            'tgl_uang_jaminan'=> ['required'],
            'tgl_deposit'=> ['required'],
            'org_dewasa'=> ['required'],
            'org_anak'=> ['required'],
            'kode_booking'=> ['required'],
            'uang_deposit'=> ['required'],
            'uang_jaminan'=> ['required'],
            'status_reservasi'=> ['required'],
        ]);

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'message' => $validation->errors()
            ], 400);
        }

        $Reservasi = Reservasi::find($id);

        if($Reservasi){
            $Reservasi->id_custumer = $request->id_custumer;
            $Reservasi->id_pegawai = $request->id_pegawai;
            $Reservasi->id_jenis_custumer = $request ->id_jenis_custumer;
            $Reservasi->tgl_reservasi = $Reservasi->tgl_reservasi;
            $Reservasi->tgl_cek_in = $Reservasi->tgl_cek_in;
            $Reservasi->tgl_cek_out = $Reservasi->tgl_cek_out;
            $Reservasi->tgl_uang_jaminan = $Reservasi->tgl_uang_jaminan;
            $Reservasi->tgl_deposit = $Reservasi->tgl_deposit;
            $Reservasi->org_dewasa = $Reservasi->org_dewasa;
            $Reservasi->org_anak = $Reservasi->org_anak;
            $Reservasi->kode_booking = $Reservasi->kode_booking;
            $Reservasi->uang_deposit = $Reservasi->uang_deposit;
            $Reservasi->uang_jaminan = $Reservasi->uang_jaminan;
            $Reservasi->status_reservasi = $Reservasi->status_reservasi;
            $Reservasi->permintaan_khusus = $Reservasi->permintaan_khusus;
            $Reservasi->save();

            return response()->json([
                'success' => true,
                'message' => 'Reservasi Berhasil Diubah',
                'data' => $Reservasi
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Reservasi Gagal Diubah',
            'data' => ''
        ], 400);
    } 

    public function delete($id)
    {
        $Reservasi = Reservasi::find($id);

        if($Reservasi){
            $Reservasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Reservasi Berhasil Dihapus',
                'data' => $Reservasi
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Reservasi Gagal Dihapus',
            'data' => ''
        ], 400);
    }

    public function read()
    {
        $id = Auth::user()->id;
        $Data_Reservasi = Reservasi::with('Custumer', 'Pegawai', 'Jenis_Custumer')->where('id_custumer', $id)->get();
        return response()->json([
            'message' => 'Data Reservasi',
            'data' => $Data_Reservasi
        ],200);

        $result = DB::table('reservasi')
    ->leftJoin('custumer', 'reservasi.id_custumer', '=', 'custumer.id')
    ->select('reservasi.*', 'custumer.nama')
    ->get();
    }

    public function readSM()
    {
        $data =DB::table('reservasi')
        ->select('reservasi.*', 'custumer.nama', 'jenis_custumer.id', 'reservasi.id AS id_reservasi')
        ->leftJoin('custumer', 'reservasi.id_custumer', '=', 'custumer.id')
        ->leftJoin('jenis_custumer', 'reservasi.id_jenis_custumer', '=', 'jenis_custumer.id')
        ->where('jenis_custumer.id', '=', 2)
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

    public function readAll()
    {
        $data = DB::table('reservasi')
        ->leftJoin('custumer', 'reservasi.id_custumer', '=', 'custumer.id')
        ->select('reservasi.*', 'custumer.nama')
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
        $Data_Reservasi = Reservasi::with('Custumer', 'Pegawai', 'Jenis_Custumer')->find($id);
        if($Data_Reservasi){
            return response()->json([
                'message' => 'Data Reservasi',
                'data' => $Data_Reservasi
            ],200);

        }
        return response()->json([
            'success' => false,
            'message' => 'Reservasi tidak ditemukan',
            'data' => ''
        ], 400);


    }

    function detailReservasi($id){
        $data = DB::table('custumer')
        ->select('custumer.nama', 'reservasi.*')
        ->leftJoin('reservasi', 'reservasi.id_custumer', '=', 'custumer.id')
        ->where('reservasi.id', $id)
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

    
    

    function detailKamar($id)
        {
            $data =DB::table('reservasi')
            ->select('reservasi.*', 'jumlah_kamar.*', 'tipe_kamar.*', 'harga.*', 'harga.harga AS harga_akhir')
            ->leftJoin('jumlah_kamar', 'jumlah_kamar.id_reservasi', '=', 'reservasi.id')
            ->leftJoin('tipe_kamar', 'jumlah_kamar.id_tipe', '=', 'tipe_kamar.id')
            ->leftJoin(DB::raw('(SELECT id_tipe, MAX(id) AS latest_harga_id FROM harga GROUP BY id_tipe) latest_harga_ids'), 'tipe_kamar.id', '=', 'latest_harga_ids.id_tipe')
            ->leftJoin('harga', 'latest_harga_ids.latest_harga_id', '=', 'harga.id')
            ->where('reservasi.id', $id)
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
    
        function detailFasilitas($id){
            $data = DB::table('reservasi')
            ->select('reservasi.id', 'booking_fasilitas.*', 'fasilitas.*')
            ->leftJoin('booking_fasilitas', 'booking_fasilitas.id_reservasi', '=', 'reservasi.id')
            ->leftJoin('fasilitas', 'booking_fasilitas.id_fasilitas', '=', 'fasilitas.id')
            ->where('reservasi.id', $id)
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

        function detailTotalPembayaran($id){
            $data = DB::table('reservasi')
            ->select('reservasi.id', 'transaksi.*')
            ->leftJoin('transaksi', 'transaksi.id_reservasi', '=', 'reservasi.id')
            ->where('reservasi.id', $id)
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

        function detailProfileC($id){
            $data = DB::table('reservasi')
            ->select('reservasi.*', 'customer.*')
            ->leftJoin('customer', 'reservasi.id_customer', '=', 'customer.id')
            ->where('reservasi.id', $id)
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


        public function update(Request $request, $id)
    {
        // Validasi request sesuai kebutuhan Anda
        $request->validate([
            'uang_jaminan' => 'required|integer',
            
        ]);
      
        // Temukan reservasi berdasarkan ID
        $reservasi = Reservasi::findOrFail($id);

        // Update informasi reservasi
        $reservasi->tgl_uang_jaminan = now();
        $reservasi->uang_jaminan = $request->uang_jaminan;
        $reservasi->status_reservasi = 'Sudah Membayar Uang Jaminan';
        $reservasi->kode_booking = $this->generateKodeBooking($reservasi->id_jenis_custumer);
        // dd($reservasi);
        // Simpan perubahan
        $reservasi->save();

        // Redirect atau berikan respons sesuai kebutuhan Anda
        if($reservasi){
            return response()->json([
                'message' => 'Data Reservasi',
                'data' => $reservasi
            ],200);

        }
        return response()->json([
            'success' => false,
            'message' => 'Reservasi gagal diupdate',
            'data' => ''
        ], 400);


 }

        private function generateKodeBooking($idJenisCustumer)
        {
            $formatKodeBooking = ($idJenisCustumer == 1) ? 'P' : 'G';
            $formatKodeBooking .= now()->format('ymd');

            // Mendapatkan increment dari id reservasi
            $increment = Reservasi::max('id') + 1;

            // Menggabungkan increment ke dalam format kode booking
            $kodeBooking = $formatKodeBooking . '-' . str_pad($increment, 3, '0', STR_PAD_LEFT);

            return $kodeBooking;
        }

        public function tandaReservasi ( $id) {
    
            $transaksi =  DB::table('reservasi')
            ->select(
                'reservasi.kode_booking',
                'reservasi.tgl_reservasi',
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
    
            $kamar =DB::table('reservasi')
            ->select(
                'tipe_kamar.nama_tipe',
                'harga.harga as harga',
                'jumlah_kamar.jumlah_kamar',
                DB::raw('jumlah_kamar.jumlah_kamar * harga.harga as total'),
                DB::raw('SUM(jumlah_kamar.jumlah_kamar * harga.harga) OVER () as total_bayar')
            )
            ->leftJoin('jumlah_kamar', 'jumlah_kamar.id_reservasi', '=', 'reservasi.id')
            ->leftJoin('tipe_kamar', 'jumlah_kamar.id_tipe', '=', 'tipe_kamar.id')
            ->leftJoin(DB::raw('(SELECT id_tipe, MAX(id) AS latest_harga_id FROM harga GROUP BY id_tipe) latest_harga_ids'), function ($join) {
                $join->on('tipe_kamar.id', '=', 'latest_harga_ids.id_tipe');
            })
            ->leftJoin('harga', 'latest_harga_ids.latest_harga_id', '=', 'harga.id')
            ->where('reservasi.id', $id)
            ->get();
    
    
            $layanan = DB::table('reservasi')
            ->select('reservasi.id', 'booking_fasilitas.*', 'fasilitas.*', 'reservasi.permintaan_khusus')
            ->leftJoin('booking_fasilitas', 'booking_fasilitas.id_reservasi', '=', 'reservasi.id')
            ->leftJoin('fasilitas', 'booking_fasilitas.id_fasilitas', '=', 'fasilitas.id')
            ->where('reservasi.id', $id)
            ->get();

            $tanggal = now()->format('d/M/Y');
            
            $pdf = PDF::loadView('TandaTerimaReservasi', compact('transaksi', 'kamar', 'layanan', 'tanggal'));
            return $pdf->stream('TandaTerimaReservasi.pdf');
            
        }

        public function addGrup(Request $request)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'id_custumer'=>['required', 'string'],
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
        // dd(Auth::user()->id);

        $add = $request->all();
        $add['id_jenis_custumer'] = 2;
        $add['tgl_reservasi'] = now()->format('Y-m-d H:i:s'); 
        $add['status_reservasi']= 'ON GOING';
        $add = Reservasi::create($add);


        if($request->input('superior')>0 ){
            DB::table('jumlah_kamar')->insert([
                'id_tipe' => 1,
                'id_reservasi' => $add->id,
                'jumlah_kamar' => $request->input('superior')

            ]);
        }

        if($request->input('double_deluxe')>0 ){
            DB::table('jumlah_kamar')->insert([
                'id_tipe' => 2,
                'id_reservasi' => $add->id,
                'jumlah_kamar' => $request->input('double_deluxe')

            ]);
        }

        if($request->input('exclusive_deluxe')>0 ){
            DB::table('jumlah_kamar')->insert([
                'id_tipe' => 3,
                'id_reservasi' => $add->id,
                'jumlah_kamar' => $request->input('exclusive_deluxe')

            ]);
        }

        if($request->input('junior_suite')>0 ){
            DB::table('jumlah_kamar')->insert([
                'id_tipe' => 4,
                'id_reservasi' => $add->id,
                'jumlah_kamar' => $request->input('junior_suite')

            ]);
        }
        if($request->input('fasilitas')){
            foreach ($request->input('fasilitas') as $data) {
                $input['id_reservasi'] = $add->id;
                $input['tgl_booking_fasilitas'] = now();
                $input['id_fasilitas'] = $data['id'];
                $input['jumlah_booking_fasilitas'] = $data['jumlah_booking_fasilitas'];
                DB::table('booking_fasilitas')->insert($input);
            }   
        }
        
        if($add){
            return response()->json([
                'success' => true,
                'message' => $add
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal menambah Reservasi'
        ], 400);        
    }


    public function cancelReservasi($id){
        $reservasi = Reservasi::find($id);

        
        if($reservasi){
            if(Carbon::now()->format('Y-m-d') <= Carbon::parse($reservasi->tgl_cek_in)->subDays(7)->format('Y-m-d')){
                $reservasi->update([
                    'status_reservasi' => 'cancel booking',
                    'uang_jaminan' => 0
                ]);
                return response([
                    'message' => 'Succesfully cancel booking',
                    'data' => $reservasi,
                ], 200);
            }else {
                $reservasi->update([
                    'status_reservasi' => 'Cancel Booking But Not Refund'
                    
                ]);
                return response([
                    'message' => 'Succesfully cancel booking but the  security  deposit is non-refundable',
                    'data' => $reservasi,
                ], 200);
            }
        }
        return response([
            'message' => 'Failed cancel booking',
            'data' => null,
        ], 400);
    }

    

    public function Chekin($id)
    {
        $reservasi = Reservasi::find($id);

        if ($reservasi) {
            $tglCekin = Carbon::parse($reservasi->tgl_cek_in)->format('Y-m-d');
    
            $tglSaatIni = Carbon::now()->format('Y-m-d');
    
            if ($tglSaatIni == $tglCekin || Carbon::parse($tglSaatIni)->addDay()->format('Y-m-d') == $tglCekin) {
                $reservasi->update([
                    'status_reservasi' => 'Sudah ChekIN',
                    'uang_deposit' => 300000, 
                ]);
        
                return response([
                    'message' => 'Successfully Checkin',
                    'data' => $reservasi,
                ], 200);
            } else {
                return response([
                    'message' => 'ChekIn Tidak Bisa  dilakukan Karna Jadwal chekin tidak sesuai',
                    'data' => null,
                ], 400);
            }
        }
        return response([
            'message' => 'Chekin gagal',
            'data' => null,
        ], 400);
    

}

public function Checkout($id)
{
    try {
        $reservasi = Reservasi::find($id);

        if (!$reservasi) {
            return response()->json([
                'message' => 'Reservasi tidak ditemukan',
                'data' => null,
            ], 404);
        }
        // $tglSaatIni = now()->format('Y-m-d');
        // if ($tglSaatIni !== $reservasi->tgl_cek_out) {
        //     return response()->json([
        //         'message' => 'ChekOut Tidak Bisa  dilakukan Karna Jadwal chekout tidak sesuai',
        //         'data' => null,
        //     ], 400);
        // }

        $bookingKamar = Booking_Kamar::where('id_reservasi', $id)->get();
        if (!$bookingKamar) {
            return response()->json([
                'message' => 'Data booking kamar tidak ditemukan',
                'data' => null,
            ], 404);
        }
        foreach($bookingKamar as $data){
            $kamar = Kamar::find($data->id_kamar);
    
            if (!$kamar) {
                return response()->json([
                    'message' => 'Data kamar tidak ditemukan',
                    'data' => null,
                ], 404);
            }
            $kamar->update([
                'status_ketersedian_kamar' => 'available',
            ]);

        }

        $reservasi->update([
            'status_reservasi' => 'Sudah CheckOut',
        ]);

        return response()->json([
            'message' => 'Checkout berhasil',
            'data' => $reservasi,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat proses checkout',
            'data' => null,
        ], 500);
    }
}


    public function addFasilitas(Request $request)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
        
        ]);

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'first' => $validation->errors()->first(),
                'message' => $validation->errors()
            ], 400);
        }
        // dd(Auth::user()->id);
        $id = $request->input('id_reservasi');
        if($request->input('fasilitas')){
            foreach ($request->input('fasilitas') as $data) {
                $input['id_reservasi'] = $id;
                $input['tgl_booking_fasilitas'] = now();
                $input['id_fasilitas'] = $data['id'];
                $input['jumlah_booking_fasilitas'] = $data['jumlah_booking_fasilitas'];
                DB::table('booking_fasilitas')->insert($input);
            }   
        }
        
        if($request->input('fasilitas')){
            return response()->json([
                'success' => true,  
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal menambah Reservasi'
        ], 400);        
    }

    

    
    
    
}

