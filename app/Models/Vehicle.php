<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    // The fields that are mass assignable
    protected $fillable = [
        'license_plate',
        'type',
        'model',
        'color'
    ];
    
    public function vehiclesTickets(){
        return $this->hasMany(Ticket::class, 'vehicle_id');
    }
}
