<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';

    protected $fillable = [
        'name',
        'code',
        'type',
        'discount',
        'date_start',
        'date_end',
        'single_use',
        'status',
    ];

    public function couponHystory(): HasMany
    {
        return $this->hasMany(CouponHistory::class);
    }
}
