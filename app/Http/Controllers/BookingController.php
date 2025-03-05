<?php

namespace App\Http\Controllers;

use App\Exports\BookingExport;
use App\Exports\PesertaExport;
use App\Mail\SendEmail;
use App\Mail\SendPdfMail;
use App\Models\Booking;
use App\Models\Bus;
use App\Models\Peserta;
use App\Models\Trayek;
use App\Models\TrayekDetail;
use App\Models\UnitKerja;
use App\Models\UnitUtama;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class BookingController extends Controller
{
    public function index()
    {
        $dataTujuan = [];
        $resUker    = [];
        $dataUtama  = UnitUtama::orderBy('nama_unit_utama', 'ASC')->get();
        $dataRute   = Trayek::orderBy('id_trayek', 'ASC')->get();
        $uker       = '';
        $utama      = '';
        $rute       = '';
        $tujuan     = '';
        $status     = '';
        $role = Auth::user()->role_id;
        $data = Booking::select('t_booking.created_at', 't_booking.*', 'unit_utama_id')
            ->orderBy('t_booking.created_at', 'DESC')->orderBy('approval_uker', 'ASC')
            ->join('t_unit_kerja', 'id_unit_kerja', 'uker_id');

        if ($role == 4 && Auth::user()->uker->unit_utama_id == '46593') {
            $book = $data->where('uker_id', Auth::user()->uker_id)->get();
            $dataUker = UnitKerja::where('id_unit_kerja', Auth::user()->uker_id)->get();
        } else if ($role == 4) {
            $book = $data->where('unit_utama_id', Auth::user()->uker->unit_utama_id)->get();
            $dataUker = UnitKerja::where('unit_utama_id', Auth::user()->uker->unit_utama_id)->get();
        } else {
            $book = $data->get();
            $dataUker = $resUker;
        }

        return view('dashboard.pages.booking.show', compact('book', 'dataUker', 'dataUtama', 'dataTujuan', 'dataRute', 'uker', 'utama', 'rute', 'tujuan', 'status'));
    }

    public function filter(Request $request)
    {
        $dataTujuan = [];
        $dataUker   = Auth::user()->role_id == 4 ? UnitKerja::where('unit_utama_id', Auth::user()->uker->unit_utama_id)->get() : [];
        $dataUtama  = UnitUtama::orderBy('nama_unit_utama', 'ASC')->get();
        $dataRute   = Trayek::orderBy('id_trayek', 'ASC')->get();
        $utama      = $request->get('utama');
        $uker       = $request->get('uker');
        $rute       = $request->get('rute');
        $tujuan     = $request->get('tujuan');
        $status     = $request->get('status');
        $data       = Booking::select('t_booking.created_at', 't_booking.*', 'unit_utama_id')
            ->orderBy('id_booking', 'ASC')->join('t_unit_kerja', 'id_unit_kerja', 'uker_id');

        if ($utama || $uker || $rute || $tujuan || $status) {
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

            if ($status) {
                if ($status == 'verif_uker') {
                    $res = $data->where('approval_uker', null);
                } else if ($status == 'verif_roum') {
                    $res = $data->where('approval_roum', null)
                        ->where('approval_uker', 'true');
                } else if ($status == 'succeed') {
                    $res = $data->where('approval_uker', 'true')
                        ->where('approval_roum', 'true');
                } else if ($status == 'rejected') {
                    $res = $data->where('approval_uker', 'false')
                        ->orWhere('approval_roum', 'false');
                }
            }
        } else {
            $res    = $data;
        }

        $role = Auth::user()->role_id;

        if ($role == 4 && Auth::user()->uker->unit_utama_id == '46593') {
            $book = $data->where('uker_id', Auth::user()->uker_id)->get();
        } else if ($role == 4) {
            $book = $data->where('unit_utama_id', Auth::user()->uker->unit_utama_id)->get();
        } else {
            $book = $data->get();
        }

        $book = $res->get();

        if ($request->downloadFile == 'pdf') {
            return view('dashboard.pages.booking.pdf', compact('book', 'dataUker', 'dataUtama', 'dataTujuan', 'dataRute', 'uker', 'utama', 'rute', 'tujuan'));
        } else if ($request->downloadFile == 'excel') {
            return Excel::download(new PesertaExport($request->all()), 'peserta.xlsx');
        } else if ($request->downloadFile == 'ticket') {
            return Excel::download(new BookingExport($request->all()), 'tiket.xlsx');
        }

        return view('dashboard.pages.booking.show', compact('book', 'dataUker', 'dataUtama', 'dataTujuan', 'dataRute', 'uker', 'utama', 'rute', 'tujuan', 'status'));
    }

    public function validation($id)
    {
        $book = Booking::where('id_booking', $id)->first();

        if (Auth::user()->role_id == 4) {
            if ($book->uker->unit_utama_id == '46593' && $book->uker_id != Auth::user()->uker_id) {
                abort(404);
            } else if ($book->uker->unit_utama_id != Auth::user()->uker->unit_utama_id) {
                abort(404);
            }
        }

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
                'upt'     => $book->nama_upt,
                'peserta' => $book->detail->count(),
                'tujuan'  => $book->tujuan->nama_kota,
                'trayek'  => $book->rute->jurusan,
                'rute'    => $book->rute->rute
            ];

            Mail::to($book->email)->send(new SendEmail($data));
        }

        session()->forget('success');
        return redirect()->route('book.validation', $id)->with('success', 'Berhasil Melakukan Validasi');
    }

    public function edit($id)
    {
        $book   = Booking::where('id_booking', $id)->first();
        $utama  = UnitUtama::get();
        $uker   = UnitKerja::get();
        $rute   = Trayek::get();
        $bus    = Bus::get();
        $tujuan = TrayekDetail::where('trayek_id', $book->trayek_id)->get();

        if (Auth::user()->role_id == 4) {
            if ($book->uker->unit_utama_id == '46593' && $book->uker_id != Auth::user()->uker_id) {
                abort(404);
            } else if ($book->uker->unit_utama_id != Auth::user()->uker->unit_utama_id) {
                abort(404);
            }
        }

        return view('dashboard.pages.booking.edit', compact('book', 'utama', 'uker', 'rute', 'tujuan', 'bus'));
    }

    public function update(Request $request, $id)
    {
        Booking::where('id_booking', $id)->update([
            'trayek_id'     => $request->trayek_id,
            'tujuan_id'     => $request->tujuan_id,
            'uker_id'       => $request->uker_id,
            'nama_upt'      => $request->nama_upt,
            'nama_pegawai'  => $request->nama_pegawai,
            'nip_nik'       => $request->nip_nik,
            'no_telp'       => $request->no_telp,
            'alamat'        => $request->alamat,
            'email'         => $request->email,
            'catatan'       => $request->catatan,
        ]);

        $peserta = $request->id_peserta;
        foreach ($peserta as $i => $id_peserta) {
            Peserta::where('id_peserta', $id_peserta)->update([
                'nama_peserta'  => $request->nama_peserta[$i],
                'usia'          => $request->usia[$i],
                'nik'           => $request->nik[$i],
                'bus_id'        => $request->bus_id[$i],
                'kode_seat'     => $request->kode_seat[$i],
                'status'        => $request->status[$i],
            ]);
        }

        return redirect()->route('book.edit', $id)->with('success', 'Berhasil Menyimpan Perubahan');
    }

    public function updateFile(Request $request, $id)
    {
        // dd($request->all());
        $peserta = Peserta::where('id_peserta', $id)->first();
        $book    = Booking::where('id_booking', $id)->first();

        // try {
        //     $request->validate([
        //         'foto_kk'  => 'required|mimes:jpg,jpeg,png|max:2048',
        //         'foto_ktp' => 'required|mimes:jpg,jpeg,png|max:2048',
        //     ]);
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     return back()->with('failed', 'Format File Tidak Didukung!');
        // }


        // $file = $request->file('foto_kk');

        // $mimeType = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file->getPathname());
        // $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

        // if (!in_array($mimeType, $allowedTypes)) {
        //     return back()->with('error', 'File tidak valid!');
        // }

        if ($peserta) {
            for ($i = 1; $i < 4; $i++) {
                $fotoName = "foto_vaksin_$i";

                if ($request->$fotoName) {
                    $file      = $request->file('foto_vaksin_' . $i);
                    $filename  = 'vaksin' . $i . '_' . now()->timestamp . '_' . $file->getClientOriginalName();
                    $foto      = $file->storeAs('public/files/vaksin_' . $i, $filename);
                    $vaksin    = $filename;

                    if ($peserta->foto_vaksin_ + $i) {
                        Storage::delete('public/files/vaksin_' . $i . '/' . $peserta->foto_vaksin_ + $i);
                    }

                    $fotoVaksin = 'foto_vaksin_' . $i;
                    Peserta::where('id_peserta', $id)->update([$fotoVaksin => $vaksin]);
                }
            }
        } else if ($request->foto_ktp) {
            $file      = $request->file('foto_ktp');
            $filename  = 'ktp_' . now()->timestamp . '_' . $file->getClientOriginalName();
            $foto      = $file->storeAs('public/files/foto_ktp/' . $filename);
            $ktp       = $filename;

            if ($book->foto_ktp) {
                Storage::delete('public/files/foto_ktp/' . $book->foto_ktp);
            }

            Booking::where('id_booking', $id)->update(['foto_ktp' => $ktp]);
        } else if ($request->foto_kk) {
            $file      = $request->file('foto_kk');
            $filename  = 'kk_' . time();
            $foto      = $file->storeAs('public/files/foto_kk/' . $filename);
            $kk        = $filename;

            if ($book->foto_kk) {
                Storage::delete('public/files/foto_kk/' . $book->foto_kk);
            }

            Booking::where('id_booking', $id)->update(['foto_kk' => $kk]);
        }

        $id_book = $peserta ? $peserta->booking_id : $id;
        return redirect()->route('book.edit', $id_book)->with('success', 'Berhasil Menyimpan Perubahan');
    }

    public function deleteFile($file, $id)
    {

        $peserta = Peserta::where('id_peserta', $id)->first();
        $book    = Booking::where('id_booking', $id)->first();
        if ($peserta) {
            for ($i = 1; $i < 4; $i++) {
                if ($file == 'vaksin' . $i) {
                    Storage::delete('public/files/vaksin_' . $i . '/' . $peserta->foto_vaksin_ + $i);
                }
            }

            Peserta::where('id_peserta', $id)->update([
                'foto_vaksin_1' => $file == 'vaksin1' ? null : $peserta->foto_vaksin_1,
                'foto_vaksin_2' => $file == 'vaksin2' ? null : $peserta->foto_vaksin_2,
                'foto_vaksin_3' => $file == 'vaksin3' ? null : $peserta->foto_vaksin_3,
            ]);
        } else if ($file == 'fotoktp') {
            Storage::delete('public/files/foto_ktp/' . $book->foto_ktp);
            Booking::where('id_booking', $id)->update(['foto_ktp' => null]);
        } else if ($file == 'fotokk') {
            Storage::delete('public/files/foto_kk/' . $book->foto_kk);
            Booking::where('id_booking', $id)->update(['foto_kk' => null]);
        }

        $id_book = $peserta ? $peserta->booking_id : $id;
        return redirect()->route('book.edit', $id_book)->with('success', 'Berhasil Menghapus File');
    }

    public function emailTicket($id)
    {
        $book = Booking::where('id_booking', $id)->first();

        $data = [
            'id'      => $book->id_booking,
            'nama'    => $book->nama_pegawai,
            'nip'     => $book->nip_nik,
            'uker'    => $book->uker->nama_unit_kerja,
            'upt'     => $book->nama_upt,
            'peserta' => $book->detail->count(),
            'tujuan'  => $book->tujuan->nama_kota,
            'trayek'  => $book->rute->jurusan,
            'rute'    => $book->rute->rute
        ];

        Mail::to($book->email)->send(new SendEmail($data));

        session()->forget('success');
        return redirect()->route('book.validation', $book->id_booking)->with('success', 'Email Terkirim');
    }
}
