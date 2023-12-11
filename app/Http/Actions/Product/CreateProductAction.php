<?php

namespace App\Http\Actions\Product;

use App\Exceptions\AuthenticateException;
use App\Helpers\Common;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\ProductRepository;
use App\Http\Tasks\Product\CreateProductTask;

class CreateProductAction extends BaseAction
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
        $data = $this->request->all();

        $data['attributes'] = json_encode(json_decode($data['attributes'], true));
        $data['dimension'] = json_encode(json_decode($data['dimension'], true));

        $data['shop_id'] = optional(auth()->user())->getRelationValue('shop')->id;

        if (is_null($data['shop_id'])) {
            throw AuthenticateException::forbidden();
        }

        $folder = config('common.uploads.folder_products') . $data['shop_id'] . '/';
        $data['images'] = Common::uploadMultiImage($data['images'], $folder);
        $data['images'] = json_encode($data['images']);

        $productId = $this->productRepository->insertGetId($data);
        $product = $this->productRepository->find($productId);

        $lastRecord = Common::getNameDateLatestRecord($product);

        return $this->setMessage('create_success', 'product', $lastRecord, $product);
    }
}
