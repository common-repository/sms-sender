<?php
    // Prohibit direct script loading.
    defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

    //index function
    function smsgwnet_groups_index() {
        global $wpdb;
        $return = [];

        $sql = 'SELECT COUNT(contact_group_id) as count, `'.$wpdb->prefix.'smsgw_groups`.*  
                FROM `'.$wpdb->prefix.'smsgw_groups`
                LEFT JOIN `'.$wpdb->prefix.'smsgw_contacts` ON contact_group_id=group_id
                GROUP BY group_id';
        $return['groups'] = $wpdb->get_results($sql);

        return $return;
    }

    //add function
    function smsgwnet_groups_add() {
        global $wpdb;
        $return = [];

        if(isset($_POST['group_name'])) {
            $wpdb->query($wpdb->prepare('
                    INSERT INTO ' . $wpdb->prefix.'smsgw_groups 
                    (group_date, group_name) 
                    VALUES (%s, %s)', array(
                        date('Y-m-d H:i:s'),
                        sanitize_text_field($_POST['group_name'])
                    )));
            Smsgwnet::print_message( __('Group has been added', 'smsgwnet') );
        }

        return $return;
    }

    //edit function
    function smsgwnet_groups_edit() {
        global $wpdb;
        $return = [];

        $id     = intval((isset($_REQUEST['id']))?$_REQUEST['id']:0);
        if(isset($_POST['group_name'])) {
            $wpdb->query($wpdb->prepare('
                    UPDATE ' . $wpdb->prefix.'smsgw_groups SET 
                    group_name = %s
                    WHERE group_id = %d', array(
                        sanitize_text_field($_POST['group_name']),
                        $id) 
                    ));
            Smsgwnet::print_message( __('Group has been updated', 'smsgwnet') );
        }
        $return['group'] = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'smsgw_groups WHERE group_id = %d', $id));

        return $return;
    }

    //delete function
    function smsgwnet_groups_delete() {
        global $wpdb;
        $return = [];

        $id     = intval((isset($_REQUEST['id']))?$_REQUEST['id']:0);
        $wpdb->delete($wpdb->prefix.'smsgw_groups', array( 'group_id' => $id ));
        Smsgwnet::print_message( __('Group has been deleted', 'smsgwnet') );

        return $return;
    }

?>