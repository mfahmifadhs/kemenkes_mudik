<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Tamu;
use App\Models\Trayek;
use App\Models\UnitKerja;
use Hash;
use Auth;
use Carbon\Carbon;
use Session;
use DB;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        if (!Auth::user()) {
            return redirect('/');
        }

        $uker   = [];
        $trayek = [];
        $role = Auth::user()->role_id;
        $user = $role == 4 ? 'user' : 'admin';
        $rute = Trayek::get();
        $bus  = Bus::get();
        $data = Booking::orderBy('id_booking', 'DESC');

        if ($role == 4) {
            $book = $data->where('uker_id', Auth::user()->uker_id)->where('approval_uker', null)->get();
        } else {
            $uker   = UnitKerja::get();
            $trayek = Trayek::get();
            $book   = $data->get();
        }

        return view('dashboard.' . $user, compact('user', 'rute', 'bus', 'book', 'trayek', 'uker'));

    }

    public function time()
    {
        $response = Carbon::now()->isoFormat('DD MMMM Y HH:mm:ss');
        return response()->json($response);
    }
}
