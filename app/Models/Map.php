<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Map extends Model
{
    protected $fillable = [
        'user_id', 
        'map_uuid', 
        'map_name', 
        'map_image', 
        'tactic_note' 
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}