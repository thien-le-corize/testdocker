<?php

namespace App\Http\Actions\Category;

use App\Helpers\Common;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\CategoryRepository;

class DeleteCategoryAction extends BaseAction
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
        $categoryId = $this->request['id'];
        // $dataUpdate = Common::getDataUpdate($data);
        // $category = Category::find($data['id']);

        // if (!empty($data['parent_id'])) {
        //     $newParentNode = Category::find($data['parent_id']);
        //     $category->appendToNode($newParentNode);
        // }

        // $category->update($dataUpdate);

        // return $this->setMessage('update_success', 'category');
    }
}
