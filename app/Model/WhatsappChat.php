<?php

namespace NinjaWhatsapp\Model;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Base Model Class
 * @since 1.0.0
 */
class WhatsappChat
{
    public function formatConfigs($settings = array())
    {
        return array(
            'layout' => 'design2',
            'platform' => 'whatsapp',
            'chat_contents' => array(
                'chat_header' => array(
                    'title' => isset($settings['chat_header']['title']) ? $settings['chat_header']['title'] : __('Need Help?', 'wpsocialreviews'),
                    'description' => isset($settings['chat_header']['description']) ? $settings['chat_header']['description'] : __('Ask us anything!', 'wpsocialreviews'),
                ),
            ),
            'chat_bubble' => array(
                'button_text' => isset($settings['chat_bubble']['button_text']) ? $settings['chat_bubble']['button_text'] : __('', 'wpsocialreviews'),
                'button_icon' => isset($settings['chat_bubble']['button_icon']) ? $settings['chat_bubble']['button_icon'] : 'icon7',
            ),
            'styles' => array(
                'button_color' => isset($settings['styles']['button_color']) ? $settings['styles']['button_color'] : '',
                'button_text_color' => isset($settings['styles']['button_text_color']) ? $settings['styles']['button_text_color'] : '',
                'header_color' => isset($settings['styles']['header_color']) ? $settings['styles']['header_color'] : '',
                'header_text_color' => isset($settings['styles']['header_text_color']) ? $settings['styles']['header_text_color'] : '',
            )
        );    
    }

    public function dummyMembers()
    {
        return array(
            ['id'=>0, 'member_name'=>'John Doe', 'member_designation'=>'sales expert', 'member_img'=>'', 'member_status'=>'online', 'member_number'=> '018342344234'],
            ['id'=>1, 'member_name'=>'John Don', 'member_designation'=>'technical support', 'member_img'=>'', 'member_status'=>'online', 'member_number'=> '017342344234'],
            ['id'=>2, 'member_name'=>'John Done', 'member_designation'=>'customer support', 'member_img'=>'', 'member_status'=>'online', 'member_number'=> '019342344234'],
            ['id'=>3, 'member_name'=>'John Do', 'member_designation'=>'marketing expert', 'member_img'=>'', 'member_status'=>'online', 'member_number'=> '016342344234'],
            ['id'=>4, 'member_name'=>'John Do', 'member_designation'=>'it expert', 'member_img'=>'', 'member_status'=>'online', 'member_number'=> '013342344234'],
            ['id'=>5, 'member_name'=>'John Dun', 'member_designation'=>'business expert', 'member_img'=>'', 'member_status'=>'offline', 'member_number'=> '018342344234'],
        );
    }
}