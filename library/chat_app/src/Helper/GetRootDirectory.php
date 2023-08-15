<?php

namespace Adideas\ChatApp\Helper;

class GetRootDirectory
{
    protected static array $ENV = [];

    public static function get() {
        if (!isset(self::$ENV['_root_dir'])) {
            $array_path             = explode(DIRECTORY_SEPARATOR, __DIR__);
            $array_path             = array_slice($array_path, 0, count($array_path) - 2);
            self::$ENV['_root_dir'] = implode(DIRECTORY_SEPARATOR, $array_path);
        }

        return self::$ENV['_root_dir'];
    }

    public static function path(...$path): ?string
    {
        if ($path && count($path) == 1) {
            $path = $path[0];
        }
        if ($path && is_array($path)) {
            return self::get() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $path);
        }

        return null;
    }
}
