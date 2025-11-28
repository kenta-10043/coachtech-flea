<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'reviewer_id',
        'reviewee_id',
        'rating',
    ];

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');  // 自分がする評価
    }

    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id');  // 自分がされる評価
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
