<?php

namespace App\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OrderCriteria.
 *
 * @package namespace App\Repositories\Criteria;
 */
class OrderCriteria implements CriteriaInterface
{
    /**
     * List of request relations from query string
     *
     * @var array
     */
    protected $input;

    /**
     * List of allow relations
     *
     * @var array
     */
    protected $allows;

    /**
     * An constructor of WithRelationsCriteria
     *
     * @param string|array|null $input
     * @param array $allows
     */
    public function __construct(string|array|null $input, array $allows = [])
    {
        $this->input = array_filter(is_array($input) ? $input : explode(',', $input));

        $this->allows = $allows;
    }

    /**
     * Apply criteria in query repository
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $orderableFields = $repository->orderableFields();
        if (! empty($this->allows)) {
            $orderableFields = array_merge($this->allows, $orderableFields);
        }

        if (empty($orderableFields)) {
            return $model;
        }
        
        if (empty($this->input)) {
            return $model->orderBy($orderableFields[0]);
        }

        $orderableFieldKeys = array_filter(array_keys($orderableFields), function ($v) {
            return is_string($v);
        });

        foreach ($this->input as $i) {
            $desc  = $i[0] === '-';
            $field = $desc ? substr($i, 1) : $i;

            if (! in_array($field, $orderableFields) && ! in_array($field, $orderableFieldKeys)) {
                continue;
            }

            if (isset($orderableFields[$field])) {
                $field = $orderableFields[$field];
            }

            $model = $desc ? $model->orderByDesc($field) : $model->orderBy($field);
        }

        return $model;
    }
}
