<?php

namespace App\Http\Actions\Address;

use App\Helpers\Common;
use Illuminate\Support\Facades\DB;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\AddressRepository;

class CreateAddressAction extends BaseAction
{

    protected $addressRepository;

    public function __construct
    (
        AddressRepository $addressRepository,
    )
    {
        $this->addressRepository = $addressRepository;
    }
    /**
     * @return \Illuminate\Support\Collection|mixed
     * @throws \Exception
     */
    public function handle()
    {
        $data = $this->request->all();
        $data['province'] =  json_encode($data['province'], JSON_UNESCAPED_UNICODE);
        $data['district'] = json_encode($data['district'], JSON_UNESCAPED_UNICODE);
        $data['ward'] = json_encode($data['ward'], JSON_UNESCAPED_UNICODE);
        $data['user_id'] = auth()->user()->id;

        $addressId = $this->addressRepository->insertGetId($data, false);
        $address = $this->addressRepository->find($addressId);
        $lastRecord = Common::getNameDateLatestRecord($address);
        return $this->setMessage('create_success', 'address', $lastRecord, $address);
    }
}
