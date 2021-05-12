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

        $checked_pages = get_option('ninja_countdown_checked_pages',array());
        
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

            wp_enqueue_script(
                'countdown_manager',
                NINJAWHATSAPPCHAT_URL . 'public/js/'.$configs['layout'].'.js',
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
        $prefix = '.ninja-countdown-timer-1';
		?>

        <style type="text/css">
       
            <?php echo $prefix; ?> {
                background-color: <?php echo $configs['styles']['background_color'].'!important'; ?>;
                <?php echo $configs['styles']['position']; ?>:0px;
            }
            <?php echo $prefix; ?> .ninja-countdown-timer-header-title-text{
                color: <?php echo $configs['styles']['message_color'].'!important';?>;
            }
            <?php echo $prefix; ?> .ninja-countdown-timer-button{
                background-color: <?php echo $configs['styles']['button_color'].'!important'; ?>;
                color: <?php echo $configs['styles']['button_text_color'].'!important'; ?>;
            }
            <?php echo $prefix; ?> .ninja-countdown-timer-item{
                color: <?php echo $configs['styles']['timer_color'].'!important'; ?>;
            }

        </style>

		<?php
    }
}
