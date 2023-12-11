<?php

namespace App\Http\Actions\Product;

use App\Helpers\Common;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\ProductRepository;
use App\Http\Tasks\Product\CreateProductTask;

class UpdateProductAction extends BaseAction
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

        if(!empty($data['attributes'])){
            $data['attributes'] = json_encode(json_decode($data['attributes'], true));
        }

        $query = $this->productRepository->where(['id' => (int)$data['id']])->first();
        
        $shopId = $query->shop_id;
        // Common::deleteImages($pathImages);
        if(!empty($data['images'])){
            $pathImages = collect($query->getAttributeValue('images'))->toArray();
            Common::deleteImages($pathImages);

            $folder = config('common.uploads.folder_products') . $shopId . '/';
            $data['images'] = Common::uploadMultiImage($data['images'], $folder);
            // dd($data['images']);
            // $data['images'] = json_encode($data['images']);
        }
        // dd( $data['images']);
        $query->update($data);

        $latestRecord = resolve(Product::class)->getLatestRecord();
        return $this->setMessage(
            'update_success',
            'product',
            Common::getNameDateLatestRecord($latestRecord)
        );
    }
}
