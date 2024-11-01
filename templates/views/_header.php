<?php
    // register scripts
    wp_register_script('smsgw_script', plugins_url('templates/js/smsgw.js', SMSGW_FILE));
    wp_enqueue_script('smsgw_script');
    wp_register_script('sumoselect', plugins_url('templates/js/jquery.multiple.select.js', SMSGW_FILE));
    wp_enqueue_script('sumoselect');
    // register style
    wp_register_style('smsgw_style', plugins_url('templates/css/smsgw.css', SMSGW_FILE));
    wp_enqueue_style('smsgw_style');
    wp_register_style('sumoselect', plugins_url('templates/css/multiple-select.css', SMSGW_FILE));
    wp_enqueue_style('sumoselect');
?>
<div class="wrap">
    <h3 class="nav-tab-wrapper">
    <a href="admin.php?page=sms-gw" class="nav-tab <?php echo (($_GET['action']=='' || $_GET['action']=='send')?'nav-tab-active':'')?> "><?php _e('Send SMS', 'smsgwnet')?></a>
    <a href="admin.php?page=sms-gw&action=messages" class="nav-tab <?php echo (($_GET['action']=='messages')?'nav-tab-active':'')?> "><?php _e('Messages', 'smsgwnet')?></a>
    <a href="admin.php?page=sms-gw&action=contacts" class="nav-tab <?php echo (($_GET['action']=='contacts')?'nav-tab-active':'')?> "><?php _e('Contacts', 'smsgwnet')?></a>
    <a href="admin.php?page=sms-gw&action=groups" class="nav-tab <?php echo (($_GET['action']=='groups')?'nav-tab-active':'')?> "><?php _e('Groups', 'smsgwnet')?></a>
    <a href="admin.php?page=sms-gw&action=options" class="nav-tab <?php echo (($_GET['action']=='options')?'nav-tab-active':'')?> "><?php _e('Options', 'smsgwnet')?></a>
</h3>
<div id="topmessage"><?php echo Smsgwnet::print_message() ?></div>
