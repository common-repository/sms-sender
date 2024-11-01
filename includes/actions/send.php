<?php
    // Prohibit direct script loading.
    defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

    //index function
    function smsgwnet_send_index() {
        global $wpdb;
        $return = [];
        if(isset($_POST['sms-message'])) {
            if(isset($_POST['groups']) || isset($_POST['contacts'])) {
                $msg_id = Smsgwnet::saveSMS(sanitize_text_field($_POST['sms-message']));
                if(isset($_POST['groups']) && is_array($_POST['groups']) && count($_POST['groups'])>0) {
                    $groups = Smsgwnet::saveSMSgroups($msg_id, $_POST['groups']);
                }
                if(isset($_POST['contacts']) && is_array($_POST['contacts']) && count($_POST['contacts'])>0) {
                    $contacts = Smsgwnet::saveSMScontacts($msg_id, $_POST['contacts']);
                }
                if($groups>0 || $contacts>0) {
                    Smsgwnet::sendSMS($msg_id);
                }
            }
        }

        // get all groups
        $sql = 'SELECT COUNT(contact_group_id) as count, `'.$wpdb->prefix.'smsgw_groups`.*  
                FROM `'.$wpdb->prefix.'smsgw_groups`
                LEFT JOIN `'.$wpdb->prefix.'smsgw_contacts` ON contact_group_id=group_id
                GROUP BY group_id';
        $rows = $wpdb->get_results($sql);
        foreach ($rows as $row) {
            $return['groups'][] = $row;
        }

        // get all contacts
        $sql = 'SELECT *  FROM `'.$wpdb->prefix.'smsgw_contacts` LIMIT 1000';
        $rows = $wpdb->get_results($sql);
        foreach ($rows as $row) {
            $return['contacts'][] = $row;
        }
        return $return;
    }
?>