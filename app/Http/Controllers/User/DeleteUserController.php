<?php

namespace App\Http\Controllers\User;

use App\Http\Actions\User\DeleteUserAction;
use App\Http\Requests\User\DeleteUserRequest;
use Illuminate\Routing\Controller;

class DeleteUserController extends Controller
{
    /**
     * @param DeleteUserRequest $request
     * @return mixed
     */
    public function __invoke(DeleteUserRequest $request, $id)
    {
        $data = resolve(DeleteUserAction::class)
            ->setParams(['id' => $id])
            ->setRequest($request)->handle();

        return $data;
    }
}
