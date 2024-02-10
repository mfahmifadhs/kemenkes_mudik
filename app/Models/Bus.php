<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_bus";
    protected $primaryKey = "id_bus";
    public $timestamps = false;

    protected $fillable = [
        'trayek_id',
        'no_plat',
        'deskripsi',
        'total_kursi',
        'seat_kanan',
        'seat_kiri',
        'seat_belakang',
        'kd_seat_kiri',
        'kd_seat_kanan'
    ];

    public function trayek() {
        return $this->belongsTo(Trayek::class, 'trayek_id');
    }

    public function detail() {
        return $this->hasMany(Peserta::class, 'bus_id');
    }
}
