<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // The fields that are mass assignable
    protected $fillable = [
        'date',
        'check_in',
        'check_out',
        'payment_status',
        'payment_method',
        'vehicle_id',
        'slot_id',
        'customer_id',
        'user_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
    public function slot()
    {
        return $this->belongsTo(Slot::class, 'slot_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
