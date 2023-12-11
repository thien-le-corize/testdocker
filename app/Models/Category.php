<?php

namespace App\Models;

use App\Models\Product;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, NodeTrait, SoftDeletes;
    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'description',
        'image',
        'status',
        'created_by',
        'updated_by',
    ];

    public function children() {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function getLatestRecord()
    {
        return $this->newQuery()->latest('updated_at')->first();
    }
}
