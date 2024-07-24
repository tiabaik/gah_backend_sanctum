<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->tipe_kamar();
        $this->custumer();
        $this->pegawai();
        $this->kamar();
        $this->season();
        $this->promo();
        $this->jenis_custumer();
        $this->fasiltas();
        $this->harga();
        $this->reservasi();
        $this->booking_fasilitas();
        $this->booking_kamar();
        $this->transaksi();
        $this->jumlah_kamar();

    }

    public function tipe_kamar() {
        $tipe_kamar = [
            [
                'id' => 1,
                'nama_tipe' => 'Superior',
                'harga' => 500000,
                'gambar' => 'superior.jpg'
            ],[
                'id' => 2,
                'nama_tipe' => 'Double Deluxe',
                'harga' => 1000000,
                'gambar' => 'double-deluxe.jpg'
            ],[
                'id' => 3,
                'nama_tipe' => 'Exclusive Deluxe',
                'harga' => 2000000,
                'gambar' => 'exclusive-deluxe.jpg'
            ],[
                'id' => 4,
                'nama_tipe' => 'Junior Suite',
                'harga' => 3000000,
                'gambar' => 'junior-suite.jpg'
            ]
            
        ];

        DB::table('tipe_kamar')->insert($tipe_kamar);
    }

    public function custumer(){
        $custumer =[
            [
                'nama' => 'Debora',
                'no_identitas' => rand(1000000000000000, 9999999999999999),
                'no_telp' => '081235678943',
                'email' => 'debora12345@gmail.com',
                'password' => NULL,
                'alamat' => 'Jl. M.SAAD',
                'nama_institusi' => 'PT MASERO'
            ],

            [
                'nama' => 'Eric',
                'no_identitas' => rand(1000000000000000, 9999999999999999),
                'no_telp' => '0812356781123',
                'email' => 'eric12345@gmail.com',
                'password' => NULL,
                'alamat' => 'Jl. Seroja',
                'nama_institusi' => 'PT MATA HATI'
            ],
                
            
           [
                'nama' => 'Eon',
                'no_identitas' => rand(1000000000000000, 9999999999999999),
                'no_telp' => '08123567456790',
                'email' => 'eon12345@gmail.com',
                'password' => Hash::make('eon12345'),
                'alamat' => 'Jl. Kelam permai',
                'nama_institusi' => NULL
           ],

            [
                'nama' => 'okta',
                'no_identitas' => rand(1000000000000000, 9999999999999999),
                'no_telp' => '08123567456790',
                'email' => 'okta12345@gmail.com',
                'password' => Hash::make('okta12345'),
                'alamat' => 'Jl. baning permai',
                'nama_institusi' => NULL
            ],

            [
                'nama' => 'Kasih',
                'no_identitas' => rand(1000000000000000, 9999999999999999),
                'no_telp' => '08123567456790',
                'email' => 'kasih12345@gmail.com',
                'password' => Hash::make('kasih12345'),
                'alamat' => 'Jl. Kelam',
                'nama_institusi' => NULL
            ]

        ];
           DB::table('custumer')->insert($custumer);
    }

    public function pegawai(){
        $pegawai = [
            [
                'nama' => 'Bety',
                'no_identitas' => rand(1000000000000000, 9999999999999999),
                'no_telp' => '0812456789012',
                'email' => 'bety12345@gah.com',
                'alamat' => 'Jl. jerora 1',
                'password' => Hash::make('bety12345'),
                'role_pegawai'=>'ADMIN',
                'tgl_lahir'=> '1998-09-01'
            ],
            [
                'nama' => 'Eddo',
                'no_identitas' => rand(1000000000000000, 9999999999999999),
                'no_telp' => '0812456789111',
                'email' => 'eddo2345@gah.com',
                'alamat' => 'Jl. pankalin',
                'password' => Hash::make('eddo12345'),
                'role_pegawai'=>'OWNER',
                'tgl_lahir'=> '1965-09-01'
            ],
            [
                'nama' => 'Sansa',
                'no_identitas' => rand(1000000000000000, 9999999999999999),
                'no_telp' => '08124567895543',
                'email' => 'sansa12345@gah.com',
                'alamat' => 'Jl. ketapang',
                'password' => Hash::make('sansa12345'),
                'role_pegawai'=>'GENERAL MANAGER',
                'tgl_lahir'=> '1978-05-01'
            ],
            [
                'nama' => 'Cece',
                'no_identitas' => rand(1000000000000000, 9999999999999999),
                'no_telp' => '0812456770912',
                'email' => 'cece12345@gah.com',
                'alamat' => 'Jl. akcaya 1',
                'password' => Hash::make('cece12345'),
                'role_pegawai'=>'SALES MARKETING',
                'tgl_lahir'=> '1995-09-21'
            ],
            [
                'nama' => 'Yanti',
                'no_identitas' => rand(1000000000000000, 9999999999999999),
                'no_telp' => '0853456789012',
                'email' => 'yanti12345@gah.com',
                'alamat' => 'Jl. Akcaya 2',
                'password' => Hash::make('yanti12345'),
                'role_pegawai'=>'RESEPSIONIS',
                'tgl_lahir'=> '1993-02-14'
            ]
        ];

           DB::table('pegawai')->insert($pegawai);
    }
    
    public function kamar() {
        $kamar = [
            [
                'id' => 1101,
                'id_tipe' => 1,
                'status_ketersedian_kamar' => 'Available',
                'deskripsi' => 'Kamar dengan ukuruan 100 X 50',
                'kapasitas'=> 2,
                'pilihan_bad' => '1 Twin',
            ],[
                'id' => 2201,
                'id_tipe' => 2,
                'status_ketersedian_kamar' => 'Available',
                'deskripsi' => 'Kamar dengan ukuruan 100 X 100',
                'kapasitas'=> 2,
                'pilihan_bad' => ' 2 Twin',
            ],[
                'id' => 3301,
                'id_tipe' => 3,
                'status_ketersedian_kamar' => 'Available',
                'deskripsi' => 'Kamar dengan ukuruan 400 X 400',
                'kapasitas'=> 2,
                'pilihan_bad' => '1 king ',
            ],
            [
                'id' => 4401,
                'id_tipe' => 4,
                'status_ketersedian_kamar' => 'Available',
                'deskripsi' => 'Kamar dengan ukuruan 600 X 600',
                'kapasitas'=> 2,
                'pilihan_bad' => '1 king ',
            ],
            [
                'id' => 1102,
                'id_tipe' => 1,
                'status_ketersedian_kamar' => 'Non-Available',
                'deskripsi' => 'Kamar dengan ukuruan 100 X 50',
                'kapasitas'=> 2,
                'pilihan_bad' => ' 1 Twin',
            ],[
                'id' => 2202,
                'id_tipe' => 2,
                'status_ketersedian_kamar' => 'Non-Available',
                'deskripsi' => 'Kamar dengan ukuruan 100 X 100',
                'kapasitas'=> 2,
                'pilihan_bad' => ' 2 Twin',
            ],[
                'id' => 3302,
                'id_tipe' => 3,
                'status_ketersedian_kamar' => 'Non-Available',
                'deskripsi' => 'Kamar dengan ukuruan 400 X 400',
                'kapasitas'=> 2,
                'pilihan_bad' => '1 king ',
            ],
            [
                'id' => 4402,
                'id_tipe' => 4,
                'status_ketersedian_kamar' => 'Non-Available',
                'deskripsi' => 'Kamar dengan ukuruan 600 X 600',
                'kapasitas'=> 2,
                'pilihan_bad' => '1 king ',
            ],
            [
                'id' => 1103,
                'id_tipe' => 1,
                'status_ketersedian_kamar' => 'Available',
                'deskripsi' => 'Kamar dengan ukuruan 100 X 50',
                'kapasitas'=> 2,
                'pilihan_bad' => '1 double',
                
            ],[
                'id' => 2203,
                'id_tipe' => 2,
                'status_ketersedian_kamar' => 'Available',
                'deskripsi' => 'Kamar dengan ukuruan 100 X 100',
                'kapasitas'=> 2,
                'pilihan_bad' => '1 double',
            ],[
                'id' => 3303,
                'id_tipe' => 3,
                'status_ketersedian_kamar' => 'Available',
                'deskripsi' => 'Kamar dengan ukuruan 400 X 400',
                'kapasitas'=> 2,
                'pilihan_bad' => '1 king',
            ],
            [
                'id' => 4403,
                'id_tipe' => 4,
                'status_ketersedian_kamar' => 'Available',
                'deskripsi' => 'Kamar dengan ukuruan 600 X 600',
                'kapasitas'=> 2,
                'pilihan_bad' => ' 1 king',
            ],
            [
                'id' => 1104,
                'id_tipe' => 1,
                'status_ketersedian_kamar' => 'Non-Available',
                'deskripsi' => 'Kamar dengan ukuruan 100 X 50',
                'kapasitas'=> 2,
                'pilihan_bad' => ' 1 double',
            ],[
                'id' => 2204,
                'id_tipe' => 2,
                'status_ketersedian_kamar' => 'Non-Available',
                'deskripsi' => 'Kamar dengan ukuruan 100 X 100',
                'kapasitas'=> 2,
                'pilihan_bad' => '1 double',
            ],[
                'id' => 3304,
                'id_tipe' => 3,
                'status_ketersedian_kamar' => 'Non-Available',
                'deskripsi' => 'Kamar dengan ukuruan 400 X 400',
                'kapasitas'=> 2,
                'pilihan_bad' => '1 king',
            ],
            [
                'id' => 4404,
                'id_tipe' => 4,
                'status_ketersedian_kamar' => 'Non-Available',
                'deskripsi' => 'Kamar dengan ukuruan 600 X 600',
                'kapasitas'=> 2,
                'pilihan_bad' => '1 king',
            ]
            
        ];
        DB::table('kamar')->insert($kamar);
    }

    public function season(){
            $season = [
                [
                    'id' => 1,
                    'nama_season' => 'Promo',
                    'tanggal_mulai' => '2023-02-01',
                    'tanggal_selesai' => '2023-04-30',
                ],[
                    'id' => 2,
                    'nama_season' => 'Normal',
                    'tanggal_mulai' => '2023-06-01',
                    'tanggal_selesai' => '2023-08-31',
                ],[
                    'id' => 3,
                    'nama_season' => 'High Season',
                    'tanggal_mulai' => '2023-09-01',
                    'tanggal_selesai' => '2024-01-31',
                ]
                
            ];
    
            DB::table('season')->insert($season);
    }

    public function promo(){
        $promo = [
            [
                'kode_unik' => 'LIBURAN HAPPY 1',
                'potongan_harga' => 30000,
                'nama_promo' => 'HEPPY 1',
                'ket_status' => 'Belum Terpakai',
                'tanggal_mulai' => '2024-01-01',
                'tanggal_berakhir' => '2025-01-31',

            ],
            [
                'kode_unik' => 'LIBURAN HAPPY 2',
                'potongan_harga' => 30000,
                'nama_promo' => 'HEPPY 2',
                'ket_status' => 'Belum Terpakai',
                'tanggal_mulai' => '2025-01-01',
                'tanggal_berakhir' => '2026-01-01',
            ],
            [
                'kode_unik' => 'LIBURAN HAPPY 3',
                'potongan_harga' => 30000,
                'nama_promo' => 'HEPPY 3',
                'ket_status' => 'Belum Terpakai',
                'tanggal_mulai' => '2027-01-01',
                'tanggal_berakhir' => '2028-01-31',
            ],
            [
                'kode_unik' => 'AKHIRNYA HAPPY 4',
                'potongan_harga' => 30000,
                'nama_promo' => 'ASIKNYA AKHIR TAHUN 4',
                'ket_status' => 'Terpakai',
                'tanggal_mulai' => '2021-01-01',
                'tanggal_berakhir' => '2022-01-31',
            ],
            [
                'kode_unik' => 'AKHIRNYA HAPPY 5',
                'potongan_harga' => 30000,
                'nama_promo' => 'ASIKNYA AKHIR TAHUN 4',
                'ket_status' => 'Terpakai',
                'tanggal_mulai' => '2022-01-01',
                'tanggal_berakhir' => '2023-01-31',
            ]
        
        ];

        DB::table('promo')->insert($promo);
      
    }

    public function jenis_custumer(){
        $jenis_custumer = [
            [
                'id' => 1,
                'nama_jenis_custumer' => 'Personal',
            ],[
                'id' => 2,
                'nama_jenis_custumer' => 'Grup',
            ]
        ];

        DB::table('jenis_custumer')->insert($jenis_custumer);
            
    }

    public function fasiltas(){
        $fasilitas = [
            [
                'id' => 1,
                'nama_fasilitas' => 'Laundry (per baju)',
                'harga_fasilitas' => '20000'
            ],
            
            [
                'id' => 2,
                'nama_fasilitas' => 'Extra Breakfast (per pax) ',
                'harga_fasilitas' => '50000'
            ],
            
            [
                'id' => 3,
                'nama_fasilitas' => 'Extra Bed (per bed ) ',
                'harga_fasilitas' => '200000'
            ],
            [
                'id' => 4,
                'nama_fasilitas' => 'Massage (durasi 1 jam )',
                'harga_fasilitas' => '150000'
            ],
            [
                'id' => 5,
                'nama_fasilitas' => 'Meeting Room (per jam )',
                'harga_fasilitas' => '50000'
            ],
    
        ];

        DB::table('fasilitas')->insert($fasilitas);
            
    }

    public function harga(){
        $harga = [
            [
                'id' => 1,
                'id_tipe' => 1,
                'id_season' => 3,
                'harga' => 600000,
            ],[
                'id' => 2,
                'id_tipe' => 2,
                'id_season' => 3,
                'harga' => 1500000,
            ],[
                'id' => 3,
                'id_tipe' => 3,
                'id_season' => 3,
                'harga' => 2500000,
            ],[
                'id' => 4,
                'id_tipe' => 4,
                'id_season' => 3,
                'harga' => 3500000,
            ]
        ];

        DB::table('harga')->insert($harga);
            
    }

    public function booking_fasilitas(){
        $booking_fasilitas = [
            [
                'id' => 1,
                'id_fasilitas' => 1,
                'id_reservasi' => 1,
                'tgl_booking_fasilitas' => '2023-10-23',
                'jumlah_booking_fasilitas' => 2,
            ],[
                'id' => 2,
                'id_fasilitas' => 2,
                'id_reservasi' => 1,
                'tgl_booking_fasilitas' => '2023-10-23',
                'jumlah_booking_fasilitas' => 2,
            ],[
                'id' => 3,
                'id_fasilitas' => 3,
                'id_reservasi' => 2,
                'tgl_booking_fasilitas' => '2023-11-23',
                'jumlah_booking_fasilitas' => 1,
            ],[
                'id' => 4,
                'id_fasilitas' => 4,
                'id_reservasi' => 3,
                'tgl_booking_fasilitas' => '2023-11-24',
                'jumlah_booking_fasilitas' => 1,
            ],[
                'id' => 5,
                'id_fasilitas' => 5,
                'id_reservasi' => 4,
                'tgl_booking_fasilitas' => '2023-11-24',
                'jumlah_booking_fasilitas' => 1,
            ]
            
        ];
        
        DB::table('booking_fasilitas')->insert($booking_fasilitas);
            
    }


    public function booking_kamar(){
        $booking_kamar = [
            [
                'id' => 1,
                'id_kamar' => 1101,
                'id_reservasi' => 1,
            ],[
                'id' => 2,
                'id_kamar' => 1102,
                'id_reservasi' => 2,
            ],[
                'id' => 3,
                'id_kamar' => 2201,
                'id_reservasi' => 2,
            ],[
                'id' => 4,
                'id_kamar' => 2202,
                'id_reservasi' => 2,
            ],[
                'id' => 5,
                'id_kamar' => 2203,
                'id_reservasi' => 2,
            ],[
                'id' => 6,
                'id_kamar' => 3301,
                'id_reservasi' => 3,
            ],[
                'id' => 7,
                'id_kamar' => 3302,
                'id_reservasi' => 3,
            ],[
                'id' => 8,
                'id_kamar' => 3303,
                'id_reservasi' => 3,
            ]

        ];
        DB::table('booking_kamar')->insert($booking_kamar);
    }
    public function transaksi(){
        $transaksi = [
            [
                'id' => "G021123-1",
                'id_pegawai' => 5,
                'id_reservasi' => 1,
                'tgl_transaksi' => '2023-11-02',
                'tax' => 74000,
                'diskon' => 0,
                'total_pembayaran' => 740000,
                'total_akhir_pembayaran'=>814000,
                'jumlah_pembayaran' => -300000,


            ],[
                'id' => "G291123-1",
                'id_pegawai' => 5,
                'id_reservasi' => 2,
                'tgl_transaksi' => '2023-11-29',
                'tax' => 530000,
                'diskon' => 300000,
                'total_pembayaran' => 5300000,
                'total_akhir_pembayaran'=>5830000,
                'jumlah_pembayaran' => 2200000,
            ],[
                'id' => "P011223-1",
                'id_pegawai' => 5,
                'id_reservasi' => 3,
                'tgl_transaksi' => '2023-12-01',
                'tax' => 765000,
                'diskon' => 0,
                'total_pembayaran' => 7650000,
                'total_akhir_pembayaran' => 8415000,
                'jumlah_pembayaran' => 3450000,
            ],
            

        ];

        DB::table('transaksi')->insert($transaksi);
    }

    public function reservasi(){
        $reservasi = [
            [
                'id' => 1,
                'id_custumer' => 1,
                'id_pegawai' => 4,
                'id_jenis_custumer' => 2,
                'tgl_reservasi' => '2023-10-01',
                'tgl_cek_in' => '2023-11-01',
                'tgl_cek_out' => '2023-11-02',
                'tgl_deposit' => '2023-11-01',
                'tgl_uang_jaminan' => '2023-10-01',
                'org_anak' => 0,
                'org_dewasa' => 1,
                'kode_booking' => 'G011023-1',
                'uang_deposit' => 300000,
                'uang_jaminan' => 400000,
                'permintaan_khusus' => NULL,
                'status_reservasi' => 'Completed'
                
            ],[
                'id' => 2,
                'id_custumer' => 2,
                'id_pegawai' => 4,
                'id_jenis_custumer' => 2,
                'tgl_reservasi' => '2023-10-29',
                'tgl_cek_in' => '2023-11-28',
                'tgl_cek_out' => '2023-11-29',
                'tgl_deposit' => '2023-11-28',
                'tgl_uang_jaminan' => '2023-10-29',
                'org_anak' => 0,
                'org_dewasa' => 3,
                'kode_booking' => 'G291023-2',
                'uang_deposit' => 300000,
                'uang_jaminan' => 2250000,
                'permintaan_khusus' => NULL,
                'status_reservasi' => 'Completed'
            ],[
                'id' => 3,
                'id_custumer' => 3,
                'id_jenis_custumer' => 1,
                'id_pegawai' => NULL,
                'tgl_reservasi' => '2023-11-29',
                'tgl_cek_in' => '2023-11-30',
                'tgl_cek_out' => '2023-12-01',
                'tgl_deposit' => '2023-11-30',
                'tgl_uang_jaminan' => '2023-11-29',
                'org_anak' => 2,
                'org_dewasa' => 4,
                'kode_booking' => 'P291123-3',
                'uang_deposit' => 300000,
                'uang_jaminan' => 6885000,
                'permintaan_khusus' => 'bebas asap rokok',
                'status_reservasi' => 'Completed',
            ],

            [
                'id' => 4,
                'id_custumer' => 4,
                'id_jenis_custumer' => 1,
                'id_pegawai' => NULL,
                'tgl_reservasi' => '2023-11-02',
                'tgl_cek_in' => '2023-11-03',
                'tgl_cek_out' => '2023-11-04',
                'tgl_deposit' => NULL,
                'tgl_uang_jaminan' => '2023-11-02',
                'org_anak' => 0,
                'org_dewasa' => 1,
                'kode_booking' => 'P021123-4',
                'uang_deposit' => NULL,
                'uang_jaminan' => 3500000,
                'permintaan_khusus' => NULL,
                'status_reservasi' => 'ON GOING',
            ],

            [
                'id' => 5,
                'id_custumer' => 5,
                'id_pegawai' => NULL,
                'id_jenis_custumer' => 1,
                'tgl_reservasi' => '2023-10-25',
                'tgl_cek_in' => '2023-11-25',
                'tgl_cek_out' => '2023-11-26',
                'tgl_deposit' => NULL,
                'tgl_uang_jaminan' => NULL,
                'org_anak' => 2,
                'org_dewasa' => 2,
                'kode_booking' => NULL,
                'uang_deposit' => Null,
                'uang_jaminan' => Null,
                'permintaan_khusus' => NULL,
                'status_reservasi' => 'On Going',
            ],
        ];

        DB::table('reservasi')->insert($reservasi);
    }

    
    public function jumlah_kamar(){
        $jumlah_kamar = [
            [
                'id' => 1,
                'id_tipe' => 1,
                'id_reservasi' => 1,
                'jumlah_kamar' => 1,
            ],[
                'id' => 2,
                'id_tipe' => 1,
                'id_reservasi' => 2,
                'jumlah_kamar' => 1,
            ],[
                'id' => 3,
                'id_tipe' => 2,
                'id_reservasi' => 2,
                'jumlah_kamar' => 3,
            ],[
                'id' => 4,
                'id_tipe' => 3,
                'id_reservasi' => 3,
                'jumlah_kamar' => 3,
            ],
            [
                'id' => 5,
                'id_tipe' => 4,
                'id_reservasi' => 4,
                'jumlah_kamar' => 1,
            ],
            [
                'id' => 6,
                'id_tipe' => 1,
                'id_reservasi' => 5,
                'jumlah_kamar' => 2,
            ],


        ];
        DB::table('jumlah_kamar')->insert($jumlah_kamar);
    }
}