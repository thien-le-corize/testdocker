<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use App\Http\Actions\Shop\GetShopAction;
use App\Http\Requests\Shop\GetShopRequest;
use App\Http\Resources\Shop\ShopCollection;

class GetShopController extends Controller
{
    /**
     * @param GetShopRequest $request
     * @return mixed
     */
    public function __invoke(GetShopRequest $request, $id)
    {
        $data = resolve(GetShopAction::class)
            ->setRequest($request)
            ->setParams(['id' => $id])
            ->handle();

        return $data;
    }
}
