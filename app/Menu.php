<?php

namespace NinjaLive;
use NinjaLive\Views\View;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Menu and Admin Pages
 * @since 1.0.0
 */
class Menu
{
    public function register()
    {
        add_action('admin_menu', array($this, 'addMenus'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueAssets'));
    }

    /**
     *
     * Add Menu and sub menu for the admin page
     * @return string
     * @since 1.0.0
     *
     **/
    public function addMenus()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $title = __('Live Chat', 'ninjalivechat');

        global $submenu;
        add_menu_page(
            $title,
            $title,
            'manage_options',
            'ninjalivechat',
            array($this, 'render'),
            $this->getIcon(),
            25
        );
        $submenu['ninjalivechat']['countdown'] = array(
            __('Design Chat', 'ninjalivechat'),
            'manage_options',
            'admin.php?page=ninjalivechat#/',
        );
        $submenu['ninjalivechat']['all_members'] = array(
            __('All Members', 'ninjalivechat'),
            'manage_options',
            'admin.php?page=ninjalivechat#/members',
        );
        $submenu['ninjalivechat']['settings'] = array(
            __('Settings', 'ninjalivechat'),
            'manage_options',
            'admin.php?page=ninjalivechat#/settings',
        );
        $submenu['ninjalivechat']['support'] = array(
            __('Support', 'ninjalivechat'),
            'manage_options',
            'admin.php?page=ninjalivechat#/support',
        );
    }

    /**
     *
     * 3rd party developer can render admin app from here
     * @return string
     * @since 1.0.0
     *
     **/
    public function render()
    {
        do_action('ninjalivechat/render_admin_app');
    }

    /**
     *
     * SVG icon for menu
     * @return string
     * @since 1.0.0
     *
     **/
    public function getIcon()
    {
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 58.18 43.64">
            <g id="Layer_2" data-name="Layer 2" style="fill:#fff">
                <g id="Layer_1-2" data-name="Layer 1" style="fill:#fff">
                    <path class="wpsr-fm-bubble-btn-svg-path-1" d="M52.73,0a5.26,5.26,0,0,1,3.86,1.59,5.26,5.26,0,0,1,1.59,3.86V38.18a5.43,5.43,0,0,1-5.45,5.46H5.45a5.26,5.26,0,0,1-3.86-1.59A5.27,5.27,0,0,1,0,38.18V5.45A5.26,5.26,0,0,1,1.59,1.59,5.26,5.26,0,0,1,5.45,0Zm0,5.45H5.45v4.66q4,3.2,15.35,12.05a9.64,9.64,0,0,0,1.59,1.42,29.18,29.18,0,0,0,2.38,1.82c.53.34,1.23.74,2.11,1.19a4.9,4.9,0,0,0,2.21.68,4.94,4.94,0,0,0,2.22-.68c.87-.45,1.57-.85,2.1-1.19s1.32-.95,2.39-1.82a10.22,10.22,0,0,0,1.59-1.42q11.36-8.86,15.34-12ZM5.45,38.18H52.73V17.05q-4,3.18-11.93,9.43a14.45,14.45,0,0,0-1.65,1.36c-.95.84-1.69,1.44-2.22,1.82s-1.29.85-2.27,1.42a13.26,13.26,0,0,1-2.84,1.25,9.55,9.55,0,0,1-2.73.4,10,10,0,0,1-2.78-.4A10.47,10.47,0,0,1,23.47,31q-1.42-.9-2.22-1.47T19,27.78a17,17,0,0,0-1.64-1.3q-8-6.26-11.94-9.43Z"/>
                </g>
            </g>
            </svg>';
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    /**
     *
     * Enqueue all js file which are needed for admin side
     * @since 1.0.0
     *
     **/
    public function enqueueAssets()
    {
        if (isset($_GET['page']) && $_GET['page'] == 'ninjalivechat') {

            wp_enqueue_style('ninjalivechat_admin_app', NINJALIVECHAT_URL . 'public/css/ninjalivechat-admin.css', array(), NINJALIVECHAT_VERSION);
            wp_enqueue_style('ninjalivechat_app', NINJALIVECHAT_URL . 'public/css/livechat.css', array(), NINJALIVECHAT_VERSION);

            wp_enqueue_script('ninjalivechat_boot', NINJALIVECHAT_URL . 'public/js/ninjalivechat-boot.js', array('jquery'), NINJALIVECHAT_VERSION, true);

            // 3rd party developers can now add their scripts here
            do_action('ninjalivechat/booting_admin_app');

            wp_enqueue_script('ninjalivechat_admin_app', NINJALIVECHAT_URL . 'public/js/ninjalivechat-admin.js', array('ninjalivechat_boot'), NINJALIVECHAT_VERSION, true);

            $ninjalivechatAdminVars = apply_filters('ninjalivechat/admin_app_vars', array(

                'i18n' => array(
                    'All Collections' => __('All Collections', 'ninjalivechat')
                ),
                'assets_url' => NINJALIVECHAT_URL . 'public',
                'ajaxurl' => admin_url('admin-ajax.php'),

            ));

            wp_localize_script('ninjalivechat_boot', 'NinjaLiveAdmin', $ninjalivechatAdminVars);
        }
    }
}
