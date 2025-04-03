<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function guestEvents() //eveimnetele la care esti invitat
    {
        return $this->belongsToMany(Event::class, 'event_users')->withPivot('status');
    }

    public function events() //evenimentele tale (in care esti mire)
    {
        return $this->hasMany(Event::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, 'danieljoldes@gmail.com') && $this->hasVerifiedEmail();
    }
}
