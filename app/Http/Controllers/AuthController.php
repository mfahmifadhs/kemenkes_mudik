<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Hash;
use Auth;
use Session;
use DB;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{

    public function index()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'username'  => 'required',
            'password'  => 'required',
        ]);

        // $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        //     'secret' => env('RECAPTCHA_SECRET_KEY'),
        //     'response' => $request->input('g-recaptcha-response'),
        //     'remoteip' => $request->ip(),
        // ]);

        // $result = $response->json();

        // if (!$result['success']) {
        //     return back()->with('failed', 'Gagal Verifikasi Captcha');
        // }

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            if (auth()->user()->status == 'aktif') {
                return redirect()->intended('dashboard')->with('success', 'Berhasil Masuk!');
            } else {
                Auth::logout();
                return redirect()->route('login')->with('failed', 'Akun tidak aktif.');
            }
        }

        return redirect()->route('login')->with('failed', 'Username atau Password Salah');
    }

    public function dashboard()
    {
        return redirect()->route('pages.dashboard')->with('success', 'Selamat Datang');
    }


    public function keluar()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/')->with('success', 'Berhasil Keluar');
    }
}
