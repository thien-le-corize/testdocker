<?php

namespace App\Http\Actions\user;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\Criteria\OrderCriteria;
use App\Repositories\Criteria\WithRelationCriteria;

class ListUserAction extends BaseAction
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function handle()
    {
        $query = $this->userRepository
            ->pushCriteria(new OrderCriteria($this->request->get('order')))
            ->pushCriteria(new WithRelationCriteria($this->request->get('with')));
        return $this->paginateOrAll($query->withTrashed())->filter();
    }
}