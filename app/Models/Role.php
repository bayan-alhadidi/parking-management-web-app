<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // The fields that are mass assignable
    protected $fillable = [
        'name',
        'shift'
    ];

    public function rolesUsers(){
        return $this->hasMany(User::class, 'role_id');
    }
}
