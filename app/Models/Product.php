<?php

namespace App\Models;

use App\Casts\Json;
use App\Models\User;
use App\Models\Review;
use App\Models\Category;
use App\Models\Concerns\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes, Filterable;
    const REVIEWING = 1; 
    const BANNED = 2;
    const ACTIVE = 3;
    const INACTIVE = 4;
    const SOLDOUT = 5;


    protected $fillable = [
        'id',
        'name',
        'description',
        'images',
        'list_videos',
        'weight',
        'attributes',
        'demension',
        'status',
        'created_by',
        'updated_by',
        'category_id',
        'user_id',
        'quantity'
    ];

    protected $filterable = [
        'name',
        'weight',
        'category_id',
        'user_id'
    ];

    protected $casts = [
        'attributes' => 'array',
        'dimension' => 'array',
        'images' => 'array',
    ];

    protected function getFilters()
    {
        return [
            new \App\Models\Pipes\RelativeFilter('name'),
            new \App\Models\Pipes\ExactFilter('weight'),
            new \App\Models\Pipes\ExactFilter('category_id'),
            // new \App\Models\Pipes\ExactFilter('created_at'),
            // new \App\Models\Pipes\ExactFilter('updated_at'),
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


    public function getLatestRecord()
    {
        return $this->newQuery()->latest('updated_at')->first();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class)->withTrashed();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
