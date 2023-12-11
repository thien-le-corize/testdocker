<?php

namespace App\Http\Actions\Product;

use App\Repositories\UserRepository;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\ProductRepository;

class ApprovalProductAction extends BaseAction
{

    protected $productRepository;
    protected $userRepository;

    public function __construct(ProductRepository $productRepository, UserRepository $userRepository)
    {
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @return \Illuminate\Support\Collection|mixed
     * @throws \Exception
     */
    public function handle()
    {
        $data = $this->request->all();

        $this->productRepository->where(['id' => $data['id']])->update(['status' => $data['status']]);
        return $this->setMessage('update_success', 'approval', null, null);
        
    }
}
