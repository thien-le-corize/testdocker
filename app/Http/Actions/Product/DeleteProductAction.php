<?php

namespace App\Http\Actions\Product;

use App\Models\Role;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\ProductRepository;
use App\Exceptions\AuthenticateException;

class DeleteProductAction extends BaseAction
{
    /**
     * @var ProductRepository $productRepository
     */
    protected $productRepository;

    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @return \Illuminate\Support\Collection|mixed
     * @throws \Exception
     */
    public function handle()
    {
        $product = $this->productRepository->findOrFail($this->params['id'])->delete();
  
        return $this->setMessage('delete_success', 'product', null, null);
    }
}
