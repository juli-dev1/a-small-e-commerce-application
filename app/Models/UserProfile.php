<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'address',
        'address2',
        'city',
        'postcode',
        'country',
        'mobile',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
