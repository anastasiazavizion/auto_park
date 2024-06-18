<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['total', 'car_id', 'user_id', 'driver_id', 'status'];

    public function payment() : HasOne
    {
        return $this->hasOne(Payment::class);

    }

}
