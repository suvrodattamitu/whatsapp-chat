<?php

namespace NinjaWhatsapp\Views;
use NinjaWhatsapp\Views\View;
use NinjaWhatsapp\Model\WhatsappChat;

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

        $checked_pages = get_option('ninja_whatsappchat_checked_pages',array());
        
        $all_pages = in_array('-1', $checked_pages);
        $specific_page = in_array($page_id, $checked_pages);

        $showTimer = $all_pages || $specific_page;
    
        if( $showTimer ) { 
            $configs = get_option('ninja_whatsapp_chat_configs', array());
            $configs = (new WhatsappChat())->formatConfigs($configs);

            global $wpdb;
            $tablename = $wpdb->prefix . "ninja_chats";
            $allMembers = $wpdb->get_results("SELECT * FROM $tablename");

            if(!empty($allMembers)) {
                $allMembers =  json_decode(json_encode($allMembers), true);
            }

            if( empty($allMembers) ) {
                $allMembers = (new WhatsappChat())->dummyMembers();
            }

            //dont load assets if the time is ended
            wp_enqueue_style('ninjawhatsappchat', NINJAWHATSAPPCHAT_URL . 'public/css/whatsappchat.css', array(), NINJAWHATSAPPCHAT_VERSION);
            $css = self::generateCSS( $configs );
            add_action('wp_head', function () use ($css) {
                echo $css;
            });

            wp_enqueue_script(
                'ninjawhatsappchat',
                NINJAWHATSAPPCHAT_URL . 'public/js/'.$configs['layouts']['layout'].'.js',
                array( 'jquery' ),
                NINJAWHATSAPPCHAT_VERSION,
                true
            );

            wp_enqueue_script(
                'ninjawhatsappchat_manager',
                NINJAWHATSAPPCHAT_URL . 'public/js/whatsappchat_manager.js',
                array( 'jquery' ),
                NINJAWHATSAPPCHAT_VERSION,
                true
            );
                
            return static::getWhatsappChatHTML(['configs' => $configs, 'members' => $allMembers]);
        }
        return;
    }

    public static function getWhatsappChatHTML($data)
    {
        View::render('Frontend.WhatsappChat',$data);
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

        </style>

		<?php
    }
}
