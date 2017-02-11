<?php
namespace AdminBundle\Lib;

class Globals
{
    protected static $locales;
    protected static $locale;
    protected static $uploadImageDir;
    protected static $uploadImageRootDir;

    public static function setLocales($locales)
    {
        self::$locales= $locales;
    }

    public static function getLocales()
    {
        return self::$locales;
    }

    /**
     * @return string
     */
    public static function getUploadImageDir()
    {
        return self::$uploadImageDir;
    }

    /**
     * @param string $uploadImageDir
     */
    public static function setUploadImageDir($uploadImageDir)
    {
        self::$uploadImageDir = $uploadImageDir;
    }

    /**
     * @return string
     */
    public static function getUploadImageRootDir()
    {
        return self::$uploadImageRootDir;
    }

    /**
     * @param string $uploadImageRootDir
     */
    public static function setUploadImageRootDir($uploadImageRootDir)
    {
        self::$uploadImageRootDir = $uploadImageRootDir;
    }

    /**
     * @return mixed
     */
    public static function getLocale()
    {
        return self::$locale;
    }

    /**
     * @param mixed $locale
     */
    public static function setLocale($locale)
    {
        self::$locale = $locale;
    }

}
