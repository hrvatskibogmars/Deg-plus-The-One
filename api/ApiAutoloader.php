<?php
/**
 * Created by PhpStorm.
 * User: vilimstubican
 * Date: 19/04/16
 * Time: 11:15
 */

namespace app;


class ApiAutoloader
{

    const INTERFACES_DIRECTORY  = '/interfaces';
    const MODELS_DIRECTORY      = '/models';

    /**
     * Collect recursively all function files.
     * 
     * @return mixed
     */
    public static function getIncludeFolders()
    {
        $interfacesBase = __DIR__ . self::INTERFACES_DIRECTORY;
        $modelsBase     = __DIR__ . self::MODELS_DIRECTORY;

        $includes = array_merge(
            self::collectFiles( $interfacesBase, self::INTERFACES_DIRECTORY),
            self::collectFiles( $modelsBase, self::MODELS_DIRECTORY)
        );

        return $includes;
    }

    /**
     * Recursively collects all files from $path.
     * 
     * @param $path
     * @param $base
     * @return array
     */
    private static function collectFiles($path, $base)
    {
        $files = array();
        $data = array_diff(scandir($path), array('..', '.'));

        $directories = array();
        foreach ($data as $f){
            if(is_dir($path . DIRECTORY_SEPARATOR . $f)){
                $directories = array_merge(
                    $directories,
                    self::collectFiles($path . DIRECTORY_SEPARATOR . $f, $base . DIRECTORY_SEPARATOR . $f)
                );
            } else {
                $files[] = $base . DIRECTORY_SEPARATOR . $f;
            }
        }

        return array_merge($directories, $files);
    }

}
