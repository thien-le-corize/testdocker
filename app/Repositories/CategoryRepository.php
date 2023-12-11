<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\ActionModelTraits;
use App\Repositories\BaseRepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class CategoryRepository extends BaseRepository implements BaseRepositoryInterface
{
    use ActionModelTraits;

    public function model()
    {
        return Category::class;
    }

    /**
     * Get list of filterable fields
     *
     * @return array
     */
    public function filterableFields()
    {
        return [];
    }

    /**
     * Get list of orderable fields
     *
     * @return array
     */
    public function orderableFields()
    {
        return [
            'id'
        ];
    }

    /**
     * Get list of allowable relations
     *
     * @return array
     */
    public function allowableRelations()
    {
        return [];
    }
}