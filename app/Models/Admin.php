<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Notifications\AdminPasswordResetNotification;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminPasswordResetNotification($token));
    }

    
    /**
     * Get the admin's initials
     * 
     * this means getting the first letter of the first name and the first letter of the last name
     * 
     * @return string
     */
    
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
