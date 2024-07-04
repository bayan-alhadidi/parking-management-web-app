<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'type',
        'rate',
        'status',
        'parkinglot_id'
    ];

    public function parkinglot()
    {
        return $this->belongsTo(Parkinglot::class, 'parkinglot_id');
    }

    public function slotsTickets(){
        return $this->hasMany(Ticket::class, 'slot_id');
    }
}
