<?php

namespace App\Models;

use App\Casts\Json;
use App\Models\Concerns\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, Filterable;

    const PENDING = 1; // đang đợi xác nhận
    const TOSHIP = 2;  // đang đợi lấy hàng
    const SHIPPING = 3; // đang vận chuyển
    const COMPLETED = 4; // vận chuyển thành công// giao hangf thanh cong
    const CANCELLED = 5; // đã hủy
    const REFUND = 6; // hoàn đơn/đổi trả
    const FAILED_DELIVERY = 7; // ko giao hàng thành công

    const CASH_ON_DELIVERY = 1; // thanh toán khi nhận hàng
    const VNPAY = 2;
    const MOMO = 3;

    protected $hidden = [
        // 'payment_info',  
    ];

    protected $with = [
        'address',  
    ];

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'address_id',
        'status',
        'payment_info',
        'payment_status',
    ];

    protected $casts = [
        'status' => Json::class,
    ];


    protected function getFilters()
    {
        return [
            new \App\Models\Pipes\ExactFilter('status'),
        ];
    }
    
    public function scopeFilter(Builder $query)
    {
        $criteria = $this->filterCriteria();
        return app(\Illuminate\Pipeline\Pipeline::class)
            ->send($query)
            ->through($criteria)
            ->thenReturn();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class)->withTrashed();
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function voucher()
    {
        return $this->belongsTo(voucher::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['order_id', 'product_id']);
    }
}