<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface TestRepositoryRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface BaseRepositoryInterface extends RepositoryInterface
{
    /**
     * Get list of filterable fields
     *
     * @return array
     */
    public function filterableFields();

    /**
     * Get list of orderable fields
     *
     * @return array
     */
    public function orderableFields();

    /**
     * Get list of allowable relations
     *
     * @return array
     */
    public function allowableRelations();
}
