<?php

namespace App\Http\Controllers\User;

use App\Http\Actions\User\ListUserAction;
use App\Http\Requests\User\ListUserRequest;
use Illuminate\Routing\Controller;
use App\Http\Resources\User\UserCollection;

class ListUserController extends Controller
{
    /**
     * @param ListUserRequest $request
     * @return mixed
     */
    public function __invoke(ListUserRequest $request)
    {
        $data = resolve(ListUserAction::class)->setRequest($request)->handle();
        return (new UserCollection($data));
    }
}
