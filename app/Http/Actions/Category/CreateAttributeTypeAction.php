<?php

namespace App\Http\Actions\Category;

use App\Helpers\Common;
use Illuminate\Support\Facades\DB;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\AttributeTypeRepository;

class CreateAttributeTypeAction extends BaseAction
{
    /**
     * @var AttributeTypeRepository $attributeTypeRepository
     */
    protected $attributeTypeRepository;

    /**
     * @param AttributeTypeRepository $attributeTypeRepository
     */
    public function __construct(AttributeTypeRepository $attributeTypeRepository)
    {
        $this->attributeTypeRepository = $attributeTypeRepository;
    }

    /**
     * @return \Illuminate\Support\Collection|mixed
     * @throws \Exception
     */
    public function handle()
    {
        $data = $this->request->all();

        foreach ($data['data'] as $value) {
            $dataToInsert[] = [
                'name' => $value['name'],
            ];
        }
        $this->attributeTypeRepository->insert($dataToInsert, false);

        $arrIdInsert = Common::getArrIDInsert($this->request);
        $attribute_types = $this->attributeTypeRepository->findWhereIn('id', $arrIdInsert);
        $lastRecord = Common::getNameDateLatestRecord($attribute_types[0]);
        return $this->setMessage('create_success', 'attribute_type', $lastRecord, $attribute_types);
    }
}
