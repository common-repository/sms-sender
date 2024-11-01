<?php
    // Prohibit direct script loading.
    defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

    //index function
    function smsgwnet_contacts_index() {
        global $wpdb;
        $return = [];

        global $wpdb;
        $return = [];
        $sql    = 'SELECT *  FROM `'.$wpdb->prefix.'smsgw_contacts`';
        $return['contacts'] = $wpdb->get_results($sql);
        return $return;
    }

    //show function
    function smsgwnet_contacts_show() {
        global $wpdb;
        $return = [];

        $id     = intval((isset($_REQUEST['id']))?$_REQUEST['id']:0);
        $sql    = 'SELECT *  FROM `'.$wpdb->prefix.'smsgw_contacts` WHERE contact_group_id = %d';
        $return['contacts'] = $wpdb->get_results($wpdb->prepare($sql, $id));

        return $return;
    }

    //add function
    function smsgwnet_contacts_add() {
        global $wpdb;
        $return = [];

        if(isset($_POST['contact_name'])  && isset($_POST['contact_mobile'])) {
            $wpdb->query($wpdb->prepare('
                    INSERT INTO ' . $wpdb->prefix.'smsgw_contacts 
                    (contact_date, contact_group_id, contact_name, contact_mobile) 
                    VALUES (%s, %d, %s, %s)', array(
                        date('Y-m-d H:i:s'),
                        $_POST['contact_group_id'], 
                        sanitize_text_field($_POST['contact_name']),
                        sanitize_text_field($_POST['contact_mobile'])
                    )));

            Smsgwnet::print_message('Contact has been added');
        }
        $sql = 'SELECT COUNT(contact_group_id) as count, `'.$wpdb->prefix.'smsgw_groups`.*  
                FROM `'.$wpdb->prefix.'smsgw_groups`
                LEFT JOIN `'.$wpdb->prefix.'smsgw_contacts` ON contact_group_id=group_id
                GROUP BY group_id';
        $return['groups'] = $wpdb->get_results($sql);

        return $return;
    }

    //edit function
    function smsgwnet_contacts_edit() {
        global $wpdb;
        $return = [];

        $id     = intval((isset($_REQUEST['id']))?$_REQUEST['id']:0);
        if(isset($_POST['contact_name'])  && isset($_POST['contact_name'])) {
            $wpdb->query($wpdb->prepare('
                    UPDATE ' . $wpdb->prefix.'smsgw_contacts SET 
                    contact_group_id = %d, contact_name = %s, contact_mobile = %s
                    WHERE contact_id = %d', array(
                        $_POST['contact_group_id'], 
                        sanitize_text_field($_POST['contact_name']),
                        sanitize_text_field($_POST['contact_mobile']), 
                        $id)
                    ));
            Smsgwnet::print_message( __('Contact has been updated', 'smsgwnet') );
        }
        $return['contact'] = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'smsgw_contacts WHERE contact_id = %d', $id));

        $sql = 'SELECT COUNT(contact_group_id) as count, `'.$wpdb->prefix.'smsgw_groups`.*  
                FROM `'.$wpdb->prefix.'smsgw_groups`
                LEFT JOIN `'.$wpdb->prefix.'smsgw_contacts` ON contact_group_id=group_id
                GROUP BY group_id';
        $return['groups'] = $wpdb->get_results($sql);

        return $return;
    }

    //delete function
    function smsgwnet_contacts_delete() {
        global $wpdb;
        $return = [];

        $id     = intval((isset($_REQUEST['id']))?$_REQUEST['id']:0);
        $wpdb->delete($wpdb->prefix.'smsgw_contacts', array( 'contact_id' => $id ));
        Smsgwnet::print_message( __('Contact has been deleted', 'smsgwnet') );

        return $return;
    }

?>