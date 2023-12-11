<?php

namespace App\Http\Tasks\Category;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Repositories\CategoryRepository;

class ListCategoryTask
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
     * @return \App\Models\Category
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function handle()
    {
        $categories = Category::get()->where('status', true)->toTree();
        return $categories;
    }
}
