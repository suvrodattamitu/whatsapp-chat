<?php

namespace NinjaLive\Views;
use NinjaLive\Views\View;
use NinjaLive\Model\LiveChat;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Public App Renderer and Handler
 * @since 1.0.0
 */
class FrontendApp
{
    public function render()
    {
        if ( is_admin() ) {
			return;
		}

        $page_id = get_the_ID();
        $checked_pages = get_option('ninja_livechat_checked_pages',array());
        
        $all_pages = in_array('-1', $checked_pages);
        $specific_page = in_array($page_id, $checked_pages);

        $showChat = $all_pages || $specific_page;
        if( $showChat ) { 
            $configs = get_option('ninja_live_chat_configs', array());
            $configs = (new LiveChat())->formatConfigs($configs);

            global $wpdb;
            $tablename = $wpdb->prefix . "ninja_chats";
            $allMembers = $wpdb->get_results("SELECT * FROM $tablename");

            if(!empty($allMembers)) {
                $allMembers =  json_decode(json_encode($allMembers), true);
            }

            if( empty($allMembers) ) {
                $allMembers = (new LiveChat())->dummyMembers();
            }

            wp_enqueue_style('ninjalivechat', NINJALIVECHAT_URL . 'public/css/livechat.css', array(), NINJALIVECHAT_VERSION);
            $css = self::generateCSS( $configs );
            add_action('wp_head', function () use ($css) {
                echo $css;
            });

            wp_enqueue_script('ninjalivechat', NINJALIVECHAT_URL . 'public/frontend/'.$configs['layouts']['layout'].'.js', array( 'jquery' ), NINJALIVECHAT_VERSION, true);
            wp_enqueue_script( 'ninjalivechat_manager', NINJALIVECHAT_URL . 'public/frontend/livechat_manager.js', array( 'jquery' ), NINJALIVECHAT_VERSION, true);
                
            return static::getLiveChatHTML(['configs' => $configs, 'members' => $allMembers]);
        }
        
        return;
    }

    public static function getLiveChatHTML($data)
    {
        View::render('Frontend.LiveChat',$data);
    }

    public static function generateCSS($configs)
    {
		?>
        <style type="text/css">
            .ninja-chat-box .ninja-chat-header {
                background: <?php echo $configs['styles']['header_bg_color'].'!important'; ?>;
                color: <?php echo $configs['styles']['header_text_color'].'!important'; ?>;
            }
            .ninja-floating-button {
                background:<?php echo $configs['styles']['button_bg_color'] .'!important'; ?>;
                color:<?php echo $configs['styles']['button_text_color'] .'!important'; ?>;
            }
            .ninja-chat-box .ninja-chat-body{
                background: <?php echo $configs['styles']['body_bg_color'].'!important'; ?>;
            }
            .ninja-chat-box .ninja-chat-body .ninja-member-details{
                color: <?php echo $configs['styles']['body_text_color'].'!important'; ?>;
            }
            .ninja-chat-design2 .ninja-floating-button {
                top: <?php echo $configs['styles']['button_position'].'% !important'; ?>
            }
        </style>
		<?php
    }
}