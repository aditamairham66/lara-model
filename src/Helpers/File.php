<?php

namespace Aditamairhamdev\LaraModel\Helpers;

trait File
{
    static function appPath($path)
    {
        if(!function_exists("app_path")) {
            return app()->path() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
        } else {
            return app_path($path);
        }
    }

    static function contentPrimaryKey($key)
    {
        return '
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = "'.$key.'";';
    }

    static function contentConnection($con)
    {
        return '
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = "'.$con.'";';
    }

}