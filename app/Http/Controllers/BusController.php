<?php

namespace App\Http\Controllers;

use App\Exports\BusExport;
use App\Models\Booking;
use App\Models\Bus;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Auth;

class BusController extends Controller
{
    public function index()
    {
        $bus = Bus::get();
        return view('dashboard.pages.bus.show', compact('bus'));
    }

    public function detail($id)
    {
        $user    = Auth::user();
        $seatCek = Peserta::select(DB::RAW('concat(kode_seat, bus_id) as seat_booked'), 'status')->get();
        $bus     = Bus::where('id_bus', $id)->get();
        $data    = Peserta::join('t_booking', 'id_booking', 'booking_id')->select('t_peserta.status', 't_peserta.*', 't_booking.uker_id')->where('bus_id', $id);

        if ($user->role_id == 4) {
            $peserta = $data->where('t_peserta.status', '!=', 'cancel')->where('uker_id', $user->uker_id)->get();
        } else {
            $peserta = $data->get();
        }

        return view('dashboard.pages.bus.detail', compact('seatCek', 'bus', 'peserta'));
    }

    public function export($id)
    {
        if ($id == 'excel') {
            return Excel::download(new BusExport, 'bus.xlsx');
        }
    }
}

