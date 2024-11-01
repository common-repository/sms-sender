<?php
    // Prohibit direct script loading.
    defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

    //index function
    function smsgwnet_messages_index() {
        global $wpdb;
        $return = [];

        $sql = 'SELECT COUNT(send_id) as count, `'.$wpdb->prefix.'smsgw_messages`.*  
                FROM `'.$wpdb->prefix.'smsgw_messages`
                LEFT JOIN `'.$wpdb->prefix.'smsgw_send` ON send_msg_id=msg_id
                GROUP BY msg_id';
        $return['messages'] = $wpdb->get_results($sql);

        return $return;
    }

    //show function
    function smsgwnet_messages_show() {
        global $wpdb;
        $return = [];

        $id  = intval((isset($_REQUEST['id']))?$_REQUEST['id']:0);
        $sql = 'SELECT COUNT(send_id) as count, `'.$wpdb->prefix.'smsgw_messages`.*  
                FROM `'.$wpdb->prefix.'smsgw_messages`
                LEFT JOIN `'.$wpdb->prefix.'smsgw_send` ON send_msg_id=msg_id
                WHERE msg_id = %d
                GROUP BY msg_id';
        $return['message'] = $wpdb->get_row($wpdb->prepare($sql, $id));
        if($return['message']) {
            $sql                = 'SELECT * FROM `'.$wpdb->prefix.'smsgw_send` WHERE send_msg_id= %d GROUP BY send_id';
            $sql                = $wpdb->prepare($sql, $id);
            $return['sends']    = $wpdb->get_results($sql);
        }

        return $return;
    }

    //delete function
    function smsgwnet_messages_delete() {
        global $wpdb;
        $return = [];

        $id = intval((isset($_REQUEST['id']))?$_REQUEST['id']:0);
        $wpdb->delete($wpdb->prefix.'smsgw_messages', array( 'msg_id' => $id ));
        $wpdb->delete($wpdb->prefix.'smsgw_send', array( 'send_msg_id' => $id ));
        Smsgwnet::print_message( __('Messages has been deleted', 'smsgwnet') );

        return $return;
    }

?>