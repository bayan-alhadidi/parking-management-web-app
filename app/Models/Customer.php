<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    
    // The fields that are mass assignable
    protected $fillable = [
        'name',
        'phone'
    ];

    public function customersTickets(){
        return $this->hasMany(Ticket::class, 'customer_id');
    }
}
