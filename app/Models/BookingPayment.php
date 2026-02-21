<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingPayment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_booking_payment";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'booking_id',
        'payment_date',
        'payment_file',
        'payment_method',
        'payment_notes'
    ];

    public function booking() {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
