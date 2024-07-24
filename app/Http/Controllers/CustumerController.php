<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Custumer;
use Validator;
use PDF;

class CustumerController extends Controller
{
    public function registerGrup(Request $request)
    {
        // Validasi data pelanggan yang dikirim melalui request
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'no_identitas' => 'required',
            'no_telp' => 'required|unique:custumer|unique:pegawai',
            'email' => 'required|email|unique:custumer|unique:pegawai',
            'alamat' => 'required',
            'nama_institusi' => 'required',
        ]);

        
        $data = $request->all();
        $customer = Custumer::create($data);

        $token = $customer->CreateToken('Token')->accessToken;

        return response()->json([
            'message' => 'Custumer berhasil diregistrasi',
            'data' => $customer,
            'token' => $token
        ], 200);
    }

    public function registerPersonal(Request $request)
    {
        // Validasi data pelanggan yang dikirim melalui request
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'no_identitas' => 'required',
            'no_telp' => 'required|unique:custumer|unique:pegawai',
            'email' => 'required|email|unique:custumer|unique:pegawai',
            'alamat' => 'required',
            'password' => 'required|confirmed',
        ]);

        
        $data = $request->all();
        $data['password'] = bcrypt($validatedData['password']); // Anda sebaiknya mengenkripsi password
        $customer = Custumer::create($data);
        
        

        $token = $customer->CreateToken('Token')->accessToken;

        return response()->json([
            'message' => 'Custumer berhasil diregistrasi',
            'data' => $customer,
            'token' => $token
        ], 200);
    }

    public function search()
    {
        $id = Auth::user()->id;
        $Data_custumer = custumer::find($id);
        if($Data_custumer){
            return response()->json([
                'message' => 'Data custumer',
                'data' => $Data_custumer
            ],200);

        }
        return response()->json([
            'success' => false,
            'message' => 'custumer tidak ditemukan',
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
        $custumer = custumer::find($id);
         
        if($custumer){
            $input['nama']= $request->nama;
            $input['email']= $request->email;
            $input['no_identitas'] = $request->no_identitas;
            $input['no_telp']= $request->no_telp;
            $input['alamat'] = $request->alamat;
            $custumer->update($input);

            return response()->json([
                'success' => true,
                'message' => 'custumer Berhasil Diubah',
                'data' => $input
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'custumer Gagal Diubah',
            'data' => ''
        ], 400);
    } 

    public function readGrup()
    {
        $Data_custumer = custumer::where('password', null)->get();
        return response()->json([
            'message' => 'Data custumer',
            'data' => $Data_custumer
        ],200);
    }

    function LaporanCustumer(Request $request){
        $tahun = $request->tahun;
        $data = DB::table('custumer')
        ->select(DB::raw('YEAR(created_at) AS tahun_register'),
                 DB::raw('
                    CASE MONTH(created_at)
                        WHEN 1 THEN "January"
                        WHEN 2 THEN "February"
                        WHEN 3 THEN "March"
                        WHEN 4 THEN "April"
                        WHEN 5 THEN "May"
                        WHEN 6 THEN "June"
                        WHEN 7 THEN "July"
                        WHEN 8 THEN "August"
                        WHEN 9 THEN "September"
                        WHEN 10 THEN "October"
                        WHEN 11 THEN "November"
                        WHEN 12 THEN "December"
                    END AS nama_bulan'),
                 DB::raw('COUNT(DISTINCT id) AS jumlah_custumer_baru'))
        ->whereYear('created_at', '=', $tahun)
        ->groupBy('tahun_register', 'nama_bulan')
        ->get();
        $totalCustumer = $data->sum('jumlah_custumer_baru');

        if($data){
            return response()->json([
                'message' => 'Data Custumer',
                'data' => $data,
                'tahun' => $tahun
            ],200);

        }
        return response()->json([
            'success' => false,
            'message' => 'Custumer tidak ditemukan dibulan ini',
            'data' => ''
        ], 400);
    }

       



    function PDFLaporanCustumer(Request $request){
        $tahun = $request->tahun;
        

        $data =  DB::table('custumer')
        ->select(DB::raw('YEAR(created_at) AS tahun_register'),
                 DB::raw('
                    CASE MONTH(created_at)
                        WHEN 1 THEN "January"
                        WHEN 2 THEN "February"
                        WHEN 3 THEN "March"
                        WHEN 4 THEN "April"
                        WHEN 5 THEN "May"
                        WHEN 6 THEN "June"
                        WHEN 7 THEN "July"
                        WHEN 8 THEN "August"
                        WHEN 9 THEN "September"
                        WHEN 10 THEN "October"
                        WHEN 11 THEN "November"
                        WHEN 12 THEN "December"
                    END AS nama_bulan'),
                 DB::raw('COUNT(DISTINCT id) AS jumlah_custumer_baru'))
        ->whereYear('created_at', '=', $tahun)
        ->groupBy('tahun_register', 'nama_bulan')
        ->get();


        $tanggal = now()->format('j F Y');
        $totalCustumer = $data->sum('jumlah_custumer_baru');
        

        $pdf = PDF::loadView('LaporanCusBaru', compact('data', 'tanggal', 'totalCustumer', 'tahun'));
        return $pdf->stream('LaporanCusBaru.pdf');
    }

    function LaporanPendapatanBulanan(Request $request){
        $tahun = $request->tahun;

        $data = DB::table(DB::raw("
            (
                SELECT
                    MONTHNAME(r.tgl_reservasi) as Bulan,
                    SUM(CASE WHEN jc.nama_jenis_custumer = 'Personal' THEN r.uang_jaminan ELSE 0 END) AS total_uang_jaminan_personal,
                    SUM(CASE WHEN jc.nama_jenis_custumer = 'Grup' THEN r.uang_jaminan ELSE 0 END) AS total_uang_jaminan_grup,
                    SUM(r.uang_jaminan) AS total_uang_jaminan
                FROM
                    reservasi r
                JOIN
                    jenis_custumer jc ON r.id_jenis_custumer = jc.id
                WHERE
                    YEAR(r.tgl_reservasi) = $tahun
                GROUP BY MONTHNAME(r.tgl_reservasi)
            ) AS uj
        "))
            ->leftJoin(DB::raw("
                (
                    SELECT
                        YEAR(t.tgl_transaksi) AS tahun,
                        MONTHNAME(t.tgl_transaksi) AS bulan,
                        SUM(CASE WHEN jc.nama_jenis_custumer = 'Grup' THEN t.total_akhir_pembayaran ELSE 0 END) AS pendapatan_grup,
                        SUM(CASE WHEN jc.nama_jenis_custumer = 'Personal' THEN t.total_akhir_pembayaran ELSE 0 END) AS pendapatan_personal,
                        SUM(t.total_akhir_pembayaran) AS total_pendapatan
                    FROM
                        transaksi t
                    JOIN
                        reservasi r ON t.id_reservasi = r.id
                    JOIN
                        jenis_custumer jc ON r.id_jenis_custumer = jc.id
                    WHERE
                        YEAR(t.tgl_transaksi) = $tahun
                    GROUP BY YEAR(t.tgl_transaksi), MONTHNAME(t.tgl_transaksi)
                ) AS tp
            "), function($join) {
                $join->on(DB::raw('uj.Bulan'), '=', DB::raw('tp.bulan'));
            })
            ->select(
                DB::raw('COALESCE(uj.Bulan, tp.Bulan) AS Bulan'),
                DB::raw('COALESCE(uj.total_uang_jaminan_personal, 0) AS total_uang_jaminan_personal'),
                DB::raw('COALESCE(uj.total_uang_jaminan_grup, 0) AS total_uang_jaminan_grup'),
                DB::raw('COALESCE(uj.total_uang_jaminan, 0) AS total_uang_jaminan'),
                DB::raw('COALESCE(tp.pendapatan_personal, 0) AS pendapatan_personal'),
                DB::raw('COALESCE(tp.pendapatan_grup, 0) AS pendapatan_grup'),
                DB::raw('COALESCE(tp.total_pendapatan, 0) AS total_pendapatan'),
                DB::raw('COALESCE(uj.total_uang_jaminan, 0) + COALESCE(tp.total_pendapatan, 0) AS total_semua_pendapatan')
            )
            ->union(DB::table(DB::raw("
                (
                    SELECT
                        MONTHNAME(r.tgl_reservasi) as Bulan,
                        SUM(CASE WHEN jc.nama_jenis_custumer = 'Personal' THEN r.uang_jaminan ELSE 0 END) AS total_uang_jaminan_personal,
                        SUM(CASE WHEN jc.nama_jenis_custumer = 'Grup' THEN r.uang_jaminan ELSE 0 END) AS total_uang_jaminan_grup,
                        SUM(r.uang_jaminan) AS total_uang_jaminan
                    FROM
                        reservasi r
                    JOIN
                        jenis_custumer jc ON r.id_jenis_custumer = jc.id
                    WHERE
                        YEAR(r.tgl_reservasi) = $tahun
                    GROUP BY MONTHNAME(r.tgl_reservasi)
                ) AS uj
            "))
                ->rightJoin(DB::raw("
                    (
                        SELECT
                            YEAR(t.tgl_transaksi) AS tahun,
                            MONTHNAME(t.tgl_transaksi) AS bulan,
                            SUM(CASE WHEN jc.nama_jenis_custumer = 'Grup' THEN t.total_akhir_pembayaran ELSE 0 END) AS pendapatan_grup,
                            SUM(CASE WHEN jc.nama_jenis_custumer = 'Personal' THEN t.total_akhir_pembayaran ELSE 0 END) AS pendapatan_personal,
                            SUM(t.total_akhir_pembayaran) AS total_pendapatan
                        FROM
                            transaksi t
                        JOIN
                            reservasi r ON t.id_reservasi = r.id
                        JOIN
                            jenis_custumer jc ON r.id_jenis_custumer = jc.id
                        WHERE
                            YEAR(t.tgl_transaksi) = $tahun
                        GROUP BY YEAR(t.tgl_transaksi), MONTHNAME(t.tgl_transaksi)
                    ) AS tp
                "), function($join) {
                    $join->on(DB::raw('uj.Bulan'), '=', DB::raw('tp.bulan'));
                })
                ->select(
                    DB::raw('COALESCE(uj.Bulan, tp.Bulan) AS Bulan'),
                DB::raw('COALESCE(uj.total_uang_jaminan_personal, 0) AS total_uang_jaminan_personal'),
                DB::raw('COALESCE(uj.total_uang_jaminan_grup, 0) AS total_uang_jaminan_grup'),
                DB::raw('COALESCE(uj.total_uang_jaminan, 0) AS total_uang_jaminan'),
                DB::raw('COALESCE(tp.pendapatan_personal, 0) AS pendapatan_personal'),
                DB::raw('COALESCE(tp.pendapatan_grup, 0) AS pendapatan_grup'),
                DB::raw('COALESCE(tp.total_pendapatan, 0) AS total_pendapatan'),
                DB::raw('COALESCE(uj.total_uang_jaminan, 0) + COALESCE(tp.total_pendapatan, 0) AS total_semua_pendapatan')
            )
            ->whereNull('uj.Bulan')
            ->orWhereNull('tp.Bulan')
        )
        ->orderBy('Bulan')
        ->get();
    

        if($data){
            return response()->json([
                'message' => 'Data Custumer',
                'data' => $data,
                'tahun' => $tahun
            ],200);

        }
        return response()->json([
            'success' => false,
            'message' => 'Custumer tidak ditemukan dibulan ini',
            'data' => ''
        ], 400);
    }

    function PDFLaporanPendapatanBulanan(Request $request){
        $tahun = $request->tahun;

        $data = DB::table(DB::raw("
            (
                SELECT
                    MONTHNAME(r.tgl_reservasi) as Bulan,
                    SUM(CASE WHEN jc.nama_jenis_custumer = 'Personal' THEN r.uang_jaminan ELSE 0 END) AS total_uang_jaminan_personal,
                    SUM(CASE WHEN jc.nama_jenis_custumer = 'Grup' THEN r.uang_jaminan ELSE 0 END) AS total_uang_jaminan_grup,
                    SUM(r.uang_jaminan) AS total_uang_jaminan
                FROM
                    reservasi r
                JOIN
                    jenis_custumer jc ON r.id_jenis_custumer = jc.id
                WHERE
                    YEAR(r.tgl_reservasi) = $tahun
                GROUP BY MONTHNAME(r.tgl_reservasi)
            ) AS uj
        "))
            ->leftJoin(DB::raw("
                (
                    SELECT
                        YEAR(t.tgl_transaksi) AS tahun,
                        MONTHNAME(t.tgl_transaksi) AS bulan,
                        SUM(CASE WHEN jc.nama_jenis_custumer = 'Grup' THEN t.total_akhir_pembayaran ELSE 0 END) AS pendapatan_grup,
                        SUM(CASE WHEN jc.nama_jenis_custumer = 'Personal' THEN t.total_akhir_pembayaran ELSE 0 END) AS pendapatan_personal,
                        SUM(t.total_akhir_pembayaran) AS total_pendapatan
                    FROM
                        transaksi t
                    JOIN
                        reservasi r ON t.id_reservasi = r.id
                    JOIN
                        jenis_custumer jc ON r.id_jenis_custumer = jc.id
                    WHERE
                        YEAR(t.tgl_transaksi) = $tahun
                    GROUP BY YEAR(t.tgl_transaksi), MONTHNAME(t.tgl_transaksi)
                ) AS tp
            "), function($join) {
                $join->on(DB::raw('uj.Bulan'), '=', DB::raw('tp.bulan'));
            })
            ->select(
                DB::raw('COALESCE(uj.Bulan, tp.Bulan) AS Bulan'),
                DB::raw('COALESCE(uj.total_uang_jaminan_personal, 0) AS total_uang_jaminan_personal'),
                DB::raw('COALESCE(uj.total_uang_jaminan_grup, 0) AS total_uang_jaminan_grup'),
                DB::raw('COALESCE(uj.total_uang_jaminan, 0) AS total_uang_jaminan'),
                DB::raw('COALESCE(tp.pendapatan_personal, 0) AS pendapatan_personal'),
                DB::raw('COALESCE(tp.pendapatan_grup, 0) AS pendapatan_grup'),
                DB::raw('COALESCE(tp.total_pendapatan, 0) AS total_pendapatan'),
                DB::raw('COALESCE(uj.total_uang_jaminan, 0) + COALESCE(tp.total_pendapatan, 0) AS total_semua_pendapatan')
            )
            ->union(DB::table(DB::raw("
                (
                    SELECT
                        MONTHNAME(r.tgl_reservasi) as Bulan,
                        SUM(CASE WHEN jc.nama_jenis_custumer = 'Personal' THEN r.uang_jaminan ELSE 0 END) AS total_uang_jaminan_personal,
                        SUM(CASE WHEN jc.nama_jenis_custumer = 'Grup' THEN r.uang_jaminan ELSE 0 END) AS total_uang_jaminan_grup,
                        SUM(r.uang_jaminan) AS total_uang_jaminan
                    FROM
                        reservasi r
                    JOIN
                        jenis_custumer jc ON r.id_jenis_custumer = jc.id
                    WHERE
                        YEAR(r.tgl_reservasi) = $tahun
                    GROUP BY MONTHNAME(r.tgl_reservasi)
                ) AS uj
            "))
                ->rightJoin(DB::raw("
                    (
                        SELECT
                            YEAR(t.tgl_transaksi) AS tahun,
                            MONTHNAME(t.tgl_transaksi) AS bulan,
                            SUM(CASE WHEN jc.nama_jenis_custumer = 'Grup' THEN t.total_akhir_pembayaran ELSE 0 END) AS pendapatan_grup,
                            SUM(CASE WHEN jc.nama_jenis_custumer = 'Personal' THEN t.total_akhir_pembayaran ELSE 0 END) AS pendapatan_personal,
                            SUM(t.total_akhir_pembayaran) AS total_pendapatan
                        FROM
                            transaksi t
                        JOIN
                            reservasi r ON t.id_reservasi = r.id
                        JOIN
                            jenis_custumer jc ON r.id_jenis_custumer = jc.id
                        WHERE
                            YEAR(t.tgl_transaksi) = $tahun
                        GROUP BY YEAR(t.tgl_transaksi), MONTHNAME(t.tgl_transaksi)
                    ) AS tp
                "), function($join) {
                    $join->on(DB::raw('uj.Bulan'), '=', DB::raw('tp.bulan'));
                })
                ->select(
                    DB::raw('COALESCE(uj.Bulan, tp.Bulan) AS Bulan'),
                DB::raw('COALESCE(uj.total_uang_jaminan_personal, 0) AS total_uang_jaminan_personal'),
                DB::raw('COALESCE(uj.total_uang_jaminan_grup, 0) AS total_uang_jaminan_grup'),
                DB::raw('COALESCE(uj.total_uang_jaminan, 0) AS total_uang_jaminan'),
                DB::raw('COALESCE(tp.pendapatan_personal, 0) AS pendapatan_personal'),
                DB::raw('COALESCE(tp.pendapatan_grup, 0) AS pendapatan_grup'),
                DB::raw('COALESCE(tp.total_pendapatan, 0) AS total_pendapatan'),
                DB::raw('COALESCE(uj.total_uang_jaminan, 0) + COALESCE(tp.total_pendapatan, 0) AS total_semua_pendapatan')
            )
            ->whereNull('uj.Bulan')
            ->orWhereNull('tp.Bulan')
        )
        ->orderBy('Bulan')
        ->get();

        $tanggal = now()->format('j F Y');

        $totalUang = $data->sum('total_semua_pendapatan');
        

        $pdf = PDF::loadView('LaporanPendapatanBulanan', compact('data', 'tanggal', 'totalUang','tahun'));
        return $pdf->stream('LaporanPendapatanBulananpdf');
    
    }


    function LaporanTamu(Request $request){
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        
        $numericMonth = date('m', strtotime("1 $bulan 2000"));
        
        $data =  DB::table('transaksi as t')
            ->leftJoin('reservasi as r', 't.id_reservasi', '=', 'r.id')
            ->leftJoin('jenis_custumer as jc', 'r.id_jenis_custumer', '=', 'jc.id')
            ->leftJoin('jumlah_kamar as jk', 'r.id', '=', 'jk.id_reservasi')
            ->leftJoin('tipe_kamar as tk', 'jk.id_tipe', '=', 'tk.id')
            ->select(
                DB::raw('MONTHNAME(t.tgl_transaksi) as transaction_month'),
                DB::raw('EXTRACT(YEAR FROM t.tgl_transaksi) as transaction_year'),
                'jc.nama_jenis_custumer as customer_type',
                DB::raw('SUM(CASE WHEN jc.nama_jenis_custumer = "grup" THEN jk.jumlah_kamar ELSE 0 END) as total_kamar_grup'),
                DB::raw('SUM(CASE WHEN jc.nama_jenis_custumer = "personal" THEN jk.jumlah_kamar ELSE 0 END) as total_kamar_personal'),
                DB::raw('SUM(jk.jumlah_kamar) as total_kamar_all'),
                'tk.nama_tipe'
            )
            ->whereMonth('t.tgl_transaksi', $numericMonth)
            ->whereYear('t.tgl_transaksi', $tahun)
            ->groupBy('transaction_month', 'transaction_year', 'jc.nama_jenis_custumer', 'tk.nama_tipe')
            ->orderBy('transaction_year')
            ->orderByRaw('FIELD(transaction_month, "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")')
            ->get();

        $totalKamar = $data->sum('total_kamar_all');

        if($data){
            return response()->json([
                'message' => 'Data Custumer',
                'data' => $data,
                'tahun' => $tahun,
                'bulan' => $bulan
            ],200);

        }
        return response()->json([
            'success' => false,
            'message' => 'Custumer tidak ditemukan dibulan ini',
            'data' => ''
        ], 400);
    }

    function PDFLaporanTamu(Request $request){
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $numericMonth = date('m', strtotime("1 $bulan 2000"));
        
        $data =  DB::table('transaksi as t')
            ->leftJoin('reservasi as r', 't.id_reservasi', '=', 'r.id')
            ->leftJoin('jenis_custumer as jc', 'r.id_jenis_custumer', '=', 'jc.id')
            ->leftJoin('jumlah_kamar as jk', 'r.id', '=', 'jk.id_reservasi')
            ->leftJoin('tipe_kamar as tk', 'jk.id_tipe', '=', 'tk.id')
            ->select(
                DB::raw('MONTHNAME(t.tgl_transaksi) as transaction_month'),
                DB::raw('EXTRACT(YEAR FROM t.tgl_transaksi) as transaction_year'),
                'jc.nama_jenis_custumer as customer_type',
                DB::raw('SUM(CASE WHEN jc.nama_jenis_custumer = "grup" THEN jk.jumlah_kamar ELSE 0 END) as total_kamar_grup'),
                DB::raw('SUM(CASE WHEN jc.nama_jenis_custumer = "personal" THEN jk.jumlah_kamar ELSE 0 END) as total_kamar_personal'),
                DB::raw('SUM(jk.jumlah_kamar) as total_kamar_all'),
                'tk.nama_tipe'
            )
            ->whereMonth('t.tgl_transaksi', $numericMonth)
            ->whereYear('t.tgl_transaksi', $tahun)
            ->groupBy('transaction_month', 'transaction_year', 'jc.nama_jenis_custumer', 'tk.nama_tipe')
            ->orderBy('transaction_year')
            ->orderByRaw('FIELD(transaction_month, "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")')
            ->get();

        $totalKamar = $data->sum('total_kamar_all');
        $tanggal = now()->format('j F Y');
       
        

        $pdf = PDF::loadView('LaporanTamu', compact('data', 'tanggal', 'totalKamar', 'tahun', 'bulan'));
        return $pdf->stream('LaporanTamu.pdf');
    }

    function LaporanTOP5(Request $request){
        $tahun = $request->tahun;
        $data = DB::table('custumer as c')
        ->select([
            'c.id as customer_id',
            'c.nama as customer_name',
            DB::raw('COUNT(t.id) as total_transactions'),
            DB::raw('SUM(t.total_akhir_pembayaran) as total_payments'),
        ])
        ->join('reservasi as r', 'c.id', '=', 'r.id_custumer')
        ->join('transaksi as t', 'r.id', '=', 't.id_reservasi')
        ->whereYear('t.tgl_transaksi', $tahun)
        ->groupBy('c.id', 'c.nama')
        ->orderByDesc('total_payments')
        ->limit(5)
        ->get();
        
        
        if($data){
            return response()->json([
                'message' => 'Data Custumer',
                'data' => $data,
                'tahun' => $tahun
            ],200);

        }
        return response()->json([
            'success' => false,
            'message' => 'Custumer tidak ditemukan ditahun ini',
            'data' => ''
        ], 400);
    }

    function PDFLaporanTop5(Request $request){
        $tahun = $request->tahun;
        $data = DB::table('custumer as c')
        ->select([
            'c.id as customer_id',
            'c.nama as customer_name',
            DB::raw('COUNT(t.id) as total_transactions'),
            DB::raw('SUM(t.total_akhir_pembayaran) as total_payments'),
        ])
        ->join('reservasi as r', 'c.id', '=', 'r.id_custumer')
        ->join('transaksi as t', 'r.id', '=', 't.id_reservasi')
        ->whereYear('t.tgl_transaksi', $tahun)
        ->groupBy('c.id', 'c.nama')
        ->orderByDesc('total_payments')
        ->limit(5)
        ->get();


        $tanggal = now()->format('j F Y');
        

        $pdf = PDF::loadView('LaporanTop5', compact('data', 'tanggal', 'tahun'));
        return $pdf->stream('LaporanTop5.pdf');
    }


}




