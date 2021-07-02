<?php

namespace NinjaLive\Widgets;
use Elementor\Plugin as Elementor;
use NinjaLive\Widgets\ChatWidget;

if (!defined('ABSPATH')) {
    exit;
}

class ElementorHelper
{
    public function __construct()
    {
        add_action( 'elementor/widgets/widgets_registered', array($this, 'init_widgets') );
    }

    public function init_widgets()
    {
        $this->enqueueAssets();
        $widgets_manager = Elementor::instance()->widgets_manager;

        if ( file_exists( NINJALIVECHAT_DIR.'app/Widgets/ChatWidget.php' ) ) {
            require_once NINJALIVECHAT_DIR.'app/Widgets/ChatWidget.php';
            $widgets_manager->register_widget_type(new ChatWidget());
        }
    }

    public function enqueueAssets()
    {
        wp_register_style('ninjalivechat', NINJALIVECHAT_URL . 'public/css/livechat.css', array(), NINJALIVECHAT_VERSION);
        wp_register_script('ninjalivechat', NINJALIVECHAT_URL . 'public/frontend/elementor-ninja-chat.js', array( 'jquery' ), NINJALIVECHAT_VERSION, true);
        wp_register_script('ninjalivechat_manager', NINJALIVECHAT_URL . 'public/frontend/livechat_manager.js', array( 'jquery' ), NINJALIVECHAT_VERSION, true);
    }

    public static function getLayouts() 
    {
        $layouts = array();
        $allLayouts = [ array('title' => 'design1', 'name' => 'Layout One'), array('title' => 'design2', 'name' => 'Layout Two'), array('title' => 'design3', 'name' => 'Layout Three')];
        foreach ($allLayouts as $index=>$layout) {
            $layouts[$layout['title']] = $layout['name'];
        }
        return $layouts;
    }
}