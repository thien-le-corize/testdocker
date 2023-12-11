<?php

namespace App\Http\Resources\Product;

use App\Models\Attribute;
use App\Http\Shared\Resources\BaseResource;
use App\Models\AttributeValue;

class ProductResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function toArray($request)
    {
        $data =  $this->resource->only([
            'id',
            'name',
            'description',
            'weight',
            'price',
            'quantity',
            'created_at',
            'deleted_at',
            'images'
        ]);
        $data['category'] = $this->getRelationValue('category');
        $data['shop'] = $this->getRelationValue('shop');

        foreach (collect($this->attributes)->toArray() as $attribute) {
            if (isset($attribute['attribute_id']) && is_int($attribute['attribute_id'])) {
                $name = Attribute::find($attribute['attribute_id'])->getAttributeValue('name');
            } else {
                $name = '';
            }
        
            $value = '';
        
            if (isset($attribute['attribute_values']) && is_array($attribute['attribute_values'])) {
                if (isset($attribute['attribute_values']['value_id'])) {
                    $value = AttributeValue::find($attribute['attribute_values']['value_id'])->name;
                } else {
                    $rawValue = isset($attribute['attribute_values']['raw_value']) ? $attribute['attribute_values']['raw_value'] : '';
                    $unit = isset($attribute['attribute_values']['unit']) ? $attribute['attribute_values']['unit'] : '';
                    $value = $rawValue . $unit;
                }
            }
        
            $attributes[] = [
                'name' => $name,
                'value' => $value
            ];
        }

        $data['attributes'] = $attributes;
        $data['rating'] = $this->reviews->avg('rating') ?? 0;
        return $data;
    }
}
