<?php
    // Prohibit direct script loading.
    defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

    // Activate hook
    global $wpdb;

    // create groups table 
    $sql_groups = 'CREATE TABLE IF NOT EXISTS `'. $wpdb->prefix.'smsgw_groups` (
        `group_id` int(11) NOT NULL auto_increment,
        `group_date` datetime NULL DEFAULT NULL,
        `group_name` varchar(120) NOT NULL,
        PRIMARY KEY  (`group_id`)
    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
    $wpdb->query($sql_groups);

    // create contacts table 
    $sql_contacts = 'CREATE TABLE IF NOT EXISTS `'. $wpdb->prefix.'smsgw_contacts` (
        `contact_id` int(11) NOT NULL auto_increment,
        `contact_date` datetime NULL DEFAULT NULL,
        `contact_name` varchar(120) NOT NULL,
        `contact_mobile` varchar(14) NOT NULL,
        `contact_group_id` int(11) NOT NULL default \'0\',
        PRIMARY KEY  (`contact_id`) ,
        KEY `contact_group_id` (`contact_group_id`)
    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
    $wpdb->query($sql_contacts);

    // create messages table 
    $sql_messages = 'CREATE TABLE IF NOT EXISTS `'. $wpdb->prefix.'smsgw_messages` (
        `msg_id` int(11) NOT NULL auto_increment,
        `msg_date` datetime NULL DEFAULT NULL,
        `msg_text` varchar(255) NOT NULL,
        `msg_status` int(1) NOT NULL default \'0\',
        PRIMARY KEY  (`msg_id`) 
    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
    $wpdb->query($sql_messages);

    // create send table 
    $sql_messages = 'CREATE TABLE IF NOT EXISTS `'. $wpdb->prefix.'smsgw_send` (
        `send_id` int(11) NOT NULL auto_increment,
        `send_date` datetime NULL DEFAULT NULL,
        `send_msg_id` int(11) NOT NULL,
        `send_group` int(11) NOT NULL,
        `send_mobile` varchar(14) NOT NULL,
        `send_status` int(1) NOT NULL default \'0\',
        PRIMARY KEY  (`send_id`),
        KEY `send_msg_id` (`send_msg_id`),
        KEY `send_group` (`send_group`)
    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
    $wpdb->query($sql_messages);

    // set default options
    if(get_option('smsgwnet_api_provider')  == '')  add_option('smsgwnet_api_provider', 'smsgwnet');
    if(get_option('smsgwnet_api_user')      == '')  add_option('smsgwnet_api_user',     'test');
    if(get_option('smsgwnet_api_pass')      == '')  add_option('smsgwnet_api_pass',     'test');
    if(get_option('smsgwnet_api_tag')       == '')  add_option('smsgwnet_api_tag',      'nb.sa');
    if(get_option('smsgwnet_credit')        == '')  add_option('smsgwnet_credit',       '0');
    if(get_option('smsgwnet_version')       == '')  add_option('smsgwnet_version',      SMSGW_VERSION);
    if(get_option('smsgwnet_db_version')    == '')  add_option('smsgwnet_db_version',   SMSGW_DB_VERSION);

?>