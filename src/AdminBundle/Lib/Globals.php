<?php
namespace AdminBundle\Lib;

class Globals
{
    protected static $locales;

    public static function setLocales($locales)
    {
        self::$locales= $locales;
    }

    public static function getLocales()
    {
        return self::$locales;
    }
}
