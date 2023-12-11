<?php

namespace App\Http\Actions\Category;

use App\Helpers\Common;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\CategoryRepository;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CreateCategoryAction extends BaseAction
{
    /**
     * @var CategoryRepository $categoryRepository
     */
    protected $categoryRepository;

    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return \Illuminate\Support\Collection|mixed
     * @throws \Exception
     */
    public function handle()
    {
        $data = $this->request->all();

        if(isset($data['image'])){
            $pathImage = $this->request['image']->getRealPath() ?? null;
            $folder = config('common.cloudinary.folder_categories');
            $uploadedFileUrl = Common::uploadImageWithCloudinary($pathImage, $folder);
            $data['image'] = $uploadedFileUrl;
        }

        $dataInsert = Common::getDataInsert($data);
        $category = new Category($dataInsert);

        if(!empty($data['parent_id'])){
            $parentId = $data['parent_id'];
            $parentCategory = Category::find($parentId);
            $parentCategory->appendNode($category);
        }

        $category->save();

        $lastRecord = Common::getNameDateLatestRecord($category);

        return $this->setMessage('create_success', 'category', $lastRecord, $category);
    }
}
