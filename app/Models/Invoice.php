<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $fillable = [
        'patient_id',
        'amount',
        'status',
    ];
}
