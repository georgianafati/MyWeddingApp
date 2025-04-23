<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventBucketList extends Model
{
    protected $guarded = [];
    
    protected $casts = [
        'description' => 'string',
        'price'       => 'float',
        'image' => 'array', 
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
