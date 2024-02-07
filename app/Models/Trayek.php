<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trayek extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_trayek";
    protected $primaryKey = "id_trayek";
    public $timestamps = false;

    protected $fillable = [
        'jurusan',
        'rute'
    ];

    public function bus() {
        return $this->hasMany(Bus::class, 'trayek_id');
    }

    public function trayekDetail() {
        return $this->hasMany(TrayekDetail::class, 'trayek_id');
    }
}
