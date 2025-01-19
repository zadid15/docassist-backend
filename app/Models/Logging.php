<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logging extends Model
{
    //
    protected $fillable = [
        'user_id',
        'message',
        'action',
        'ip_address',
    ];

    public static function record($user_id, $message, $action, $ip_address)
    {
        Logging::create([
            'user_id' => $user_id,
            'message' => $message,
            'action' => $action,
            'ip_address' => $ip_address,
        ]);
    }
}
