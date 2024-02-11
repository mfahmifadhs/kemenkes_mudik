<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Role;
use App\Models\Pegawai;
use App\Models\UnitKerja;
use Hash;
use Auth;
use Carbon\Carbon;
use Session;
use DB;

class UserController extends Controller
{

    public function index()
    {
        $user = User::get();
        return view('dashboard.pages.user.show', compact('user'));
    }

    public function time()
    {
        $response = Carbon::now()->isoFormat('HH:mm:ss / DD-MM-Y');
        return response()->json($response);
    }

    public function create()
    {
        $role = Role::get();
        $uker = UnitKerja::get();
        return view('dashboard.pages.user.create', compact('role', 'uker'));
    }

    public function detail($id)
    {
        $user    = User::where('id', $id)->first();
        $role    = Role::get();

        return view('dashboard.pages.user.detail', compact('id', 'user', 'role'));
    }

    public function store(Request $request)
    {
        $user   = User::count();
        $idUser = $user + 1;

        $tambah = new User();
        $tambah->id             = $idUser;
        $tambah->uker_id        = $request->uker;
        $tambah->role_id        = $request->role_id;
        $tambah->name           = $request->name;
        $tambah->username       = $request->username;
        $tambah->password       = Hash::make($request->password);
        $tambah->password_teks  = $request->password;
        $tambah->status         = 'aktif';
        $tambah->save();

        return redirect()->route('user')->with('success', 'Berhasil Menambah Baru');
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        $role = Role::get();
        $uker = UnitKerja::get();

        return view('dashboard.pages.user.edit', compact('id', 'user', 'role', 'uker'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        User::where('id', $id)->update([
            'role_id'       => $request->role_id ? $request->role_id : $user->role_id,
            'uker_id'       => $request->uker ? $request->uker : $user->uker_id,
            'name'          => $request->name,
            'username'      => $request->username,
            'password'      => Hash::make($request->password),
            'password_teks' => $request->password,
            'status'        => $request->status ? $request->status : $user->status
        ]);

        return redirect()->route('user.edit', $id)->with('success', 'Berhasil Menyimpan Perubahan');
    }
}
