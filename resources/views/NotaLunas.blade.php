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
    <h5 style="text-align:center; font-weight: 900;">INVOICE</h5>
    <hr style="margin-top: 10px;margin-bottom: 20px;"/>
    <div >
      <table class="table">
        <tbody>
        <tr>
                <td class="td-borderless text-right">Tanggal</td>
                <td class="td-borderless text-right">{{$transaksi->tgl_transaksi}}</td>
            </tr>
            <tr>
                <td class="td-borderless text-right">No. Invoice</td>
                <td class="td-borderless text-right">{{$transaksi->id}}</td>
            </tr>
            <tr>
                <td class="td-borderless text-right">Front Office</td>
                <td class="td-borderless text-right">{{$transaksi->nama}}</td>
        </tr>

          <tr>
            <td class="td-borderless">ID Booking</th>
            <td class="td-borderless">{{$reservasi->kode_booking}}<td>
          </tr>
          <br/>
          <tr>
            <td class="td-borderless">Nama</th>
            <td class="td-borderless">{{$reservasi->nama_custumer}}<td>
          </tr>
          <tr>
            <td class="td-borderless">Alamat</th>
            <td class="td-borderless">{{$reservasi->alamat_custumer}}<td>
          </tr>
          <br/>
        </tbody>
      </table>
    </div>
    <hr style="margin-top: 40px;margin-bottom: 10px;"/>
    <h5 style="text-align:center; font-weight: 900;">DETAIL</h5>
    <hr style="margin-top: 10px;margin-bottom: 20px;"/>
    <div >
      <table class="table">
        <tbody>
          <tr>
            <td class="td-borderless">Check In</th>
            <td class="td-borderless">{{$reservasi->tgl_cek_in_formatted}}<td>
            <td class="td-borderless text-right"></td>
            <td class="td-borderless text-right w-30"></td>
          </tr>
          <tr>
            <td class="td-borderless">Check Out</th>
            <td class="td-borderless">{{$reservasi->tgl_cek_out_formatted}}<td>
          </tr>
          <tr>
            <td class="td-borderless">Dewasa</th>
            <td class="td-borderless">{{$reservasi->org_dewasa}}<td>
          </tr>
          <tr>
            <td class="td-borderless">Anak-Anak</th>
            <td class="td-borderless">{{$reservasi->org_anak}}<td>
          </tr>
          <br/>
        </tbody>
      </table>
      </div>
    <hr style="margin-top: 40px;margin-bottom: 10px;"/>
    <h5 style="text-align:center; font-weight: 900;">KAMAR</h5>
    <hr style="margin-top: 10px;margin-bottom: 20px;"/>
    <div >
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
            <td class="td">{{$item->pilihan_bad}}</td>
            <td class="td">{{$item->jumlah_kamar}}</td>
            <td class="td text-bold">Rp.{{ number_format($item->harga, 2, ',', '.') }}</td>
            <td class="td text-bold">Rp.{{ number_format($item->total, 2, ',', '.') }}</td>
          </tr>
          @endforeach
          <tr>
            <th ></th>
            <td ></td>
            <td ></td>
            <td ></td>
            <td class="td text-bold">Rp.{{ number_format($item->total_bayar, 2, ',', '.') }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <br/>
        </tbody>
      </table>
      </div>
    <hr style="margin-top: 40px;margin-bottom: 10px;"/>
    <h5 style="text-align:center; font-weight: 900;">LAYANAN</h5>
    <hr style="margin-top: 10px;margin-bottom: 20px;"/>
    <div >
      <table class="table w-full">
        {/* head */}
        <thead>
          <tr>
            <th class="th">Layanan</th>
            <th class="th">Tanggal</th>
            <th class="th">Jumlah</th>
            <th class="th">Harga</th>
            <th class="th">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($layanan as $item)
          <tr>
            <th class="th">{{$item->nama_fasilitas}}</th>
            <td class="td">{{$item->tgl_booking_fasilitas}}</td>
            <td class="td">{{$item->jumlah_booking_fasilitas}}</td>
            <td class="td text-bold">Rp.{{ number_format($item->harga_fasilitas, 2, ',', '.') }}</td>
            <td class="td text-bold">Rp.{{ number_format($item->total, 2, ',', '.') }}</td>
          </tr>
          @endforeach
          <tr>
            <th ></th>
            <td ></td>
            <td ></td>
            <td ></td>
            <td class="td text-bold">Rp.{{ number_format($item->total_bayar, 2, ',', '.') }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <table class="table">
        <tbody>
        <tr>
                <td class="td-borderless text-right">Tax</td>
                <td class="td-borderless text-right">Rp.{{ number_format($transaksi->tax, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="td-borderless text-right">Total</td>
                <td class="td-borderless text-right">Rp.{{ number_format($transaksi->total_akhir_pembayaran, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="td-borderless text-right">Jaminan</td>
                <td class="td-borderless text-right">Rp.{{ number_format($reservasi->uang_jaminan, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="td-borderless text-right">Deposit</td>
                <td class="td-borderless text-right">Rp.{{ number_format($reservasi->uang_deposit, 2, ',', '.') }}</td>
            </tr>
            @if($transaksi->jumlah_pembayaran < 0)
                    <tr>
                        <td class="td-borderless text-right">Cash</td>
                        <td class="td-borderless text-right">Rp.{{ number_format(abs($transaksi->jumlah_pembayaran), 2, ',', '.') }}</td>
                    </tr>
            @else
                <tr>
                    <td class="td-borderless text-right">Kembalian deposit</td>
                    <td class="td-borderless text-right">Rp.{{ number_format($transaksi->jumlah_pembayaran, 2, ',', '.') }}</td>
                </tr>
            @endif
          </tr>
          <br/>
        </tbody>
      </table> 
      <div className='text-center'> Thanks Your visit</div>
</body>

</html>