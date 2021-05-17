<?php

namespace NinjaLive\Model;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Base Model Class
 * @since 1.0.0
 */
class LiveChat
{
    public function formatConfigs($settings = array())
    {
        return array(
            'platform' => 'live',
            'layouts'  => array(
                'layout' => isset($settings['layouts']['layout']) ? $settings['layouts']['layout'] : 'design2',
            ),
            'chat_contents' => array(
                'chat_header' => array(
                    'title' => isset($settings['chat_contents']['chat_header']['title']) ? $settings['chat_contents']['chat_header']['title'] : __('Need Help?', 'wpsocialreviews'),
                    'description' => isset($settings['chat_contents']['chat_header']['description']) ? $settings['chat_contents']['chat_header']['description'] : __('Ask us anything!', 'wpsocialreviews'),
                ),
                'chat_bubble' => array(
                    'button_text' => isset($settings['chat_contents']['chat_bubble']['button_text']) ? $settings['chat_contents']['chat_bubble']['button_text'] : __('', 'wpsocialreviews'),
                    'button_icon' => isset($settings['chat_contents']['chat_bubble']['button_icon']) ? $settings['chat_contents']['chat_bubble']['button_icon'] : 'icon7',
                ),
            ),
            'styles' => array(
                'button_bg_color' => isset($settings['styles']['button_bg_color']) ? $settings['styles']['button_bg_color'] : '#fff',
                'button_text_color' => isset($settings['styles']['button_text_color']) ? $settings['styles']['button_text_color'] : '#ffffff',
                'button_position'   => isset($settings['styles']['button_position']) ? (int)$settings['styles']['button_position'] : 50,
                'header_bg_color' => isset($settings['styles']['header_bg_color']) ? $settings['styles']['header_bg_color'] : '#095E54',
                'header_text_color' => isset($settings['styles']['header_text_color']) ? $settings['styles']['header_text_color'] : '#ffffff',
                'body_bg_color' => isset($settings['styles']['body_bg_color']) ? $settings['styles']['body_bg_color'] : '#ffffff',
                'body_text_color' => isset($settings['styles']['body_text_color']) ? $settings['styles']['body_text_color'] : '#3FB122',
            )
        );    
    }

    public function dummyMembers()
    {
        return array(
            ['id'=>0, 'member_name'=>'Jessie Doe', 'member_designation'=>'Sales Expert', 'member_image_url' => NINJALIVECHAT_URL . 'public/images/chat/profile01.png', 'member_status'=>'online', 'member_number'=> '018342344234'],
            ['id'=>1, 'member_name'=>'John Doe', 'member_designation'=>'Technical Support', 'member_image_url'=> NINJALIVECHAT_URL . 'public/images/chat/profile02.png' , 'member_status'=>'online', 'member_number'=> '017342344234'],
            ['id'=>2, 'member_name'=>'John Done', 'member_designation'=>'Customer Support', 'member_image_url'=> NINJALIVECHAT_URL . 'public/images/chat/profile03.png' , 'member_status'=>'online', 'member_number'=> '019342344234'],
            ['id'=>3, 'member_name'=>'John Do', 'member_designation'=>'Marketing Expert', 'member_image_url'=> NINJALIVECHAT_URL . 'public/images/chat/profile04.png', 'member_status'=>'online', 'member_number'=> '016342344234'],
        );
    }
}