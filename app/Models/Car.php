<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Car extends Model
{
    use HasFactory;

    protected $appends = ['image'];

    protected $fillable = ['model','price', 'park_id'];

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

    public function images() : HasMany
    {
        return $this->hasMany(CarImage::class)->orderBy('order');

    }

   public function getImageAttribute()
    {
        return $this->images()->count() > 0 ? $this->images->get(0)->url : null;
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

}
