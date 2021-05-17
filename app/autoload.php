<?php
/**
 * Autoloader
 *
 * @package NinjaLive
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('NinjaLiveAutoload')) {
    /**
     * Plugin autoloader.
     *
     * @param $class
     * @since 1.0.0
     *
     */
    function NinjaLiveAutoload($class)
    {
        $namespace = 'NinjaLive';
        if (strpos($class, $namespace) !== 0) {
            return;
        }
        $unprefixed = substr($class, strlen($namespace));
        $file_path = str_replace('\\', DIRECTORY_SEPARATOR, $unprefixed);

        $file = dirname(__FILE__) . $file_path . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
    spl_autoload_register('NinjaLiveAutoload');
}
