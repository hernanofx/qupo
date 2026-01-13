<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = ['merchant_id', 'service_id', 'weekday', 'start_time', 'end_time', 'date', 'recurring'];

    protected $casts = [
        'recurring' => 'boolean',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
