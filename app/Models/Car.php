<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Car extends Model
{
    use HasFactory;

    public function park() :BelongsTo
    {
        return $this->belongsTo(Park::class);
    }

    public function drivers() :BelongsToMany
    {
        return $this->belongsToMany(Driver::class)->withTimestamps();
    }

    public function scopeWithPark(Builder $query)
    {
        return $query->with('park');

    }
    public function scopeWithDrivers(Builder $query)
    {
        return $query->with('drivers');

    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);

    }
}
