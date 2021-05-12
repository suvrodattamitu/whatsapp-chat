<?php

namespace NinjaWhatsapp;
use NinjaWhatsapp\Views\View;

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

        $title = __('Ninja Whatsapp Chat', 'ninjawhatsappchat');

        global $submenu;
        add_menu_page(
            $title,
            $title,
            'manage_options',
            'ninjawhatsappchat',
            array($this, 'render'),
            $this->getIcon(),
            25
        );
        $submenu['ninjawhatsappchat']['countdown'] = array(
            __('Design Countdown', 'ninjawhatsappchat'),
            'manage_options',
            'admin.php?page=ninjawhatsappchat#/',
        );
        $submenu['ninjawhatsappchat']['all_members'] = array(
            __('All Members', 'ninjawhatsappchat'),
            'manage_options',
            'admin.php?page=ninjawhatsappchat#/members',
        );
        $submenu['ninjawhatsappchat']['settings'] = array(
            __('Settings', 'ninjawhatsappchat'),
            'manage_options',
            'admin.php?page=ninjawhatsappchat#/settings',
        );
        $submenu['ninjawhatsappchat']['support'] = array(
            __('Support', 'ninjawhatsappchat'),
            'manage_options',
            'admin.php?page=ninjawhatsappchat#/support',
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
        do_action('ninjawhatsappchat/render_admin_app');
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
        $svg = '<svg id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512"
            xmlns="http://www.w3.org/2000/svg" fill="#fff">
            <g>
                <path d="m457 60h-36v-15c0-24.813-20.187-45-45-45s-45 20.187-45 45v15h-150v-15c0-24.813-20.187-45-45-45s-45 20.187-45 45v15h-36c-30.327 0-55 24.673-55 55v342c0 30.327 24.673 55 55 55h402c30.327 0 55-24.673 55-55v-342c0-30.327-24.673-55-55-55zm-96-15c0-8.271 6.729-15 15-15s15 6.729 15 15v60c0 8.271-6.729 15-15 15s-15-6.729-15-15zm-240 0c0-8.271 6.729-15 15-15s15 6.729 15 15v60c0 8.271-6.729 15-15 15s-15-6.729-15-15zm-91 70c0-13.785 11.215-25 25-25h36v15c0 24.813 20.187 45 45 45s45-20.187 45-45v-15h150v15c0 24.813 20.187 45 45 45s45-20.187 45-45v-15h36c13.785 0 25 11.215 25 25v67h-452zm452 342c0 13.785-11.215 25-25 25h-402c-13.785 0-25-11.215-25-25v-245h452z"/>
                <path d="m306.764 272h23.473v165c0 8.284 6.716 15 15 15s15-6.716 15-15v-180c0-8.284-6.716-15-15-15h-38.473c-8.284 0-15 6.716-15 15s6.715 15 15 15z"/>
                <path d="m211.764 422c-14.886 0-27.658-11.09-29.71-25.796-.192-1.378-.29-2.792-.29-4.204 0-8.284-6.716-15-15-15s-15 6.716-15 15c0 2.793.194 5.603.577 8.35 4.109 29.445 29.655 51.65 59.423 51.65 33.084 0 60-26.916 60-60 0-17.908-7.896-33.997-20.377-45 12.481-11.003 20.377-27.092 20.377-45 0-33.084-26.916-60-60-60-28.607 0-53.367 20.35-58.874 48.387-1.597 8.129 3.699 16.013 11.828 17.61 8.12 1.596 16.012-3.699 17.609-11.828 2.751-14.004 15.131-24.169 29.437-24.169 16.542 0 30 13.458 30 30s-13.458 30-30 30c-8.284 0-15 6.716-15 15s6.716 15 15 15c16.542 0 30 13.458 30 30s-13.458 30-30 30z"/>
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
        if (isset($_GET['page']) && $_GET['page'] == 'ninjawhatsappchat') {

            wp_enqueue_style('ninjawhatsappchat_admin_app', NINJAWHATSAPPCHAT_URL . 'public/css/ninjawhatsappchat-admin.css', array(), NINJAWHATSAPPCHAT_VERSION);
            wp_enqueue_style('ninjawhatsappchat_app', NINJAWHATSAPPCHAT_URL . 'public/css/whatsappchat.css', array(), NINJAWHATSAPPCHAT_VERSION);

            wp_enqueue_script('ninjawhatsappchat_boot', NINJAWHATSAPPCHAT_URL . 'public/js/ninjawhatsappchat-boot.js', array('jquery'), NINJAWHATSAPPCHAT_VERSION, true);

            // 3rd party developers can now add their scripts here
            do_action('ninjawhatsappchat/booting_admin_app');

            wp_enqueue_script('ninjawhatsappchat_admin_app', NINJAWHATSAPPCHAT_URL . 'public/js/ninjawhatsappchat-admin.js', array('ninjawhatsappchat_boot'), NINJAWHATSAPPCHAT_VERSION, true);

            $ninjawhatsappchatAdminVars = apply_filters('ninjawhatsappchat/admin_app_vars', array(

                'i18n' => array(
                    'All Collections' => __('All Collections', 'ninjawhatsappchat')
                ),
                'assets_url' => NINJAWHATSAPPCHAT_URL . 'public',
                'ajaxurl' => admin_url('admin-ajax.php'),

            ));

            wp_localize_script('ninjawhatsappchat_boot', 'NinjaWhatsappAdmin', $ninjawhatsappchatAdminVars);
        }
    }
}
