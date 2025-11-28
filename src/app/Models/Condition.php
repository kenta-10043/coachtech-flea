<?php

namespace App\Models;

use App\Enums\Condition as ConditionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;

    protected $fillable = [
        'condition',
    ];

    public function getLabelAttribute(): string
    {
        return ConditionEnum::from($this->condition)->label();
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
