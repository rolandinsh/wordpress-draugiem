<?php

function __autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName = '';
    $namespace = '';
    $plugindir = plugin_dir_path(__FILE__);
    $base_dir = $plugindir . '../src/';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    if (file_exists($base_dir . $fileName)) {
        require $base_dir . $fileName;
    }
}
