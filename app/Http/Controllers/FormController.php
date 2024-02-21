<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\Peserta;
use App\Models\Trayek;
use App\Models\TrayekDetail;
use App\Models\UnitKerja;
use App\Models\UnitUtama;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Mpdf\Mpdf;

class FormController extends Controller
{
    public function create(Request $request)
    {
        $seatTotal = 0;
        $seatCek   = [];
        $peserta   = $request->get('peserta', []);
        $rute   = $request->get('rute', '');
        $step   = $request->get('step', '');
        $seat   = $request->get('seat', '');
        $dest   = $request->get('dest', '');
        $bus    = [];
        $data   = [];
        $utama  = UnitUtama::orderBy('nama_unit_utama', 'ASC')->get();
        $trayek = Trayek::get();
        $seatFull = $request->get('full', '');
        $bookId   = $request->get('id_book', '');

        if ($rute) {
            $seatCek = Peserta::select(DB::RAW('concat(kode_seat, bus_id) as seat_booked'), 'status')->get();
            $bus  = Bus::where('trayek_id', $rute)->get();
            $rute = Trayek::where('id_trayek', $rute)->first();

            $data = [
                'nama'    => $request->get('nama'),
                'uker'    => $request->get('uker'),
                'nip_nik' => $request->get('nip_nik'),
                'no_telp' => $request->get('no_telp'),
                'alamat'  => $request->get('alamat'),
                'email'   => $request->get('email'),
                'tujuan'  => $request->get('dest')
            ];
        }

        if ($step == 2) {
            if (!$seat) {
                return back()->with('failed', 'Anda belum memilih kursi');
            }

            $seatTotal = count($seat);
            $data = json_decode($request->data);
        }

        return view('form.create', compact('rute', 'utama', 'trayek', 'step', 'data', 'bus', 'seat', 'seatCek', 'seatTotal', 'seatFull', 'peserta', 'bookId'));
    }

    public function store(Request $request)
    {
        dd($request->all());
        $seatCek = 0;
        $bus  = $request->bus;
        $seat = $request->seat;

        if ($request->seatFull == 'true') {
            $seatArr = array_map(function ($value) {
                return substr($value, strpos($value, '-') + 1);
            }, $seat);
            $busArr = array_map(function ($value) {
                return substr($value, 0,  strpos($value, '-'));
            }, $seat);

            $seatCek = Peserta::whereIn('bus_id', $busArr)->whereIn('kode_seat', $seatArr)->where('status', '!=', 'cancel')->count();
            $id_book = $request->id_book;
            if ($seatCek != 0) {
                $peserta = Peserta::where('booking_id', $id_book)->pluck('id_peserta')->toArray();
                $full = 'true';
                $step = 1;
                $rute = $request->rute;
                return redirect()->route('form.create', compact('rute', 'step', 'full', 'peserta', 'id_book'))->with('failed', 'Bangku Penuh');
            } else {
                foreach ($seatArr as $i => $seat_id) {
                    $pesertaArr = explode(',', $request->peserta);
                    $pesertaId  = $pesertaArr[$i];

                    Peserta::where('id_peserta', $pesertaId)->update([
                        'bus_id'    => $busArr[$i],
                        'kode_seat' => $seat_id
                    ]);
                }
                return redirect()->route('form.confirm', $id_book)->with('success', 'Berhasil Registrasi');
            }

        }

        $data      = json_decode($request->data);
        $id_book   = str_pad(Booking::withTrashed()->count() + 1, 4, 0, STR_PAD_LEFT);
        $kode_book = Carbon::now()->format('ymdHis') . $id_book;

        $tambah  = new Booking();
        $tambah->id_booking   = $id_book;
        $tambah->kode_booking = $kode_book;
        $tambah->trayek_id    = $request->rute;
        $tambah->tujuan_id    = $data->tujuan;
        $tambah->uker_id      = $data->uker;
        $tambah->nama_pegawai = $data->nama;
        $tambah->nip_nik      = $data->nip_nik;
        $tambah->no_telp      = $data->no_telp;
        $tambah->alamat       = $data->alamat;
        $tambah->email        = $data->email;
        $tambah->created_at   = Carbon::now();
        $tambah->save();

        $seatCek = Peserta::whereIn('bus_id', $bus)->whereIn('kode_seat', $seat)->where('status', '!=', 'cancel')->count();
        foreach ($seat as $key => $seat_id) {
            $total      = str_pad(Peserta::withTrashed()->count() + 1, 4, 0, STR_PAD_LEFT);
            $id_peserta = Carbon::now()->format('ymd') . $total;

            $detail = new Peserta();
            $detail->id_peserta   = $id_peserta;
            $detail->booking_id   = $id_book;
            $detail->bus_id       = $request->bus[$key];
            $detail->kode_seat    = $seatCek ==  0 ? $seat_id : null;
            $detail->nama_peserta = $request->peserta[$key];
            $detail->nik          = $request->nik_peserta[$key];
            $detail->usia         = $request->usia_peserta[$key];
            $detail->created_at   = Carbon::now();
            $detail->save();

            if ($request->foto_vaksin_1[$key]) {
                $vaksin_1 = $request->file('foto_vaksin_1')[$key];
                $fileVaksin1  = 'vaksin1_' . now()->timestamp . '_' . $vaksin_1->getClientOriginalName();
                $vaksin_1->storeAs('public/files/vaksin_1', $fileVaksin1);
            }

            if ($request->foto_vaksin_2[$key]) {
                $vaksin_2 = $request->file('foto_vaksin_2')[$key];
                $fileVaksin2  = 'vaksin2_' . now()->timestamp . '_' . $vaksin_2->getClientOriginalName();
                $vaksin_2->storeAs('public/files/vaksin_2', $fileVaksin2);
            }

            if ($request->foto_vaksin_3[$key]) {
                $vaksin_3 = $request->file('foto_vaksin_3')[$key];
                $fileVaksin3  = 'vaksin3_' . now()->timestamp . '_' . $vaksin_3->getClientOriginalName();
                $vaksin_3->storeAs('public/files/vaksin_3', $fileVaksin3);

            }

            Peserta::where('id_peserta', $id_peserta)->update([
                'foto_vaksin_1' => $request->foto_vaksin_1[$key] ? $fileVaksin1 : null,
                'foto_vaksin_2' => $request->foto_vaksin_2[$key] ? $fileVaksin2 : null,
                'foto_vaksin_3' => $request->foto_vaksin_3[$key] ? $fileVaksin3 : null
            ]);
        }

        if ($request->foto_ktp || $request->foto_kk) {
            $ktp      = $request->file('foto_ktp');
            $kk       = $request->file('foto_kk');
            $fileKtp  = 'ktp_' . now()->timestamp . '_' . $ktp->getClientOriginalName();
            $fileKk   = 'kk_' . now()->timestamp . '_' . $ktp->getClientOriginalName();

            $ktp->storeAs('public/files/foto_ktp', $fileKtp);
            $kk->storeAs('public/files/foto_kk', $fileKk);
            Booking::where('id_booking', $id_book)->update([
                'foto_ktp' => $fileKtp,
                'foto_kk'  => $fileKk
            ]);
        }

        if ($seatCek != 0) {
            $peserta = Peserta::where('booking_id', $id_book)->pluck('id_peserta')->toArray();
            $full = 'true';
            $step = 1;
            $rute = $request->rute;
            return redirect()->route('form.create', compact('rute', 'step', 'full', 'data', 'peserta', 'id_book'))->with('failed', 'Bangku Penuh');
        }

        return redirect()->route('form.confirm', $id_book)->with('success', 'Berhasil Registrasi');
    }

    public function confirm($id)
    {
        $book = Booking::where('id_booking', $id)->first();
        $detail = Peserta::where('booking_id', $id)->get();
        return view('form.confirm', compact('book', 'detail'));
    }

    public function ticket($id)
    {
        $book = Booking::where('id_booking', $id)->first();

        $data = [
            'book'      => $book->id_booking,
            'kode_book' => $book->kode_booking,
            'jurusan'   => $book->rute->jurusan,
            'rute'      => $book->rute->rute,
            'tujuan'    => $book->tujuan->nama_kota,
            'peserta'   => $book->detail
        ];

        $mpdf = new Mpdf();
        $mpdf->WriteHTML(view('dashboard.pages.booking.ticket', $data)->render());
        $mpdf->Output('e-ticket.pdf', 'D');

    }

    public function check(Request $request)
    {
        $kode = $request->kode;
        $book = Booking::where('kode_booking', $kode)->orWhere('nip_nik', $kode)->first();
        $note = $book ? $book->catatan : 'Tidak tidak ditemukan';

        if ($book && $book->approval_uker == 'true' && $book->approval_roum == 'true') {
            return redirect()->route('form.confirm', $book->id_booking)->with('success', 'Tiket ditemukan');
        } else if ($book && $book->approval_uker == null || $book->approval_roum) {
            return redirect()->route('tiket.check')->with('pending', 'Sedang dalam proses Validasi');
        } else {
            return redirect()->route('tiket.check')->with('failed', $note);
        }
    }

    public function selectDest($id)
    {
        $data = TrayekDetail::where('trayek_id', $id)->get();
        $response = array();

        $response[] = array(
            "id"    => "",
            "text"  => "-- Pilih Kota Tujuan --"
        );

        foreach($data as $row){
            $response[] = array(
                "id"    =>  $row->id_detail,
                "text"  =>  strtoupper($row->nama_kota)
            );
        }

        return response()->json($response);
    }

    public function selectUker($id)
    {
        $data = UnitKerja::where('unit_utama_id', $id)->orderBy('nama_unit_kerja', 'ASC')->get();
        $response = array();

        $response[] = array(
            "id"    => "",
            "text"  => "-- Pilih Unit Kerja --"
        );

        foreach($data as $row){
            $response[] = array(
                "id"    =>  $row->id_unit_kerja,
                "text"  =>  $row->nama_unit_kerja
            );
        }

        return response()->json($response);
    }
}
