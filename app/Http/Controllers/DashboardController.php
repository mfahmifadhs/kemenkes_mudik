<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Tamu;
use App\Models\Trayek;
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

        $role = Auth::user()->role_id;
        $user = $role == 4 ? 'user' : ($role == 3 ? 'roum' : 'admin');
        $rute = Trayek::get();
        $bus  = Bus::get();
        $data = Booking::orderBy('id_booking', 'DESC');

        if ($role == 4) {
            $book = $data->where('uker_id', Auth::user()->uker_id)->where('status', null)->get();
        } else {
            $book = $data->get();
        }

        return view('dashboard.' . $user, compact('user', 'rute', 'bus', 'book'));

    }

    public function time()
    {
        $response = Carbon::now()->isoFormat('DD MMMM Y HH:mm:ss');
        return response()->json($response);
    }
}
