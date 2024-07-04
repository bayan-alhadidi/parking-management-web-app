<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parkinglot extends Model
{
    use HasFactory;

    protected $fillable = [
        'parking_name',
        'address',
        'status'
    ];

    public function parkinglotsUsers(){
        return $this->hasMany(User::class, 'parkinglot_id');
    }

    public function parkinglotsSlots(){
        return $this->hasMany(Slots::class, 'parkinglot_id');
    }
}
