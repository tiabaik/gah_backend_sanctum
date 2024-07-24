<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Booking_Kamar;
use App\Models\Kamar;
use App\Models\Reservasi; // Ensure this namespace is correct

class BookingKamarController extends Controller
{
    public function BookingKamar(Request $request, $id)
    {
        $reservasi = Reservasi::find($id);

        if (!$reservasi) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        if ($reservasi->status_reservasi !== 'Sudah ChekIN') {
            return response()->json(['message' => 'Invalid reservation status'], 400);
        }

        
        if($request->input('kamar')){
            foreach ($request->input('kamar') as $data) {
                $input['id_reservasi'] = $reservasi->id;
                $input['id_kamar'] = $data;
                DB::table('booking_kamar')->insert($input);

                $room = Kamar::where('id', $data)->first();
                $room->status_ketersedian_kamar = 'Not-Available';
                $room->save();
            }   
            return response()->json(['message' => 'Booking successful'], 200);
        }else{
            return response()->json(['message' => 'No available room for booking'], 400);

        }
    }
}
