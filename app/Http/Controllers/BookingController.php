<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Peserta;
use App\Models\Trayek;
use App\Models\TrayekDetail;
use App\Models\UnitKerja;
use App\Models\UnitUtama;
use Illuminate\Http\Request;
use Auth;

class BookingController extends Controller
{
    public function index()
    {
        $dataTujuan = [];
        $dataUker   = [];
        $dataUtama  = UnitUtama::orderBy('nama_unit_utama', 'ASC')->get();
        $dataRute   = Trayek::orderBy('id_trayek', 'ASC')->get();
        $uker       = '';
        $utama      = '';
        $rute       = '';
        $tujuan     = '';
        $role = Auth::user()->role_id;
        $data = Booking::orderBy('status', 'ASC');

        if ($role == 4) {
            $book = $data->where('uker_id', Auth::user()->uker_id)->where('status', '!=', null)->get();
        } else {
            $book = $data->get();
        }

        return view('dashboard.pages.booking.show', compact('book', 'dataUker', 'dataUtama', 'dataTujuan', 'dataRute', 'uker', 'utama', 'rute', 'tujuan'));
    }

    public function filter(Request $request)
    {
        $dataTujuan = [];
        $dataUker   = [];
        $dataUtama  = UnitUtama::orderBy('nama_unit_utama', 'ASC')->get();
        $dataRute   = Trayek::orderBy('id_trayek', 'ASC')->get();
        $utama      = $request->get('utama');
        $uker       = $request->get('uker');
        $rute       = $request->get('rute');
        $tujuan     = $request->get('tujuan');
        $data       = Booking::orderBy('id_booking', 'ASC')->join('t_unit_kerja', 'id_unit_kerja', 'uker_id');

        if ($utama || $uker || $rute || $tujuan) {
            if ($utama) {
                $res      = $data->where('unit_utama_id', $utama);
                $dataUker = UnitKerja::where('unit_utama_id', $utama)->get();
            }

            if ($uker) {
                $res      = $data->where('uker_id', $uker);
            } else {
                $res      = $data;
            }

            if ($rute) {
                $res        = $data->where('trayek_id', $rute);
                $dataTujuan = TrayekDetail::where('trayek_id', $rute)->get();
            }

            if ($tujuan && $rute) {
                $res        = $data->where('tujuan_id', $tujuan);
            }
        } else {
            $res    = $data;
        }

        $book = $res->get();

        return view('dashboard.pages.booking.show', compact('book', 'dataUker', 'dataUtama', 'dataTujuan', 'dataRute', 'uker', 'utama', 'rute', 'tujuan'));
    }

    public function validation($id)
    {
        $book = Booking::where('id_booking', $id)->first();
        return view('dashboard.pages.booking.validation', compact('book'));
    }

    public function storeValidation(Request $request, $id)
    {
        $catatan = $request->input('catatan', null);
        $status  = $catatan ? 'false' : 'true';

        Booking::where('id_booking', $id)->update([
            'status'  => $status,
            'catatan' => $catatan
        ]);

        if ($status == 'true') {
            Peserta::where('booking_id', $id)->update([
                'status' => 'full'
            ]);
        } else if ($status == 'false') {
            Peserta::where('booking_id', $id)->update([
                'status' => 'cancel'
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Berhasil Melakukan Validasi');
    }
}
