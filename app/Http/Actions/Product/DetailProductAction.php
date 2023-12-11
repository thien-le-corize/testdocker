<?php

namespace App\Http\Actions\Product;

use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Support\Facades\DB;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\ProductRepository;
use App\Exceptions\AuthenticateException;
use App\Repositories\AttributeRepository;
use App\Repositories\AttributeValueRepository;

class DetailProductAction extends BaseAction
{
    protected $productRepository;
    protected $attributeRepository;
    protected $attributValueRepository;


    public function __construct
    (
        ProductRepository $productRepository,
        AttributeRepository $attributeRepository,
        AttributeValueRepository $attributValueRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->attributeRepository = $attributeRepository;
        $this->attributValueRepository = $attributValueRepository;
    }

    public function handle()
    {
        $id = $this->params['id'];
        $product = $this->productRepository->withTrashed()->where([
            'id' => $id,
            'status' => Product::ACTIVE
        ])->first();

        if(is_null($product)){
            throw AuthenticateException::recordNotFound();
        }

        $attributes = [];

        foreach ($product->attributes as $attribute) {
            $name = Attribute::find($attribute['attribute_id'])->name;

            if (isset($attribute['attribute_values']['value_id'])) {
                $value = $this->attributValueRepository->find($attribute['attribute_values']['value_id'])->name;
            } else {
                $value = $attribute['attribute_values']['raw_value'] . $attribute['attribute_values']['unit'];
            }

            $attributes[] = [
                'name' => $name,
                'value' => $value
            ];
        }

        $data =  [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'weight' => $product->weight,
            'price' => $product->price,
            'quantity' => $product->quantity,
            'rating' => $product->reviews->avg('rating') ?? 0,
            'category' => $product->getRelationValue('category'),
            'images' => $product->images,
            'videos' => $product->videos,
            'shop' =>  $product->getRelationValue('shop'),   
            'attributes' => $attributes,
            'deleted_at' => $product->deleted_at,
            'created_at' => $product->created_at,
        ];

        return $data;
    }
}
