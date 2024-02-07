<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrayekDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_trayek_detail";
    protected $primaryKey = "id_detail";
    public $timestamps = false;

    protected $fillable = [
        'trayek_id',
        'nama_kota'
    ];

    public function trayek() {
        return $this->belongsTo(Trayek::class, 'trayek_id');
    }
}
