<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['merchant_id', 'title', 'duration_min', 'price_cents', 'description', 'active'];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
