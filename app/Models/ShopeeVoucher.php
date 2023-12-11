<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopeeVoucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'discount',
        'start_at',
        'end_at',
        'description',
        'type_reduction',
        'max_value_reduction',
        'usage_quantity',
        'min_price',
        'rule'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
