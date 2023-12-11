<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
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

    protected $casts = [
        'start_at' => 'datetime:Y-m-d H:i:s ',
        'end_at' => 'datetime:Y-m-d H:i:s',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
