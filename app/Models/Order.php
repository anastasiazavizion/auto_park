<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
class Order extends Model
{
    use HasFactory;
    protected $fillable = ['total', 'car_id', 'user_id', 'driver_id', 'status'];

    protected $appends = ['is_paid'];

    public function payment() : HasOne
    {
        return $this->hasOne(Payment::class);

    }

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => date('Y-m-d H:i', strtotime($value)),
        );
    }
    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => number_format($value,'2','.'),
        );
    }

    protected function isPaid(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status->name === 'Paid',
        );
    }

    public function status() : BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');

    }

    public function car() : BelongsTo
    {
        return $this->belongsTo(Car::class);

    }
    public function driver() : BelongsTo
    {
        return $this->belongsTo(Driver::class);

    }

    public function scopePaid(Builder $query)
    {
        $query->whereHas('status', function ($query){
            $query->where('name','Paid');
        });
    }
}
