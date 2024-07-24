<!DOCTYPE html>
<html lang="en">
<head>
  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" media="all"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      .table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
      }
      .box-border {
        border: 1px solid #000; /* Warna dan ketebalan garis dapat disesuaikan */
        padding: 10px; /* Atur padding sesuai kebutuhan Anda */
    }

      .td, .th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
      }

      .table-borderless {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: none !important;
      }

      .td-borderless {
        border: none !important;
      }

      .th-borderless {
        border: none !important;
      }

      .text-right {
        text-align: right;
      }

      .text-bold {
        font-weight: bold;
      }
      
      .w-10 {
        width: 10%;
      }

      .w-20 {
        width: 20%;
      }

      .w-30 {
        width: 30%;
      }

      .w-full {
        width: 100%;
      }

      .center {
          text-align: center;
      }

      .center img {
          margin: auto;
          display: block;
      }
    </style>
</head>
<body>
<div class="box-border">
  <div class="center">
    <img src="{{ public_path('storage/GAH-Logo.jpg') }}" alt="logo">
    <h6>Jl. P. Mangkubumi No.18, Yogyakarta 55233</h6>
    <hr style="margin-top: 40px;margin-bottom: 10px;"/>
    <h5 style="text-align:center; font-weight: 900;">TANDA TERIMA PEMESANAN</h5>
    <hr style="margin-top: 10px;margin-bottom: 20px;"/>
    <div >
      <table class="table">
        <tbody>
          <tr>
            <td class="td-borderless">ID Booking</th>
            <td class="td-borderless">{{$transaksi->kode_booking}}<td>
            <td class="td-borderless text-right">Tanggal</td>
            <td class="text-right w-20">{{$tanggal}}</td>
          </tr>
          <br/>
          <tr>
            <td class="td-borderless">Nama</th>
            <td class="td-borderless">{{$transaksi->nama_custumer}}<td>
          </tr>
          <tr>
            <td class="td-borderless">Alamat</th>
            <td class="td-borderless">{{$transaksi->alamat_custumer}}<td>
          </tr>
          <br/>
        </tbody>
      </table>
    </div>
    <hr style="margin-top: 40px;margin-bottom: 10px;"/>
    <h5 style="text-align:center; font-weight: 900;">DETAIL PEMESANAN</h5>
    <hr style="margin-top: 10px;margin-bottom: 20px;"/>
    <div >
      <table class="table">
        <tbody>
          <tr>
            <td class="td-borderless">Check In</th>
            <td class="td-borderless">{{$transaksi->tgl_cek_in_formatted}}<td>
            <td class="td-borderless text-right"></td>
            <td class="td-borderless text-right w-30"></td>
          </tr>
          <tr>
            <td class="td-borderless">Check Out</th>
            <td class="td-borderless">{{$transaksi->tgl_cek_out_formatted}}<td>
          </tr>
          <tr>
            <td class="td-borderless">Dewasa</th>
            <td class="td-borderless">{{$transaksi->org_dewasa}}<td>
          </tr>
          <tr>
            <td class="td-borderless">Anak-Anak</th>
            <td class="td-borderless">{{$transaksi->org_anak}}<td>
          </tr>
          <tr>
            <td class="td-borderless">Tanggal Pembayaran</th>
            <td class="td-borderless">{{$transaksi->tgl_uang_jaminan_formatted}}<td>
          </tr>
          <br/>
        </tbody>
      </table>
    </div>
    <hr style="margin-top: 40px;margin-bottom: 10px;"/>
    <hr style="margin-top: 10px;margin-bottom: 20px;"/>
    <div className="overflow-x-auto">
      <table class="table w-full">
        {/* head */}
        <thead>
          <tr>
            <th class="th">Jenis Kamar</th>
            <th class="th">Bed</th>
            <th class="th">Jumlah</th>
            <th class="th">Harga</th>
            <th class="th">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($kamar as $item)
          <tr>
            <th class="th">{{$item->nama_tipe}}</th>
            <td class="td">.</td>
            <td class="td">{{$item->jumlah_kamar}}</td>
            <td class="td">{{$item->harga}}</td>
            <td class="td">{{$item->total}}</td>
          </tr>
          @endforeach
          <tr>
            <th ></th>
            <td ></td>
            <td ></td>
            <td ></td>
            <td class="td text-bold">{{$item->total_bayar}}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <br/>
    <div className="overflow-x-auto">
      <table>
        {/* head */}
        <thead>
          <tr>
            <th>Permintaan Khusus : </th>
          </tr>
        </thead>
        <tbody>
          @foreach($layanan as $item)
          <ul>
            <li> - {{$item->permintaan_khusus}}</li>
            <li> - {{$item->nama_fasilitas}}</li>
          </ul>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
      </div>
</body>

</html>