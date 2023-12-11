<?php

namespace App\Http\Actions\Address;

use App\Helpers\Common;
use Illuminate\Support\Facades\DB;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\AddressRepository;
use App\Exceptions\AuthenticateException;

class DetailAddressAction extends BaseAction
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
        $id = $this->params['id'];
        $address = $this->addressRepository->where([
            'id' => $id,
            'user_id' => auth()->user()->id
        ])->first();

        if(is_null($address)){
            throw AuthenticateException::recordNotFound();
        }
        return $address;
    }
}
