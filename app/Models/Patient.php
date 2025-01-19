<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    //
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'dob',
        'gender',
        'user_id',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
