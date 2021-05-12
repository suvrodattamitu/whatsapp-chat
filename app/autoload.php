<?php
/**
 * Autoloader
 *
 * @package NinjaWhatsapp
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('NinjaWhatsappAutoload')) {
    /**
     * Plugin autoloader.
     *
     * @param $class
     * @since 1.0.0
     *
     */
    function NinjaWhatsappAutoload($class)
    {
        $namespace = 'NinjaWhatsapp';
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
    spl_autoload_register('NinjaWhatsappAutoload');
}
