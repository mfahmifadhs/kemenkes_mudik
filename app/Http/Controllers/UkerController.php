<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\UnitKerja;
use App\Models\UnitUtama;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UkerController extends Controller
{
    public function index()
    {
        $uker = UnitKerja::get();
        return view('dashboard.pages.uker.show', compact('uker'));
    }

    public function detail($id)
    {
        $uker    = UnitKerja::where('id', $id)->first();

        return view('dashboard.pages.uker.detail', compact('id', 'uker'));
    }

    public function edit($id)
    {
        $utama = UnitUtama::get();
        $uker  = UnitKerja::where('id_unit_kerja', $id)->first();

        return view('dashboard.pages.uker.edit', compact('id', 'uker', 'utama'));
    }

    public function update(Request $request, $id)
    {
        UnitKerja::where('id_unit_kerja', $id)->update([
            'unit_utama_id'     => $request->utama_id,
            'nama_unit_kerja'   => $request->nama_unit_kerja,
            'pic_nama'          => $request->pic_nama,
            'pic_nohp'          => $request->pic_nohp
        ]);

        return redirect()->route('uker.edit', $id)->with('success', 'Berhasil Menyimpan Perubahan');
    }
}
