<?php

namespace App\Http\Actions\Category;

use App\Models\Category;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\CategoryRepository;

class DetailCategoryAction extends BaseAction
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
        $categoryId = $this->params['id'];
        $result =  Category::descendantsAndSelf($categoryId)->toTree();
        return $result[0];
    }
}
