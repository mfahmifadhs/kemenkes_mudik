<?php

namespace App\Http\Controllers;

use App\Exports\BookingExport;
use App\Exports\PesertaExport;
use App\Mail\SendEmail;
use App\Mail\SendPdfMail;
use App\Models\Booking;
use App\Models\BookingPayment;
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
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

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
        $bus  = Bus::where('status', 'true')->where('trayek_id', $book->trayek_id)->where('status', 'true')->get();

        if (Auth::user()->role_id == 4) {
            if ($book->uker->unit_utama_id == '46593' && $book->uker_id != Auth::user()->uker_id) {
                abort(404);
            } else if ($book->uker->unit_utama_id != Auth::user()->uker->unit_utama_id) {
                abort(404);
            }
        }

        return view('dashboard.pages.booking.validation', compact('bus', 'book'));
    }

    public function storeValidation(Request $request, $id)
    {
        $catatan = $request->input('catatan', null);
        $status  = $request->tolak == true ? 'false' : 'true';

        $book = Booking::where('id_booking', $id)->first();
        Booking::where('id_booking', $id)->update([
            'approval_uker'  => $book->approval_uker ? $book->approval_uker : $status,
            'approval_roum'  => $book->approval_uker ? $status : null,
            'payment_status' => $status == 'true' ? 'true' : 'false',
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

        if ($request->foto_ktp) {
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
        return redirect()->route('book.edit', $id)->with('success', 'Berhasil Menyimpan Perubahan');
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

    public function store(Request $request)
    {
        $peserta = Peserta::where('bus_id', $request->bus)
            ->where('kode_seat', $request->seat)
            ->whereNot('status', 'cancel')
            ->first();

        if ($peserta) {
            return redirect()->route('book.validation', $request->id)->with('failed', 'Kursi tidak tersedia');
        }

        $idPeserta = Peserta::withTrashed()->count();
        $detail = new Peserta();
        $detail->id_peserta   = $idPeserta + 1;
        $detail->booking_id   = $request->id;
        $detail->bus_id       = $request->bus;
        $detail->kode_seat    = $request->seat;
        $detail->nama_peserta = $request->nama;
        $detail->nik          = $request->nik;
        $detail->usia         = $request->usia;
        $detail->created_at   = Carbon::now();
        $detail->save();

        return redirect()->route('book.validation', $request->id)->with('success', 'Berhasil menambahkan');
    }

    public function deletePeserta($id)
    {
        Peserta::where('id_peserta', $id)->delete();

        return back()->with('success', 'Berhasil menghapus');
    }

    public function updatePeserta(Request $request, $id)
    {
        $peserta = Peserta::where('bus_id', $request->bus)
            ->where('kode_seat', $request->seat)
            ->whereNot('status', 'cancel')
            ->whereNot('id_peserta', $id)
            ->first();

        if ($peserta) {
            return redirect()->route('book.validation', $request->id)->with('failed', 'Kursi tidak tersedia');
        }

        Peserta::where('id_peserta', $id)->update([
            'booking_id'   => $request->id,
            'bus_id'       => $request->bus,
            'kode_seat'    => $request->seat,
            'nama_peserta' => $request->nama,
            'nik'          => $request->nik,
            'usia'         => $request->usia
        ]);

        return redirect()->route('book.validation', $request->id)->with('success', 'Berhasil menyimpan');
    }

    public function paymentUpload(Request $request, $id)
    {
        $book = Booking::where('id_booking', $id)->first();

        $file      = $request->file('bukti_pembayaran');
        $filename  = 'payment_' . now()->timestamp . '_' . $file->getClientOriginalName();
        $path      = $file->storeAs('public/files/payment/' . $filename);
        $payment   = $filename;

        if ($book->bukti_bayar) {
            Storage::delete('public/files/payment/' . $book->bukti_bayar);
        }

        $detail = new BookingPayment();
        $detail->booking_id   = $book->id_booking;
        $detail->payment_file = $payment;
        $detail->created_at = Carbon::now();
        $detail->save();

        return redirect()->route('form.confirm', $id)->with('success', 'Berhasil mengupload bukti pembayaran');
    }

    public function paymentStore(Request $request, $id)
    {
        // 1. Validasi tipe file dan input lainnya
        $request->validate([
            'payment_method' => 'required',
            'payment_date'   => 'required|date',
            'payment_file'   => 'nullable|mimes:jpg,jpeg,png,pdf|max:10240', // Limit awal 10MB sebelum kompres
            'payment_notes'  => 'nullable|string',
        ]);

        $book = Booking::findOrFail($id); // Sesuaikan dengan Model Anda

        $data = [
            'payment_method' => $request->payment_method,
            'payment_date'   => $request->payment_date,
            'payment_notes'  => $request->payment_notes,
        ];

        if ($request->hasFile('payment_file')) {
            $file = $request->file('payment_file');
            $extension = $file->getClientOriginalExtension();
            $fileName = 'PAY-' . time() . '.' . $extension;
            $path = 'payments/' . $fileName;

            // 2. Logic Kompresi (Hanya untuk Foto JPG/PNG, PDF tidak bisa dikompres via library ini)
            if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png']) && $file->getSize() > 2048000) {
                // Proses Kompresi
                $img = Image::make($file->getRealPath());

                // Resize jika terlalu lebar (opsional, untuk menghemat space)
                $img->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                // Simpan dengan kualitas 60% untuk mengurangi size secara drastis
                $content = $img->stream($extension, 60);
                Storage::disk('public')->put($path, $content);
            } else {
                // Jika file PDF atau ukuran < 2MB, simpan biasa
                $file->storeAs('payments', $fileName, 'public');
            }

            $data['payment_file'] = $path;
        }

        // 3. Update data ke database
        // Sesuaikan dengan nama tabel/relasi Anda
        $book->payment()->updateOrCreate(['booking_id' => $id], $data);
        $book::where('id_booking', $id)->update([
            'payment_file'   => $path ?? null,
            'payment_status' => 'true'
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil diproses!');
    }

    public function paymentUpdate(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required',
            'payment_date'   => 'required|date',
            'payment_file'   => 'nullable|mimes:jpg,jpeg,png,pdf|max:10240',
            'payment_notes'  => 'nullable|string',
        ]);

        $payment = BookingPayment::findOrFail($id);
        $path = $payment->payment_file;

        if ($request->hasFile('payment_file')) {
            $file = $request->file('payment_file');
            $extension = $file->getClientOriginalExtension();
            $fileName = 'PAY-UPD-' . time() . '.' . $extension;
            $newPath = 'payments/' . $fileName;

            if ($payment->payment_file && Storage::disk('public')->exists($payment->payment_file)) {
                Storage::disk('public')->delete($payment->payment_file);
            }

            if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png']) && $file->getSize() > 2048000) {
                $img = Image::make($file->getRealPath());
                $img->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $content = $img->stream($extension, 60);
                Storage::disk('public')->put($newPath, $content);
            } else {
                $file->storeAs('payments', $fileName, 'public');
            }

            $path = $newPath;
        }

        $payment->update([
            'payment_method' => $request->payment_method,
            'payment_date'   => $request->payment_date,
            'payment_notes'  => $request->payment_notes,
            'payment_file'   => $path ?? null,
        ]);

        Booking::where('id_booking', $payment->booking_id)->update([
            'payment_file'   => $path ?? null,
        ]);

        $payment->booking->update(['payment_status' => 'true']);

        return redirect()->back()->with('success', 'Data pembayaran berhasil diperbarui!');
    }

    public function paymentDelete($id)
    {
        BookingPayment::where('booking_id', $id)->update([
            'payment_file' => null
        ]);

        Booking::where('id_booking', $id)->update([
            'payment_file' => null
        ]);

        return redirect()->route('book.validation', $id)->with('success', 'Data pembayaran berhasil diperbarui!');
    }
}
