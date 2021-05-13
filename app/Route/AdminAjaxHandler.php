<?php

namespace NinjaWhatsapp\Route;
use NinjaWhatsapp\Model\WhatsappChat;

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
        add_action('wp_ajax_ninja_whatsappchat_admin_ajax', array($this, 'handeEndPoint'));
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
        $validRoutes = array(
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

        if (isset($validRoutes[$route])) {
            do_action('ninjawhatsappchat/doing_ajax_action_' . $route);
            return $this->{$validRoutes[$route]}();
        }
        do_action('ninjawhatsappchat/admin_ajax_handler_catch', $route);
    }

    public function getChatConfigs() 
    {
        $configs = get_option('ninja_whatsapp_chat_configs', array());
        $configs = (new WhatsappChat())->formatConfigs($configs);

        global $wpdb;
        $tablename = $wpdb->prefix . "ninja_chats";
        $allMembers = $wpdb->get_results("SELECT * FROM $tablename");

        if( empty($allMembers) ) {
            $allMembers = (new WhatsappChat())->dummyMembers();
        }
        
        wp_send_json_success([
            'configs'   => $configs,
            'members'   => $allMembers
        ]);
    }

    public function saveChatConfigs() 
    {
        $configs = json_decode( wp_unslash($_REQUEST['configs']), true);
        $configs = (new WhatsappChat())->formatConfigs($configs);
        update_option('ninja_whatsapp_chat_configs',$configs);
        wp_send_json_success([
            'message'   => __('Congrats, successfully saved!', 'ninjawhatsappchat'),
            'configs'   => $configs
        ]);
    }

    public static function getSettings()
    {
        $checked_pages = get_option('ninja_whatsappchat_checked_pages',array());

        $pages = get_pages();
        $page_list = array(array('page_id' => '-1', 'page_title' => __('All Pages', 'ninjawhatsappchat')));
        if (!empty($pages) && !is_wp_error($pages)) {
            foreach ($pages as $page) {
                $page_list[] = array('page_id' => $page->ID . '', 'page_title' => $page->post_title ? $page->post_title : __('Untitled', 'ninjawhatsappchat'));
            }
        }
        wp_send_json_success([
            'pages'   => $page_list,
            'checked_pages' => $checked_pages
        ]);
    }

    public function saveSettings()
    {
        $checked_pages = json_decode(wp_unslash($_REQUEST['checked_pages']), true);
        update_option('ninja_whatsappchat_checked_pages',$checked_pages);
        wp_send_json_success([
            'message'   => __('Congrats, successfully saved!', 'ninjawhatsappchat'),
            'checked_pages'   => $checked_pages
        ]);
    }

    public function clearConfigs()
    {
        delete_option('ninja_whatsapp_chat_configs');
        wp_send_json_success([
            'message'   => __('Congrats, successfully cleared!', 'ninjawhatsappchat')
        ]); 
    }

    public function validate($fields)
    {
        unset($fields['action']);
        unset($fields['route']);
        unset($fields['id']);

        $validator = array();
        unset($fields['file']);

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
        $member = $_REQUEST;
        $uploadedfile = isset( $_FILES['file'] ) ? $_FILES['file'] : null;
        
        $this->validate($member);

        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }

        $acceptedFilles = array(
            'image/png',
            'image/jpeg'
        );

        if (!in_array($uploadedfile['type'], $acceptedFilles)) {
            wp_send_json(__('Please upload only jpg/png format files', 'wpsocialreviews'), 423);
        }

        $upload_overrides = array('test_form' => false);

        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

        if ($movefile && !isset($movefile['error'])) {
            $member['member_image_url'] = $movefile['url'];
            unset($member['action']);
            unset($member['route']);
            global $wpdb;
            $tablename = $wpdb->prefix.'ninja_chats';
            $wpdb->insert( $tablename, $member );
            wp_send_json_success([
                'message'    => __('Member added successfully!', 'ninjawhatsappchat'),
                'member'    => $member,
            ],200);
        }
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
        ],200);
    }

    public function deleteMember()
    {
        $memberId = (int)$_REQUEST['member_id'];
        global $wpdb;
        $tablename = $wpdb->prefix . "ninja_chats";
        $wpdb->delete( $tablename, array( 'id' => $memberId ) );
        wp_send_json_success([
            'message'  => __('Member deleted successfully!', 'ninjawhatsappchat')
        ],200);
    }

    public function getMember()
    {
        $memberId = (int)$_REQUEST['member_id'];
        global $wpdb;
        $tablename = $wpdb->prefix . "ninja_chats";
        $member = $wpdb->get_row( "SELECT * FROM $tablename WHERE id = '$memberId'" );
        wp_send_json_success([
            'message'  => __('Success!', 'ninjawhatsappchat'),
            'member'   => $member
        ],200);
    }

    public function updateMember()
    {
        $member = $_REQUEST;
        $this->validate($member);
        
        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }
        $uploadedfile = isset($_FILES['file']) ? _FILES['file'] : null;

        if( !empty($uploadedfile) ) {
            $acceptedFilles = array(
                'image/png',
                'image/jpeg'
            );

            if (!in_array($uploadedfile['type'], $acceptedFilles)) {
                wp_send_json(__('Please upload only jpg/png format files', 'wpsocialreviews'), 423);
            }

            $upload_overrides = array('test_form' => false);

            $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

            if ($movefile && !isset($movefile['error'])) {
                $member['member_image_url'] = $movefile['url'];
            }
        }

        unset($member['file']);
        unset($member['action']);
        unset($member['route']);

        global $wpdb;
        $tablename = $wpdb->prefix.'ninja_chats';
        if( isset($member['id']) && !empty($member['id'])) {
            $memberId = $member['id'];
            unset($member['id']);
            $wpdb->update( $tablename, $member,  array( 'id' => $memberId ) );
            wp_send_json_success([
                'message'    => __('Member updated successfully!', 'ninjawhatsappchat'),
                'member'    => $member,
            ],200);
        }
    }

    public function duplicateMember()
    {
        $member = json_decode( wp_unslash($_REQUEST['member']), true);
        global $wpdb;
        $tablename = $wpdb->prefix.'ninja_chats';
        unset($member['id']);
        $wpdb->insert( $tablename, $member );
        wp_send_json_success([
            'message'    => __('Member duplicated successfully!', 'ninjawhatsappchat')
        ],200);
    } 
}