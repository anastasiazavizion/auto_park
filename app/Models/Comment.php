<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Query\Builder;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'user_id', 'parent_comment_id'];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) =>  date('Y-m-d H:i', strtotime($value))
        );
    }

    public function parent() : BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    public function children() : HasMany
    {
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }

    public function scopeWithNestedComments($query)
    {
        return $query->with(['user', 'children' => function ($query) {
            $query->withNestedComments(); // Call the same method recursively
        }]);
    }

}
