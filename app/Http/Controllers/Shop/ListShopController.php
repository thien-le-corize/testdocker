<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use App\Http\Actions\Shop\ListShopAction;
use App\Http\Requests\Shop\ListShopRequest;
use App\Http\Resources\Shop\ShopCollection;

class ListShopController extends Controller
{
    /**
     * @param ListShopRequest $request
     * @return mixed
     */
    public function __invoke(ListShopRequest $request)
    {
        $data = resolve(ListShopAction::class)
            ->setRequest($request)
            ->handle();

        return (new ShopCollection($data));
    }
}
