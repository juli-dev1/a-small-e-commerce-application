<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponHistory extends Model
{
    use HasFactory;

    protected $table = 'coupon_history';

    protected $fillable = [
        'coupon_id',
        'order_id',
        'user_id',
        'amount',
        'status'
    ];
}
