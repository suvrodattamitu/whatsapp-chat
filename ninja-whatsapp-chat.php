<?php
/**
 * Plugin Name: Ninja Whatsapp Chat
 * Plugin URI: 
 * Description: Ninja Whatsapp Chat - is an fastest and easiest alternative to add business countdown functionalities on your website.
 * Author: Light Plugins
 * Author URI: 
 * License: GPLv2 or later
 * Version: 1.0.0
 * Text Domain: ninjawhatsappchat
*/

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('NINJAWHATSAPPCHAT_VERSION')) {
    
    define('NINJAWHATSAPPCHAT_VERSION', '1.0.0');
    define('NINJAWHATSAPPCHAT_DB_VERSION', 120);
    define('NINJAWHATSAPPCHAT_MAIN_FILE', __FILE__);
    define('NINJAWHATSAPPCHAT_BASENAME', plugin_basename(__FILE__));
    define('NINJAWHATSAPPCHAT_URL', plugin_dir_url(__FILE__));
    define('NINJAWHATSAPPCHAT_DIR', plugin_dir_path(__FILE__));

    class NinjaWhatsapp
    {
        public function boot()
        {
            $this->textDomain();
            $this->loadDependencies();

            if (is_admin()) {
                $this->adminHooks();
            }
            $this->publicHooks();
        }

        public function textDomain()
        {
            load_plugin_textdomain('ninjawhatsappchat', false, basename(dirname(__FILE__)) . '/languages');
        }

        public function loadDependencies()
        {
            require_once(NINJAWHATSAPPCHAT_DIR . 'app/autoload.php');
        }

        public function adminHooks()
        {
            $menu = new \NinjaWhatsapp\Menu();
            $menu->register();

            $ajaxHandler = new \NinjaWhatsapp\Route\AdminAjaxHandler();
            $ajaxHandler->registerEndpoints();

            add_action('ninjawhatsappchat/render_admin_app', function () {
                $adminApp = new \NinjaWhatsapp\Views\AdminApp();
                $adminApp->bootView();
            });

            add_action('admin_init', function () {
                $disablePages = [
                    'ninjawhatsappchat',
                ];
                if (isset($_GET['page']) && in_array($_GET['page'], $disablePages)) {
                    remove_all_actions('admin_notices');
                }
            });
        }

        public function publicHooks()
        {
            add_action('wp_footer', array((new \NinjaWhatsapp\Views\FrontendApp()), 'render'));
        }
    }

    add_action('plugins_loaded', function () {
        (new NinjaWhatsapp())->boot();
    });

    register_activation_hook(NINJAWHATSAPPCHAT_MAIN_FILE, function ($netWorkWide) {
        require_once(NINJAWHATSAPPCHAT_DIR . 'app/Database/Activator.php');
        $activator = new \NinjaWhatsapp\Database\Activator();
        $activator->migrateDatabases($netWorkWide);
    });

} else {
    add_action('admin_init', function () {
        deactivate_plugins(plugin_basename(__FILE__));
    });
}