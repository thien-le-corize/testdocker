<?php

namespace App\Http\Actions\Category;

use App\Helpers\Common;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\AttributeValueRepository;

class CreateAttributeValueAction extends BaseAction
{
    /**
     * @var AttributeValueRepository $attributeValueRepository
     */
    protected $attributeValueRepository;

    /**
     * @param AttributeValueRepository $attributeValueRepository
     */
    public function __construct(AttributeValueRepository $attributeValueRepository)
    {
        $this->attributeValueRepository = $attributeValueRepository;
    }

    /**
     * @return \Illuminate\Support\Collection|mixed
     * @throws \Exception
     */
    public function handle()
    {
        $data = $this->request->all();
        $id = $this->attributeValueRepository->insertGetId($data, false);
        $attribute_value = $this->attributeValueRepository->find($id);
        $lastRecord = Common::getNameDateLatestRecord($attribute_value);
        return $this->setMessage('create_success', 'attribute_value', $lastRecord, $attribute_value);
    }
}
