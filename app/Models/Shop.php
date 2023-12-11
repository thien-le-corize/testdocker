<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
    ];

    

    // public function scopeNoEagerLoads($query) {
    //     return $query->setEagerLoads([]);
    // }


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function vouchers() {
        return $this->hasMany(Voucher::class);
    }
}
