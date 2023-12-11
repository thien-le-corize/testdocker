<?php

namespace App\Http\Tasks\Category;

use App\Models\AttributeType;

class ListAttributeTypeTask
{
    public function handle($request)
    {
        $attributeTypes = AttributeType::get();
        return $attributeTypes;
    }
    
}
