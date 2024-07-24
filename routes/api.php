<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustumerController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\loginController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//REGISTER
Route::post('register/custumer/grup', [CustumerController::class, 'registerGrup']);
Route::post('register/custumer/personal', [CustumerController::class, 'registerPersonal']);
Route::post('register/pegawai', [PegawaiController::class, 'registerPegawai']);
//LOGIN
Route::post('login', [loginController::class, 'login']);
//LOGOUT
Route::post('logout', [loginController::class, 'logout'])->middleware('auth:sanctum','ability:custumer,ADMIN,SALES MARKETING,RESEPSIONIS,OWNER,GENERAL MANAGER');
//CHANGE PASSPWORD
Route::put('changepass', 'App\Http\Controllers\LoginController@change_password')->middleware('auth:sanctum');

// KAMAR
Route::post('kamar', 'App\Http\Controllers\KamarController@add')->middleware('auth:sanctum','ability:ADMIN');
Route::put('kamar/{id}', 'App\Http\Controllers\KamarController@edit')->middleware('auth:sanctum', 'ability:ADMIN');
Route::delete('kamar/{id}', 'App\Http\Controllers\KamarController@delete')->middleware('auth:sanctum', 'ability:ADMIN');
Route::get('kamar', 'App\Http\Controllers\KamarController@read')->middleware('auth:sanctum','ability:ADMIN');
Route::get('kamar/detail/{id}', 'App\Http\Controllers\KamarController@readKamar')->middleware('auth:sanctum','ability:ADMIN');
Route::get('kamar/{id}', 'App\Http\Controllers\KamarController@search')->middleware('auth:sanctum', 'ability:ADMIN');
Route::get('kamar-available', 'App\Http\Controllers\KamarController@readavilable')->middleware('auth:sanctum', 'ability:RESEPSIONIS');


// SEASON
Route::post('season', 'App\Http\Controllers\SeasonController@add')->middleware('auth:sanctum', 'ability:SALES MARKETING');
Route::put('season/{id}', 'App\Http\Controllers\SeasonController@edit')->middleware('auth:sanctum', 'ability:SALES MARKETING');
Route::delete('season/{id}', 'App\Http\Controllers\SeasonController@delete')->middleware('auth:sanctum', 'ability:SALES MARKETING');
Route::get('season', 'App\Http\Controllers\SeasonController@read')->middleware('auth:sanctum', 'ability:SALES MARKETING');
Route::get('season/{id}', 'App\Http\Controllers\SeasonController@search')->middleware('auth:sanctum', 'ability:SALES MARKETING');


//FASILITAS
Route::post('fasilitas', 'App\Http\Controllers\FasilitasController@add')->middleware('auth:sanctum', 'ability:SALES MARKETING');
Route::put('fasilitas/{id}', 'App\Http\Controllers\FasilitasController@edit')->middleware('auth:sanctum', 'ability:SALES MARKETING');
Route::delete('fasilitas/{id}', 'App\Http\Controllers\FasilitasController@delete')->middleware('auth:sanctum', 'ability:SALES MARKETING');
Route::get('fasilitas', 'App\Http\Controllers\FasilitasController@read')->middleware('auth:sanctum', 'ability:custumer,SALES MARKETING,RESEPSIONIS');
Route::get('fasilitas/{id}', 'App\Http\Controllers\FasilitasController@search')->middleware('auth:sanctum', 'ability:SALES MARKETING,custumer');

//HARGA
Route::post('harga', 'App\Http\Controllers\HargaController@add')->middleware('auth:sanctum', 'ability:SALES MARKETING');
Route::put('harga/{id}', 'App\Http\Controllers\HargaController@edit')->middleware('auth:sanctum', 'ability:SALES MARKETING');
Route::delete('harga/{id}', 'App\Http\Controllers\HargaController@delete')->middleware('auth:sanctum', 'ability:SALES MARKETING');
Route::get('harga', 'App\Http\Controllers\HargaController@read')->middleware('auth:sanctum', 'ability:SALES MARKETING,custumer');
Route::get('harga/{id}', 'App\Http\Controllers\HargaController@search')->middleware('auth:sanctum', 'ability:SALES MARKETING');
Route::get('harga/detail/{id}', 'App\Http\Controllers\HargaController@readHarga')->middleware('auth:sanctum','ability:SALES MARKETING');

//TRANSAKSI
Route::post('transaksi', 'App\Http\Controllers\TransaksiController@add')->middleware('auth:sanctum', 'ability:RESEPSIONIS');
Route::put('transaksi/{id}', 'App\Http\Controllers\TransaksiController@edit')->middleware('auth:sanctum', 'role:SALES MARKETING');
Route::delete('transaksi/{id}', 'App\Http\Controllers\TransaksiController@delete')->middleware('auth:sanctum', 'role:SALES MARKETING');
Route::get('transaksi', 'App\Http\Controllers\TransaksiController@read')->middleware('auth:sanctum', 'role:SALES MARKETING');
Route::get('transaki/{id}', 'App\Http\Controllers\TransaksiController@search')->middleware('auth:sanctum', 'role:SALES MARKETING');

//JUMLAH KAMAR
Route::post('jumlahKamar', 'App\Http\Controllers\JumlahKamarController@add')->middleware('auth:sanctum', 'role:SALES MARKETING');
Route::put('jumlahKamar/{id}', 'App\Http\Controllers\JumlahKamarController@edit')->middleware('auth:sanctum', 'role:SALES MARKETING');
Route::delete('jumlahKamar/{id}', 'App\Http\Controllers\JumlahKamarController@delete')->middleware('auth:sanctum', 'role:SALES MARKETING');
Route::get('jumlahKamar', 'App\Http\Controllers\JumlahKamarController@read')->middleware('auth:sanctum', 'role:SALES MARKETING');
Route::get('jumlahKamar/{id}', 'App\Http\Controllers\JumlahKamarController@search')->middleware('auth:sanctum', 'role:SALES MARKETING');

//RESERVASI
Route::post('reservasi-personal', 'App\Http\Controllers\ReservasiController@addPersonal')->middleware('auth:sanctum', 'ability:SALES MARKETING,custumer');
Route::post('reservasi-grup', 'App\Http\Controllers\ReservasiController@addGrup')->middleware('auth:sanctum', 'ability:SALES MARKETING,custumer');
Route::put('reservasi/{id}', 'App\Http\Controllers\ReservasiController@edit')->middleware('auth:sanctum', 'role:SALES MARKETING');
Route::delete('reservasi/{id}', 'App\Http\Controllers\ReservasiController@delete')->middleware('auth:sanctum', 'role:SALES MARKETING');
Route::get('reservasiCus', 'App\Http\Controllers\ReservasiController@read')->middleware('auth:sanctum', 'ability:custumer');
Route::get('reservasiSM', 'App\Http\Controllers\ReservasiController@readSM')->middleware('auth:sanctum', 'ability:SALES MARKETING');
Route::get('reservasi/{id}', 'App\Http\Controllers\ReservasiController@search')->middleware('auth:sanctum', 'ability:RESEPSIONIS');
Route::get('reservasi', 'App\Http\Controllers\ReservasiController@readAll')->middleware('auth:sanctum', 'ability:custumer,SALES MARKETING,RESEPSIONIS');
Route::put('update-uangJaminan/{id}', 'App\Http\Controllers\ReservasiController@update')->middleware('auth:sanctum', 'ability:custumer,SALES MARKETING');
Route::get('Chekin/{id}', 'App\Http\Controllers\ReservasiController@Chekin')->middleware('auth:sanctum', 'ability:RESEPSIONIS');
Route::get('Chekout/{id}', 'App\Http\Controllers\ReservasiController@Checkout')->middleware('auth:sanctum', 'ability:RESEPSIONIS');


//BOOKING KAMAR

Route::post('booking-Kamar/{id}', 'App\Http\Controllers\BookingKamarController@BookingKamar')->middleware('auth:sanctum', 'ability:RESEPSIONIS');


//DETAIL RESERVASI CUSTUMER
Route::get('reservasi/detail/{id}', 'App\Http\Controllers\ReservasiController@detailReservasi')->middleware('auth:sanctum', 'ability:custumer,SALES MARKETING,RESEPSIONIS');
Route::get('reservasi/detail/kamar/{id}', 'App\Http\Controllers\ReservasiController@detailKamar')->middleware('auth:sanctum', 'ability:custumer,SALES MARKETING,RESEPSIONIS');
Route::get('reservasi/detail/fasilitas/{id}', 'App\Http\Controllers\ReservasiController@detailFasilitas')->middleware('auth:sanctum', 'ability:custumer,SALES MARKETING,RESEPSIONIS');
Route::get('reservasi/detail/totalP/{id}', 'App\Http\Controllers\ReservasiController@detailTotalPembayaran')->middleware('auth:sanctum', 'ability:custumer,SALES MARKETING,RESEPSIONIS');
Route::get('reservasi/detail/profilC/{id}', 'App\Http\Controllers\ReservasiController@detailProfileC')->middleware('auth:sanctum', 'ability:SALES MARKETING');

// TIPE KAMAR 
Route::get('tipeKamar/{id}', 'App\Http\Controllers\TipeKamarController@read')->middleware('auth:sanctum','ability:custumer,SALES MARKETING');
Route::post('roomCheck', 'App\Http\Controllers\TipeKamarController@roomCheck')->middleware('auth:sanctum','ability:custumer,SALES MARKETING');


//CUSTUMER
Route::get('custumer', 'App\Http\Controllers\CustumerController@search')->middleware('auth:sanctum', 'ability:custumer');
Route::put('custumer', 'App\Http\Controllers\CustumerController@edit')->middleware('auth:sanctum', 'ability:custumer');
Route::get('custumerG', 'App\Http\Controllers\CustumerController@readGrup')->middleware('auth:sanctum', 'ability:SALES MARKETING');

//PEGAWAI
Route::get('pegawai', 'App\Http\Controllers\PegawaiController@search')->middleware('auth:sanctum', 'ability:ADMIN,SALES MARKETING,RESEPSIONIS,OWNER,GENERAL MANAGER');
Route::put('pegawai', 'App\Http\Controllers\PegawaiController@edit')->middleware('auth:sanctum', 'ability:ADMIN,SALES MARKETING,RESEPSIONIS,OWNER,GENERAL MANAGER');

//REPORT
Route::post('tanda-reservasi/{id}', 'App\Http\Controllers\ReservasiController@tandaReservasi')->middleware('auth:sanctum', 'ability:custumer,SALES MARKETING');
Route::post('nota-lunas/{id}', 'App\Http\Controllers\TransaksiController@notaLunas')->middleware('auth:sanctum', 'ability:RESEPSIONIS');
Route::post('laporan-pdfcusbaru', 'App\Http\Controllers\CustumerController@PDFLaporanCustumer')->middleware('auth:sanctum', 'ability:GENERAL MANAGER,OWNER');
Route::post('laporan-pdfpendapatanBulanan', 'App\Http\Controllers\CustumerController@PDFLaporanPendapatanBulanan')->middleware('auth:sanctum', 'ability:GENERAL MANAGER,OWNER');
Route::post('laporan-pdftamu', 'App\Http\Controllers\CustumerController@PDFLaporanTamu')->middleware('auth:sanctum', 'ability:GENERAL MANAGER,OWNER');
Route::post('laporan-pdftop5', 'App\Http\Controllers\CustumerController@PDFLaporanTop5')->middleware('auth:sanctum', 'ability:GENERAL MANAGER,OWNER');

//CANCEL RESERVASI
Route::put('cancel-reservasi/{id}', 'App\Http\Controllers\ReservasiController@cancelReservasi')->middleware('auth:sanctum', 'ability:custumer,SALES MARKETING');

//FAsilitas Id
Route::post('fasilitas', 'App\Http\Controllers\ReservasiController@addFasilitas')->middleware('auth:sanctum', 'ability:RESEPSIONIS');

//Laporan
Route::post('laporan-cusbaru', 'App\Http\Controllers\CustumerController@LaporanCustumer')->middleware('auth:sanctum', 'ability:GENERAL MANAGER,OWNER');
Route::post('laporan-pendapatanBulanan', 'App\Http\Controllers\CustumerController@LaporanPendapatanBulanan')->middleware('auth:sanctum', 'ability:GENERAL MANAGER,OWNER');
Route::post('laporan-tamu', 'App\Http\Controllers\CustumerController@LaporanTamu')->middleware('auth:sanctum', 'ability:GENERAL MANAGER,OWNER');
Route::post('laporan-top5', 'App\Http\Controllers\CustumerController@LaporanTop5')->middleware('auth:sanctum', 'ability:GENERAL MANAGER,OWNER');