<?php

namespace App\Http\Tasks\Category;

use App\Models\Attribute;
use App\Models\AttributeType;

class ListAttributeTask
{
    public function handle($request)
    {
        $categoryId = $request['category_id'];
        $attributes = Attribute::where('category_id', $categoryId)->get();
        return $this->buildTree($attributes);
    }
    
    function buildTree($attributes) 
    {
        return $attributes->map(function ($attribute) {
            $attributeTypeIds = $attribute->attribute_type_id;
            if(!empty($attributeTypeIds)){
                foreach ($attributeTypeIds as $attributeTypeId) {
                    $attributeType = AttributeType::where('id', $attributeTypeId)->first();
                    if ($attributeType) {
                        $attributeTypes[] = $attributeType->name;
                    }
                }
            }

            $data = [
                'id' => $attribute->id,
                'name' => $attribute->name,
                'children' => $attribute?->getRelationValue('attributeValues')->toArray(),
                'attribute_type' => !empty($attributeTypes) ? $attributeTypes : null,
            ];

            return $data;
        });
    }
}
