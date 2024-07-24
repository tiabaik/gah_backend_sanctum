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
            <hr style="margin-top: 40px; margin-bottom: 10px;"/>
            <h5 style="text-align:center; font-weight: 900;">LAPORAN TOP 5 CUSTOMER </h5>
            
        </div>
            <div>
            <div class='text-center'> Tahun : {{$tahun}}</div>
                <table class="table w-full">
                    <!-- Head -->
                    <thead>
                        <tr>
                            <th class="th">Nomor</th>
                            <th class="th">Nama Customer</th>
                            <th class="th">Jumlah Reservasi</th>
                            <th class="th">Total Pembayarn</th>
                        </tr>
                    </thead>
                    <!-- Body -->
                    <tbody>
                    @foreach($data as $index => $item)
                    <tr>
                        <td class="td">{{ $index + 1 }}</td></th>
                        <th class="th">{{$item->customer_name}}</th>
                        <th class="th">{{$item->total_transactions}}</th>
                        <td class="td">{{$item->total_payments}}</td>
                    </tr>
                    </tr>
                    @endforeach
                </table>
            </div>
        
            <br/>
            <div class='text-center'> diecetak pada tanggal {{$tanggal}}</div>
        </div>
    </div>
</body>

</html>