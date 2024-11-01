<?php

/**
 * @package Smsgwnet
 * @version 0.8
 */

/**
 * Plugin Name: SMS Sender
 * Plugin URI:  http://smsgw.net/wordpress
 * Description: Send SMS using <a href="http://smsgw.net/">SMSgw.net</a> as main provider and others providers like <a href="http://mobily.ws/">Mobily.ws</a>, <a href="http://4jawaly.net/">4jawaly.net</a>, <a href="http://malath.net.sa/">malath.net.sa</a>, <a href="http://resalty.net/">resalty.net</a> and <a href="http://ashharsms.com/">AshharSMS.com</a>.
 * Author:      Daif Alotaibi
 * Author URI:  http://daif.net/
 * Version:     0.8
 * Text Domain: smsgwnet
 * Domain Path: /languages/
 */

// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

// define plug-in constants
define( 'SMSGW_VERSION',        '0.8' );
define( 'SMSGW_DB_VERSION',     '0.3' );
define( 'SMSGW_FILE',           __FILE__ );
define( 'SMSGW_PATH',           dirname( SMSGW_FILE ));

class Smsgwnet {
    //Construct the plugin object
    public static function init() {
        if ( ! session_id() ) {
            session_start();
        }
        // Register activation , deactivation and uninstall hooks
        register_activation_hook( __FILE__,     [get_called_class(), 'activate']);
        register_deactivation_hook( __FILE__,   [get_called_class(), 'deactivate']);
        register_uninstall_hook( __FILE__,      [get_called_class(), 'uninstall']);
        // register admin_menu action
        add_action( 'admin_menu',               [get_called_class(), 'plugin_menu'] );
        add_action( 'plugins_loaded',           [get_called_class(), 'load_textdomain'] );
    }

    //Activate the plugin
    public static function activate()
    {
        include( dirname( __FILE__ ) . '/includes/hooks/activation.php' );
    }

    // Deactivate the plugin    
    public static function deactivate()
    {
        include( dirname( __FILE__ ) . '/includes/hooks/deactivate.php' );
    }

    // Uninstall the plugin    
    public static function uninstall()
    {
        include( dirname( __FILE__ ) . '/includes/hooks/uninstall.php' );
    }

    //plugin_menu 
    public static function plugin_menu()
    {
        if (is_admin())
        {
            add_menu_page('SMSgw.net', 'SMSgw.net', 'manage_options', 'sms-gw', [ get_called_class(), 'plugin_main'] , 'dashicons-email');
        }
    }

    //load_textdomain 
    public static function load_textdomain()
    {
        load_plugin_textdomain( 'smsgwnet', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    //plugin_main
    public static function plugin_main()
    {
        global $wpdb;
        //$wpdb->show_errors();
        // defined all actions file
        $actions = [
            'send'      => 'includes/actions/send.php',
            'messages'  => 'includes/actions/messages.php',
            'contacts'  => 'includes/actions/contacts.php',
            'groups'    => 'includes/actions/groups.php',
            'options'   => 'includes/actions/options.php',
        ];
        // set default action if action is not set or is not existed in actions array 
        if(!isset($_GET['action']) || !isset($actions[strtolower($_GET['action'])])) {
            $_GET['action'] = 'send';
        }
        // set default do if do is not set
        if(!isset($_GET['do'])) {
            $_GET['do'] = 'index';
        }
        // include the action file
        include( dirname( __FILE__ ) . '/'.$actions[strtolower($_GET['action'])] );
        // if action_index function is existed
        if(function_exists('smsgwnet_'.strtolower($_GET['action']).'_'.strtolower($_GET['do']))) {
            call_user_func_array(function () {
                $return = call_user_func_array('smsgwnet_'.strtolower($_GET['action']).'_'.strtolower($_GET['do']), []);
                extract($return);
                // include action header if it existed or include _header.php
                if( file_exists(dirname( __FILE__ ) . '/templates/views/'.strtolower($_GET['action']).'_header.php') ) {
                    include( dirname( __FILE__ ) . '/templates/views/'.strtolower($_GET['action']).'_header.php' );
                } else {
                    include( dirname( __FILE__ ) . '/templates/views/_header.php' );
                }
                // include action view file action_do.php if is existed or action_index.php
                if( file_exists(dirname( __FILE__ ) . '/templates/views/'.strtolower($_GET['action']).'_'.strtolower($_GET['do']).'.php') ) {
                    include( dirname( __FILE__ ) . '/templates/views/'.strtolower($_GET['action']).'_'.strtolower($_GET['do']).'.php' );
                } else {
                    include( dirname( __FILE__ ) . '/templates/views/'.strtolower($_GET['action']).'_index.php' );
                }
                // include action footer if it existed or include _footer.php
                if( file_exists(dirname( __FILE__ ) . '/templates/views/'.strtolower($_GET['action']).'_footer.php') ) {
                    include( dirname( __FILE__ ) . '/templates/views/'.strtolower($_GET['action']).'_footer.php' );
                } else {
                    include( dirname( __FILE__ ) . '/templates/views/_footer.php' );
                }
            }, []);
        } else {
            
        }
    }

    // function to set/print updated message or error message
    public static function print_message($message='', $class='updated') {
        if($message == '') {
            $return = '';
            if(isset($_SESSION['smsgw_messages'])) {
                foreach ($_SESSION['smsgw_messages'] as $key => $message) {
                    $return .= '<div class="'.$message['class'].'"><p>'.$message['message'].'.</p></div>';
                }
            }
            $_SESSION['smsgw_messages'] = [];
            return $return;
        } else {
            $_SESSION['smsgw_messages'][] = ['class'=>$class, 'message'=>$message];
        }
    }

    // function to save sms message
    public static function saveSMS($msg_text) {
        global $wpdb;
            $wpdb->query($wpdb->prepare('
                    INSERT INTO ' . $wpdb->prefix.'smsgw_messages 
                    (msg_date, msg_text) 
                    VALUES (%s, %s)', array(
                        date('Y-m-d H:i:s'),
                        sanitize_text_field($msg_text)
                    )));
        return($wpdb->insert_id);
    }

    // function to save sms message
    public static function saveSMSgroups($msg_id, $groups) {
        global $wpdb;
        $count=0;
        foreach ($groups as $group_id) {
            $group_id   = intval($group_id);
            $sql        = 'SELECT *  FROM `'.$wpdb->prefix.'smsgw_contacts` WHERE contact_group_id=%d';
            $contacts   = $wpdb->get_results($wpdb->prepare($sql, $group_id));
            foreach ($contacts as $contact) {
                $wpdb->query($wpdb->prepare('
                        INSERT INTO ' . $wpdb->prefix.'smsgw_send 
                        (send_date, send_msg_id, send_group, send_mobile) 
                        VALUES (%s, %d, %d, %s)', array(
                            date('Y-m-d H:i:s'), 
                            $msg_id, 
                            $group_id, 
                            sanitize_text_field($contact->contact_mobile)
                        )));
                $count++;
            }
        }
        return($count);
    }

    // function to save sms message
    public static function saveSMScontacts($msg_id, $contacts) {
        global $wpdb;
        $count = 0;
        foreach ($contacts as $contact_id) {
            $contact_id = intval($contact_id);
            $sql        = 'SELECT *  FROM `'.$wpdb->prefix.'smsgw_contacts` WHERE contact_id=%d';
            $contacts   = $wpdb->get_results($wpdb->prepare($sql, $contact_id));
            foreach ($contacts as $contact) {
                $wpdb->query($wpdb->prepare('
                        INSERT INTO ' . $wpdb->prefix.'smsgw_send 
                        (send_date, send_msg_id, send_group, send_mobile) 
                        VALUES (%s, %d, %d, %s)', array(
                            date('Y-m-d H:i:s'),
                            $msg_id, 
                            $group_id, 
                            sanitize_text_field($contact->contact_mobile)
                        )));
                $count++;
            }
        }
        return($count);
    }

    // function to send saved message
    public static function sendSMS($send_id) {
        global $wpdb;
        $message    = $wpdb->get_row($wpdb->prepare('SELECT * FROM `'.$wpdb->prefix.'smsgw_messages` WHERE msg_id = %d AND msg_status=0', $send_id));
        if($message) {
            $sql    = 'SELECT *  FROM `'.$wpdb->prefix.'smsgw_send` WHERE send_msg_id=%d AND send_status=0';
            $rows   = $wpdb->get_results($wpdb->prepare($sql, $send_id));
            foreach ($rows as $row) {
                $sms_mobile[] = Smsgwnet::fixMobile($row->send_mobile);
            } 
        }

        $api_class  = Smsgwnet::loadProviderClass();
        $return     = $api_class->SendSMS($sms_mobile, $message->msg_text);

        if($return  == 1) {
            //update mobile send status
            $wpdb->query($wpdb->prepare('
                    UPDATE ' . $wpdb->prefix.'smsgw_send SET 
                    send_status = 1
                    WHERE send_msg_id = %d', array(
                        $send_id
                    )));
            $message =  'Message has been sent';
            //update message status
            $wpdb->query($wpdb->prepare('
                    UPDATE ' . $wpdb->prefix.'smsgw_messages SET 
                    msg_status = 1
                    WHERE msg_id = %d', array(
                        $send_id
                    )));
        } else {
            $message =  "Error: ".$return;
        }

        Smsgwnet::getBalance();
        Smsgwnet::print_message($message);
    }

    //function to update Credit count
    public static function getBalance() {
        $api_class  = Smsgwnet::loadProviderClass();
        $balance    = $api_class->GetBalance();
        if($balance == '0' || $balance >= 1) {
            update_option('smsgwnet_credit', $balance);
        } else {
            update_option('smsgwnet_credit', '0');
            Smsgwnet::print_message('Provider Error: '.sanitize_text_field($balance), 'error');
        }
        return(get_option('smsgwnet_credit'));
    }

    //function to list all providers class
    public static function getProvidersList() {
        $dir    = SMSGW_PATH . '/includes/providers/';
        $list   = [];
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if(filetype($dir . $file) == 'file' && preg_match('/_provider\.php/i', $file)) {
                    $list[] =  str_replace('_provider.php', '', $file);
                }
            }
        }
        return $list;
    }

    //function to load api class and create instance
    public static function loadProviderClass() {
        $file       = SMSGW_PATH . '/includes/providers/'.get_option('smsgwnet_api_provider').'_provider.php';
        $api_class  = ucfirst(strtolower(get_option('smsgwnet_api_provider'))).'Provider';
        if(file_exists($file)) {
            require_once( SMSGW_PATH . '/includes/providers/provider_interface.php');
            require_once( $file );
            if(class_exists($api_class)) {
                $api_class = new $api_class;
                return($api_class);
            }
            Smsgwnet::print_message('Error: Provider Class <b>'.$api_class.'</b> is not found', 'error');
        } else {
            Smsgwnet::print_message('Error: Provider class file is not found, '.$file, 'error');
        }
    }
    
    //function to trim and fix mobile number
    public static function fixMobile($mobile, $country_code='966') {
        $mobile = explode(',', $mobile);
        foreach ($mobile as $mob) {
            $mob = preg_replace('/[^0-9+]/','',trim($mob));
            if(preg_match('/^([0-9]{9})/',$mob)) {
                // append country code
                if(preg_match('/^(05|5)/',$mob) && preg_match('/^([0-9]{9,10})/',$mob)) {
                    $mob = $country_code.preg_replace('/^(0)/', '', $mob);
                }
                $mobile_list[] = $mob;
            }
        }
        return implode(',', $mobile_list);
    }

}

if ( is_admin() ) {
    //call the class
    Smsgwnet::init();
}

?>