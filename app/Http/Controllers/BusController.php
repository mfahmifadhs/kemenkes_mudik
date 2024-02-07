<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Peserta;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role_id;
        $data = Booking::orderBy('id_booking', 'DESC');

        if ($role == 4) {
            $book = $data->where('uker_id', Auth::user()->uker_id)->where('status', null)->get();
        } else {
            $book = $data->get();
        }

        return view('dashboard.pages.booking.show', compact('book'));
    }
}

