<?php

namespace App\Http\Actions\Cart;

use App\Http\Shared\Actions\BaseAction;
use App\Http\Tasks\Cart\DeleteCartTask;

class DeleteCartAction extends BaseAction
{

    /**
     * @return \Illuminate\Support\Collection|mixed
     * @throws \Exception
     */
    public function handle()
    {
        $data = $this->request->all();
        resolve(DeleteCartTask::class)->handle($data);
        return $this->setMessage('delete_success', 'cart', null, null);
    }
}
