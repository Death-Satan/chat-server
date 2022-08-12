<?php


namespace App\Enums;


class BaseEnums
{

    public static function const()
    {
        $class = static::class;
        $ref = new \ReflectionClass($class);
        return $ref->getConstants();
    }

    public static function exists($key)
    {
        return array_key_exists($key,static::const());
    }
}