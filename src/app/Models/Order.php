<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PaymentMethod as PaymentMethodEnum;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'order_price',
        'payment_method',
        'shopping_postal_code',
        'shopping_address',
        'shopping_building',
        'paid_at',
        'status',
        'checkout_session_id',
    ];

    public function getLabelAttribute(): string
    {
        return PaymentMethodEnum::from($this->payment_method)->label();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
