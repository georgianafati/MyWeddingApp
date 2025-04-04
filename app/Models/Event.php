<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class Event extends Model
{
    protected $guarded = [];

    public function transactions()
    {
        return $this->hasMany(EventTransaction::class);
    }

    public function bucketLists()
    {
        return $this->hasMany(EventBucketList::class);
    }

    public function user() //mirele
    {
        return $this->belongsTo(User::class);
    }

    public function users() // invitatii
    {
        return $this->belongsToMany(User::class, 'event_users')->withPivot('status');
    }

    public function eventParticipants()
    {
        return $this->hasMany(EventUser::class);
    }
    
    public function getTotalBucketListsPriceAttribute()
    {
        return $this->bucketLists->sum('price');
    }

    public function getTotalInvitationsAttribute()
    {
        return $this->eventParticipants->count();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
