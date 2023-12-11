<?php

namespace App\Models;

use App\Casts\Json;
use App\Models\Category;
use App\Models\AttributeValue;
use App\Models\AttributeType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'status',
        'category_id',
        'attribute_type_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'attribute_type_id' => Json::class,
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function attributeTypes() {
        return $this->hasMany(AttributeType::class, 'attribute_type_id', 'id');
    }

    public function attributeValues() {
        return $this->hasMany(AttributeValue::class);
    }

    public function getLatestRecord()
    {
        return $this->newQuery()->latest('updated_at')->first();
    }
}
