<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Weapon extends Model
{
    protected $fillable = [
        'user_id', 
        'weapon_uuid', 
        'weapon_name', 
        'weapon_image', 
        'category'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}