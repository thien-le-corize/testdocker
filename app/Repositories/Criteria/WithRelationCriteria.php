<?php

namespace App\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WithRelationCriteria.
 *
 * @package namespace App\Repositories\Criteria;
 */
class WithRelationCriteria implements CriteriaInterface
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
     * @var array|null
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
     * @param \Prettus\Repository\Contracts\RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $withs = [];

        if (!$this->allows) {
            $this->allows = $repository->allowableRelations();
        }

        foreach ($this->allows as $key => $value) {
            if (! in_array(is_numeric($key) ? $value : $key, $this->input)) {
                continue;
            }

            if (is_array($value)) {
                $withs[$value[0]] = $value[1] ?? function () {
                    //
                };
                continue;
            }

            $withs[$key] = $value;
        }

        return empty($withs) ? $model : $model->with($withs);
    }
}
