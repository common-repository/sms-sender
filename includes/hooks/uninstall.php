<?php
    // Prohibit direct script loading.
    defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
    // UnInstall hook
    global $wpdb;

    //drop tables
    $wpdb->query('DROP TABLE IF EXISTS `'. $wpdb->prefix.'smsgw_groups`');
    $wpdb->query('DROP TABLE IF EXISTS `'. $wpdb->prefix.'smsgw_contacts`');
    $wpdb->query('DROP TABLE IF EXISTS `'. $wpdb->prefix.'smsgw_messages`');
    $wpdb->query('DROP TABLE IF EXISTS `'. $wpdb->prefix.'smsgw_send`');

    //delete options
    delete_option('smsgwnet_api_provider');
    delete_option('smsgwnet_api_user');
    delete_option('smsgwnet_api_pass');
    delete_option('smsgwnet_api_tag');
    delete_option('smsgwnet_credit');
    delete_option('smsgwnet_version');
    delete_option('smsgwnet_db_version');
?>