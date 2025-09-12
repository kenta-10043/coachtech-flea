<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Status as StatusEnum;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'brand_name',
        'price',
        'item_image',
        'status',
        'description',
        'user_id',
        'condition_id'
    ];

    public function getLabelAttribute(): string
    {
        return StatusEnum::from($this->status)->label();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
