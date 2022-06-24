<?php

namespace Aditamairhamdev\LaraModel\Helpers;

use Illuminate\Support\Facades\DB;

class General 
{
    static function findPrimaryKey($table, $connection = null)
    {
        $connection = $connection?:config("database.default");

        $pk = DB::connection($connection)->getDoctrineSchemaManager()->listTableDetails($table)->getPrimaryKey();
        if(!$pk) return null;
        return $pk->getColumns()[0];
    }
}