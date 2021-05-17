<?php
/**
 * Plugin Name: Ninja Live Chat
 * Plugin URI: 
 * Description: Ninja Live Chat - is an fastest and easiest alternative to add chat functionalities on your website.
 * Author: Light Plugins
 * Author URI: 
 * License: GPLv2 or later
 * Version: 1.0.0
 * Text Domain: ninjalivechat
*/

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('NINJALIVECHAT_VERSION')) {
    
    define('NINJALIVECHAT_VERSION', '1.0.0');
    define('NINJALIVECHAT_DB_VERSION', 211);
    define('NINJALIVECHAT_MAIN_FILE', __FILE__);
    define('NINJALIVECHAT_BASENAME', plugin_basename(__FILE__));
    define('NINJALIVECHAT_URL', plugin_dir_url(__FILE__));
    define('NINJALIVECHAT_DIR', plugin_dir_path(__FILE__));

    class NinjaLive
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
            load_plugin_textdomain('ninjalivechat', false, basename(dirname(__FILE__)) . '/languages');
        }

        public function loadDependencies()
        {
            require_once(NINJALIVECHAT_DIR . 'app/autoload.php');
        }

        public function adminHooks()
        {
            $menu = new \NinjaLive\Menu();
            $menu->register();

            $ajaxHandler = new \NinjaLive\Route\AdminAjaxHandler();
            $ajaxHandler->registerEndpoints();

            add_action('ninjalivechat/render_admin_app', function () {
                $adminApp = new \NinjaLive\Views\AdminApp();
                $adminApp->bootView();
            });

            add_action('admin_init', function () {
                $disablePages = [
                    'ninjalivechat',
                ];
                if (isset($_GET['page']) && in_array($_GET['page'], $disablePages)) {
                    remove_all_actions('admin_notices');
                }
            });
        }

        public function publicHooks()
        {
            add_action('wp_footer', array((new \NinjaLive\Views\FrontendApp()), 'render'));
        }
    }

    add_action('plugins_loaded', function () {
        (new NinjaLive())->boot();
    });

    register_activation_hook(NINJALIVECHAT_MAIN_FILE, function ($netWorkWide) {
        require_once(NINJALIVECHAT_DIR . 'app/Database/Activator.php');
        $activator = new \NinjaLive\Database\Activator();
        $activator->migrateDatabases($netWorkWide);
    });

} else {
    add_action('admin_init', function () {
        deactivate_plugins(plugin_basename(__FILE__));
    });
}