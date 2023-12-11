<?php

namespace App\Http\Actions\Category;

use App\Helpers\Common;
use App\Models\Attribute;
use Illuminate\Support\Facades\DB;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\AttributeRepository;

class CreateAttributeAction extends BaseAction
{
    /**
     * @var AttributeRepository $attributeRepository
     */
    protected $attributeRepository;

    /**
     * @param AttributeRepository $attributeRepository
     */
    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @return \Illuminate\Support\Collection|mixed
     * @throws \Exception
     */
    public function handle()
    {
        $data = $this->request->all();

        if(!empty($data['attribute_type_ids'])){
            $data['attribute_type_id'] =  DB::raw("'{" . implode(",", $data['attribute_type_ids']) . "}'");
            unset($data['attribute_type_ids']);
        }

        $attributeId = $this->attributeRepository->insertGetId($data, false);
        $attribute = $this->attributeRepository->find($attributeId);
        return $this->setMessage('create_success', 'attribute', null, $attribute);
    }
}
