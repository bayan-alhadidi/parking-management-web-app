<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;
use Illuminate\Notifications\Notifiable;

class User extends AuthenticatableUser implements Authenticatable
{
    use HasFactory, Notifiable;

    // The fields that are mass assignable
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'parkinglot_id'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function parkinglot()
    {
        return $this->belongsTo(Parkinglot::class, 'parkinglot_id');
    }

    public function usersTickets(){
        return $this->hasMany(Ticket::class, 'user_id');
    }
}