<?php

namespace App\Http\Actions\Address;

use Illuminate\Support\Facades\Http;
use App\Http\Shared\Actions\BaseAction;

class GetProvinceAction extends BaseAction
{

    /**
     * @return \Illuminate\Support\Collection|mixed
     * @throws \Exception
     */
    public function handle()
    {
        $data = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Token' => config('ghn.token'),
        ])
        ->get(config('ghn.api.province'));
        
        return json_decode($data, true);
    }
}
