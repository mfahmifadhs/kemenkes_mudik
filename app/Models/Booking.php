<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_booking";
    protected $primaryKey = "id_booking";
    public $timestamps = false;

    protected $fillable = [
        'trayek_id',
        'tujuan_id',
        'uker_id',
        'nama_pegawai',
        'nip_nik',
        'no_telp',
        'alamat',
        'foto_kk',
        'foto_ktp',
    ];

    public function bus() {
        return $this->belongsTo(Bus::class, 'bus_id');
    }

    public function uker() {
        return $this->belongsTo(UnitKerja::class, 'uker_id');
    }

    public function rute() {
        return $this->belongsTo(Trayek::class, 'trayek_id');
    }

    public function tujuan() {
        return $this->belongsTo(TrayekDetail::class, 'tujuan_id');
    }

    public function detail() {
        return $this->hasMany(Peserta::class, 'booking_id', 'id_booking');
    }
}
