<?php

namespace App\Http\Actions\Review;


use App\Http\Shared\Actions\BaseAction;
use App\Http\Tasks\Review\CheckPermissionReviewTask;

class CheckPermissionReviewAction extends BaseAction
{
    
    public function handle()
    {
       return resolve(CheckPermissionReviewTask::class)->handle($this->request->all());
    }
}