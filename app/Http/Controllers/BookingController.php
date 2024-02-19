<?php

namespace App\Http\Controllers;

use App\Exports\PesertaExport;
use App\Mail\SendEmail;
use App\Mail\SendPdfMail;
use App\Models\Booking;
use App\Models\Peserta;
use App\Models\Trayek;
use App\Models\TrayekDetail;
use App\Models\UnitKerja;
use App\Models\UnitUtama;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use Illuminate\Support\Facades\Mail;
use Mpdf\Mpdf;

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
        $data = Booking::orderBy('approval_uker', 'ASC');

        if ($role == 4) {
            $book = $data->where('uker_id', Auth::user()->uker_id)->where('approval_uker', '!=', null)->get();
        } else if ($role == 2) {
            $book = $data->where('approval_roum', '!=', null)->get();
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

        if ($request->downloadFile == 'pdf') {
            return view('dashboard.pages.booking.pdf', compact('book', 'dataUker', 'dataUtama', 'dataTujuan', 'dataRute', 'uker', 'utama', 'rute', 'tujuan'));
        } else if ($request->downloadFile == 'excel') {
            return Excel::download(new PesertaExport, 'peserta.xlsx');
        }

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
        $status  = $request->tolak == true ? 'false' : 'true';

        $book = Booking::where('id_booking', $id)->first();
        Booking::where('id_booking', $id)->update([
            'approval_uker'  => $book->approval_uker ? $book->approval_uker : $status,
            'approval_roum'  => $book->approval_uker ? $status : null,
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

        $cekBook = Booking::where('id_booking', $id)->first();
        if ($cekBook->approval_uker == 'true' && $cekBook->approval_roum == 'true') {
            $book = Booking::where('id_booking', $id)->first();

            $data = [
                'id'      => $book->id_booking,
                'nama'    => $book->nama_pegawai,
                'nip'     => $book->nip_nik,
                'uker'    => $book->uker->nama_unit_kerja,
                'peserta' => $book->detail->count(),
                'tujuan'  => $book->tujuan->nama_kota,
                'trayek'  => $book->rute->jurusan,
                'rute'    => $book->rute->rute
            ];

            Mail::to($book->email)->send(new SendEmail($data));
        }

        return redirect()->route('book.validation', $id)->with('success', 'Berhasil Melakukan Validasi');
    }

    public function emailTicket($id)
    {
        $book = Booking::where('id_booking', $id)->first();
        // Mail::to('mfahmifadh@gmail.com')->send(new SendPdfMail($book));

        // return response()->json(['message' => 'E-Ticket sent to email.']);
        $data = [
            'id'      => $book->id_booking,
            'nama'    => $book->nama_pegawai,
            'nip'     => $book->nip_nik,
            'uker'    => $book->uker->nama_unit_kerja,
            'peserta' => $book->detail->count(),
            'tujuan'  => $book->tujuan->nama_kota,
            'trayek'  => $book->rute->jurusan,
            'rute'    => $book->rute->rute
        ];

        Mail::to($book->email)->send(new SendEmail($data));

        return redirect()->route('book.validation', $book->id_booking)->with('success', 'Email Terkirim');
    }
}
