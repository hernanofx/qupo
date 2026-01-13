<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Merchant extends Model
{
    protected $fillable = ['owner_id', 'name', 'slug', 'address', 'lat', 'lng', 'settings', 'active'];

    protected $casts = [
        'settings' => 'array',
        'active' => 'boolean',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
