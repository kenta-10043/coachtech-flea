<?php

namespace App\Models;

use App\Enums\Category as CategoryEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
    ];

    public function getLabelAttribute(): string
    {
        return CategoryEnum::from($this->category)->label();
    }

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
