<?php

namespace NinjaLive\Route;
use NinjaLive\Model\LiveChat;

if (!defined('ABSPATH')) {
    exit;
}

class AdminAjaxHandler
{
    /**
     *
     * Register end points
     *
     * @since 1.0.0
     *
     **/
    public function registerEndpoints()
    {
        add_action('wp_ajax_ninja_livechat_admin_ajax', array($this, 'handeEndPoint'));
    }

    /**
     *
     * validate route
     *
     * @return method name
     * @since 1.0.0
     *
     **/
    public function handeEndPoint()
    {
        $route = sanitize_text_field($_REQUEST['route']);
        $routes = array(
            //chat configs
            'get_chat_configs'  => 'getChatConfigs',
            'save_chat_configs' => 'saveChatConfigs',

            //settings configs
            'get_settings'  => 'getSettings',
            'save_settings' => 'saveSettings',
            'clear_configs' => 'clearConfigs',
            
            //member
            'add_member'    => 'addMember',
            'all_members'   => 'allMembers',
            'delete_member' => 'deleteMember',
            'get_member'    => 'getMember',
            'update_member' => 'updateMember',
            'duplicate_member' => 'duplicateMember'
        );

        if (isset($routes[$route])) {
            return $this->{$routes[$route]}();
        }
    }

    public function getChatConfigs() 
    {
        $chatConfigs = get_option('ninja_live_chat_configs', array());
        $chatConfigs = (new LiveChat())->formatConfigs($chatConfigs);

        global $wpdb;
        $tablename = $wpdb->prefix . "ninja_chats";
        $allMembers = $wpdb->get_results("SELECT * FROM $tablename");

        if( empty($allMembers) ) {
            $allMembers = (new LiveChat())->dummyMembers();
        }
        wp_send_json_success([
            'configs'   => $chatConfigs,
            'members'   => $allMembers
        ], 200);
    }

    public function saveChatConfigs() 
    {
        $chatConfigsJson = sanitize_text_field($_REQUEST['configs']);
        $chatConfigs = json_decode( wp_unslash($chatConfigsJson), true);
        $chatConfigs = (new LiveChat())->formatConfigs($chatConfigs);
        update_option('ninja_live_chat_configs',$chatConfigs);
        wp_send_json_success([
            'message'   => __('Congrats, successfully saved!', 'ninjalivechat'),
            'configs'   => $configs
        ], 200);
    }

    public static function getSettings()
    {
        $checked_pages = get_option('ninja_livechat_checked_pages',array());

        $pages = get_pages();
        $page_list = array(array('page_id' => '-1', 'page_title' => __('All Pages', 'ninjalivechat')));
        if (!empty($pages) && !is_wp_error($pages)) {
            foreach ($pages as $page) {
                $page_list[] = array('page_id' => $page->ID . '', 'page_title' => $page->post_title ? $page->post_title : __('Untitled', 'ninjalivechat'));
            }
        }
        wp_send_json_success([
            'pages'   => $page_list,
            'checked_pages' => $checked_pages
        ], 200);
    }

    public function saveSettings()
    {
        $checkedPagesJson = sanitize_text_field($_REQUEST['checked_pages']);
        $checkedPages = json_decode(wp_unslash($checkedPagesJson), true);
        update_option('ninja_livechat_checked_pages',$checkedPages);
        wp_send_json_success([
            'message'   => __('Congrats, successfully saved!', 'ninjalivechat'),
            'checked_pages'   => $checkedPages
        ], 200);
    }

    public function clearConfigs()
    {
        delete_option('ninja_live_chat_configs');
        wp_send_json_success([
            'message'   => __('Congrats, successfully cleared!', 'ninjalivechat')
        ], 200); 
    }

    public function validate($fields)
    {
        unset($fields['id']);
        unset($fields['member_image_url']);

        $validator = array();
        foreach($fields as $key => $field) {
            if( empty($field) ) {
                $validator[$key] = ucfirst(str_replace('member_','',$key)). ' field is required';
            }
        }

        if( !empty($validator) ) {
            wp_send_json_error($validator,423);
        }
    }

    public function addMember() 
    {  
        $member = sanitize_text_field($_REQUEST['member']);
        $member = json_decode(wp_unslash($member), true);
        $this->validate($member);
        global $wpdb;
        $tablename = $wpdb->prefix.'ninja_chats';
        $wpdb->insert( $tablename, $member );
        wp_send_json_success([
            'message'    => __('Member added successfully!', 'ninjalivechat'),
            'member'    => $member,
        ], 200);
    }

    public function allMembers()
    {
        $perPage = intval($_REQUEST['per_page']);
        $pageNumber = intval($_REQUEST['page_number']);
        $searchString = sanitize_text_field($_REQUEST['search_string']);
        $OFFSET = ($pageNumber-1)*$perPage;
        global $wpdb;
        $tablename = $wpdb->prefix . "ninja_chats";
        $totalMembers = count($wpdb->get_results("SELECT * FROM $tablename WHERE member_name LIKE '%$searchString%' OR member_status LIKE '%$searchString%' OR member_number LIKE '%$searchString%' OR member_designation LIKE '%$searchString%'"));
        $allMembers = $wpdb->get_results("SELECT * FROM $tablename WHERE member_name LIKE '%$searchString%' OR member_status LIKE '%$searchString%' OR member_number LIKE '%$searchString%' OR member_designation LIKE '%$searchString%' ORDER BY ID DESC LIMIT $perPage OFFSET $OFFSET ");
        wp_send_json_success([
            'all_members'  => $allMembers,
            'total' => $totalMembers
        ], 200);
    }

    public function deleteMember()
    {
        $memberId = (int)$_REQUEST['member_id'];
        global $wpdb;
        $tablename = $wpdb->prefix . "ninja_chats";
        $wpdb->delete( $tablename, array( 'id' => $memberId ) );
        wp_send_json_success([
            'message'  => __('Member deleted successfully!', 'ninjalivechat')
        ], 200);
    }

    public function getMember()
    {
        $memberId = (int)$_REQUEST['member_id'];
        global $wpdb;
        $tablename = $wpdb->prefix . "ninja_chats";
        $member = $wpdb->get_row( "SELECT * FROM $tablename WHERE id = '$memberId'" );
        wp_send_json_success([
            'message'  => __('Success!', 'ninjalivechat'),
            'member'   => $member
        ], 200);
    }

    public function updateMember()
    {
        $member = sanitize_text_field($_REQUEST['member']);   
        $member = json_decode( wp_unslash($member), true);

        if( isset($member['id']) && !empty($member['id'])) {
            $memberId = (int)$member['id'];
            unset($member['created_at']);
            unset($member['updated_at']);

            $this->validate($member);

            global $wpdb;
            $tablename = $wpdb->prefix.'ninja_chats';
            $wpdb->update( $tablename, $member,  array( 'id' => $memberId ) );
            wp_send_json_success([
                'message'    => __('Member updated successfully!', 'ninjalivechat'),
                'member'    => $member,
            ], 200);
        }
    }

    public function duplicateMember()
    {
        $member = sanitize_text_field($_REQUEST['member']);
        $member = json_decode( wp_unslash($member), true);
        global $wpdb;
        $tablename = $wpdb->prefix.'ninja_chats';
        unset($member['id']);
        $wpdb->insert( $tablename, $member );
        wp_send_json_success([
            'message'    => __('Member duplicated successfully!', 'ninjalivechat')
        ], 200);
    } 
}