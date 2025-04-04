<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class EventTransaction extends Model
{
    protected $guarded = [];
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
