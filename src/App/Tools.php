<?php
namespace App;

class Tools {
    /**
     * Remove diretórios recursivamente
     */
    static public function rrmdir($dir)
    {
        foreach(glob($dir . '/*') as $file) {
            if(is_dir($file))
                rrmdir($file);
            else
                unlink($file);
        }
        rmdir($dir);
    }

    static public function loadConfig($key = null)
    {
        $config = include 'config.php';
        if ($key)
            return $config[$key];

        return $config;
    }
}
