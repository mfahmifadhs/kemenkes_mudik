<?php

namespace App\Http\Controllers;

use App\Exports\BusExport;
use App\Models\Booking;
use App\Models\Bus;
use App\Models\Peserta;
use App\Models\Trayek;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Auth;

class BusController extends Controller
{
    public function index()
    {
        $bus = Bus::get();
        $trayek = Trayek::get();
        return view('dashboard.pages.bus.show', compact('bus', 'trayek'));
    }

    public function detail($id)
    {
        $user    = Auth::user();
        $seatCek = Peserta::select(DB::RAW('concat(kode_seat, bus_id) as seat_booked'), 'status')->get();
        $bus     = Bus::where('id_bus', $id)->get();
        $data    = Peserta::join('t_booking', 'id_booking', 'booking_id')
                   ->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
                   ->select('t_peserta.status', 't_peserta.*', 't_booking.uker_id')
                   ->where('status', '!=', 'cancel')
                   ->where('bus_id', $id);

        if ($user->role_id == 4 && Auth::user()->uker->unit_utama_id == '46593') {
            $peserta = $data->where('uker_id', Auth::user()->uker_id)->where('approval_uker', null)->get();
        } else if ($user->role_id == 4) {
            $peserta = $data->where('unit_utama_id', Auth::user()->uker->unit_utama_id)->where('approval_uker', null)->get();
        } else {
            $peserta = $data->get();
        }

        return view('dashboard.pages.bus.detail', compact('id', 'seatCek', 'bus', 'peserta'));
    }

    public function export($id)
    {
        if ($id == 'excel') {
            return Excel::download(new BusExport, 'bus.xlsx');
        }
    }

    public function pdfSeat()
    {
        $user    = Auth::user();
        $seatCek = Peserta::select(DB::RAW('concat(kode_seat, bus_id) as seat_booked'), 'status')->get();
        $bus     = Bus::get();
        $data    = Peserta::join('t_booking', 'id_booking', 'booking_id')
                   ->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
                   ->select('t_peserta.status', 't_peserta.*', 't_booking.uker_id')
                   ->where('status', '!=', 'cancel');

        if ($user->role_id == 4 && Auth::user()->uker->unit_utama_id == '46593') {
            $peserta = $data->where('uker_id', Auth::user()->uker_id)->where('approval_uker', null)->get();
        } else if ($user->role_id == 4) {
            $peserta = $data->where('unit_utama_id', Auth::user()->uker->unit_utama_id)->where('approval_uker', null)->get();
        } else {
            $peserta = $data->get();
        }

        return view('dashboard.pages.bus.pdf_seat', compact('seatCek', 'bus', 'peserta'));
    }

    public function pdfKk($id)
    {
        $bus = Bus::where('id_bus', $id)->first();
        $peserta = Peserta::join('t_booking', 'id_booking', 'booking_id')
                   ->where('bus_id', $id)->where('approval_uker', 'true')->where('approval_roum', 'true')
                   ->get();
        return view('dashboard.pages.bus.pdf_kk', compact('bus','peserta'));
    }

    public function update(Request $request, $id)
    {
        Bus::where('id_bus', $id)->update([
            'no_plat' => $request->no_plat,
            'deskripsi' => $request->deskripsi,
            'seat_kiri' => $request->seat_kiri,
            'kd_seat_kiri' => $request->kode_seat_kiri,
            'seat_kanan' => $request->seat_kanan,
            'kd_seat_kanan' => $request->kode_seat_kanan,
            'seat_belakang' => $request->seat_belakang,
            'kd_seat_belakang' => $request->kode_seat_belakang,
            'keterangan' => $request->keterangan,
            'trayek_id' => $request->trayek,
            'status' => $request->status
        ]);

        return redirect()->route('bus')->with('success', 'Data bus berhasil diperbarui.');
    }
}

