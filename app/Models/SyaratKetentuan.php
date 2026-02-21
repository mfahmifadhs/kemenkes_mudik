<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SyaratKetentuan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_syarat_ketentuan";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'syarat_ketentuan',
        'status'
    ];
}
