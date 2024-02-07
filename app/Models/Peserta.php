<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_peserta";
    protected $primaryKey = "id_peserta";
    public $timestamps = false;

    protected $fillable = [
        'booking_id',
        'bus_id',
        'kode_seat',
        'nama_peserta',
        'nik'
    ];

    public function booking() {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
