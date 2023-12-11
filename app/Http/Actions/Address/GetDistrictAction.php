<?php

namespace App\Http\Actions\Address;

use Illuminate\Support\Facades\Http;
use App\Http\Shared\Actions\BaseAction;

class GetDistrictAction extends BaseAction
{

    /**
     * @return \Illuminate\Support\Collection|mixed
     * @throws \Exception
     */
    public function handle()
    {
        $data = Http::withHeaders([
            'Token' => config('ghn.token'),
            'Content-Type' => 'application/json',
        ])
        ->get(config('ghn.api.district'), [
            'province_id' => $this->request['province_id'],
        ]);

        return json_decode($data, true);
    }
}
