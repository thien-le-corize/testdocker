<?php

namespace App\Http\Shared\Tasks;

use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class GetQueryLogTask
{
    /**
     * GetQueryLogTask
     *
     * @return string sql query
     */
    public function handle()
    {
        $queryLog = DB::getQueryLog();

        $sql = $queryLog[0]['query'];
        $bindings = $queryLog[0]['bindings'];

        foreach ($bindings as $binding) {
            if (is_string($binding)) {
                $binding = "'{$binding}'";
            } elseif ($binding === null) {
                $binding = 'NULL';
            } elseif ($binding instanceof Carbon) {
                $binding = "'{$binding->toDateTimeString()}'";
            } elseif ($binding instanceof DateTime) {
                $binding = "'{$binding->format('Y-m-d H:i:s')}'";
            }

            $sql = preg_replace("/\?/", $binding, $sql, 1);
        }

        return $sql;
    }
}
