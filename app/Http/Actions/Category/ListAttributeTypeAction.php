<?php

namespace App\Http\Actions\Category;

use App\Http\Shared\Actions\BaseAction;
use App\Http\Tasks\Category\ListAttributeTypeTask;

class ListAttributeTypeAction extends BaseAction
{
    /**
     * @return \Illuminate\Support\Collection|mixed
     * @throws \Exception
     */
    public function handle()
    {
        return resolve(ListAttributeTypeTask::class)->handle($this->request);
    }
}
