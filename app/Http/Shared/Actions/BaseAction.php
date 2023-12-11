<?php

namespace App\Http\Shared\Actions;

use App\Helpers\Common;
use Illuminate\Support\Collection;

abstract class BaseAction
{
    /** @var \Illuminate\Support\Collection */
    protected $request;

    /** @var \Illuminate\Database\Eloquent\Model */
    protected $handler;

    /** @var array|null */
    protected $params;

    /** @var string|null */
    protected $patternTableName = null;

    /** @var string|null */
    protected $backUpDbMethodName = null;

    /**
     * Set the request to service
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @return self
     */
    public function setRequest($request)
    {
        $this->request = new Collection($request->validated());
        $this->handler = $request->user();

        return $this;
    }

    /**
     * Set query parameter
     *
     * @return self
     */
    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Allow to get all records or paginated records based on the request
     */
    public function paginateOrAll($repository)
    {
        return $this->request->has('per_page')
            ? $repository->paginate($this->request->get('per_page', 50))
            : $repository->get();
    }

    /**
     * Set message
     *
     * @return array
     */
    public function setMessage($action, $attribute, $latestRecord = null, $listInsertRecord = null)
    {
        $data = [
            'message' => __('messages.action.' . $action, ['attribute' => __('messages.attribute.' . $attribute)]),
            'success' => true
        ];

        if (!is_null($latestRecord)) {
            $data['latest_record'] = $latestRecord;
        }

        if (!is_null($listInsertRecord)) {
            if ($action !== 'delete_success') {
                $data['record_insert'] = $listInsertRecord;
            }
        }

        return $data;
    }

    /**
     * Get pattern table name
     *
     * @return null|string
     */
    public function getLogTable()
    {
        return $this->patternTableName;
    }

    /**
     * Set pattern table name
     *
     * @param string $name
     *
     * @return self
     */
    public function setPatternTableName(string $name)
    {
        $this->patternTableName = $name;

        return $this;
    }

    /**
     * Set backup method name
     * @param string $name
     *
     * @return self
     */
    public function setBackUpDbMethodName(string $name)
    {
        $this->backUpDbMethodName = $name;

        return $this;
    }

    /**
     * Get backup method name
     *
     * @return null|string
     */
    public function getBackUpDbMethodName()
    {
        return $this->backUpDbMethodName;
    }

    abstract public function handle();
}
