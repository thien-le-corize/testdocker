<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait ActionModelTraits
{
    /**
     * @param array $condition
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function where($condition)
    {
        $this->applyCriteria();
        $this->applyScope();
        try {
            $model = $this->model->where($condition);
        } catch (\PDOException $exception) {
            Log::error($exception);
        }
        $this->resetModel();

        return $this->parserResult($model ?? null);
    }

    /**
     * @param string $column
     * @param array$values
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function whereIn($column, $values)
    {
        $this->applyCriteria();
        $this->applyScope();
        try {
            $model = $this->model->whereIn($column, $values);
        } catch (\PDOException $exception) {
            Log::error($exception);
        }
        $this->resetModel();

        return $this->parserResult($model ?? null);
    }

    /**
     * @param array $ids
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function destroy($ids)
    {
        $this->applyCriteria();
        $this->applyScope();
        try {
            $model = $this->model->destroy($ids);
        } catch (\PDOException $exception) {
            Log::error($exception);
        }
        $this->resetModel();

        return $this->parserResult($model ?? null);
    }

    /**
     * @param array $data
     * @param bool $createdBy
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function insert(array $data, $createdBy = true)
    {
        $this->applyCriteria();
        $this->applyScope();
        $data  = array_map(function ($dataPattern) use ($createdBy) {
            $dataPattern['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $dataPattern['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
            if ($createdBy) {
                $dataPattern['created_by'] = Auth::id();
                $dataPattern['updated_by'] = Auth::id();
            }
            return $dataPattern;
        }, $data);
        try {
            $model = $this->model->insert($data);
        } catch (\PDOException $exception) {
            dd($exception);
            Log::error($exception);
        }
        $this->resetModel();

        return $this->parserResult($model ?? null);
    }

    /**
     * @param array $data
     * @param bool $createdBy
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function insertGetId(array $data, $createdBy = true)
    {
        $this->applyCriteria();
        $this->applyScope();
        $data['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $data['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
        if ($createdBy) {
            $data['created_by'] = Auth::id();
            $data['updated_by'] = Auth::id();
        }
        try {
            $model = $this->model->insertGetId($data);
        } catch (\PDOException $exception) {
            dd($exception);
            Log::error($exception);
        }
        $this->resetModel();

        return $this->parserResult($model ?? null);
    }

    /**
     * @param array $data
     * @param bool $updatedBy
     * @param array $uniqueColumns lists the column(s) that uniquely identify records within the associated table.
     * @param array $updatedColumns an array of the columns that should be updated if a matching record already exists in the database
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function upsert(array $data, $updatedBy = true, array $uniqueColumns = ['id'], array $updatedColumns = null)
    {
        $this->applyCriteria();
        $this->applyScope();
        $data  = array_map(function ($dataPattern) use ($updatedBy) {
            $dataPattern['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
            if ($updatedBy) {
                $dataPattern['updated_by'] = Auth::id();
            }
            return $dataPattern;
        }, $data);
        if ($updatedBy && $updatedColumns && !array_key_exists('updated_by', $updatedColumns)) {
            $updatedColumns[] = 'updated_by';
        }
        try {
            $model = $this->model->upsert($data, $uniqueColumns, $updatedColumns);
        } catch (\PDOException $exception) {
            dd($exception);
            Log::error($exception);
        }
        $this->resetModel();

        return $this->parserResult($model ?? null);
    }
}
