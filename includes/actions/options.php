<?php
    // Prohibit direct script loading.
    defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

    //index function
    function smsgwnet_options_index() {
        global $wpdb;
        $return = [];
        if(isset($_POST['smsgwnet_api_provider']) && isset($_POST['smsgwnet_api_user']) && isset($_POST['smsgwnet_api_pass']) && isset($_POST['smsgwnet_api_tag'])) {
            update_option('smsgwnet_api_provider',   sanitize_text_field($_POST['smsgwnet_api_provider']));
            update_option('smsgwnet_api_user',      sanitize_text_field($_POST['smsgwnet_api_user']));
            update_option('smsgwnet_api_pass',      sanitize_text_field($_POST['smsgwnet_api_pass']));
            update_option('smsgwnet_api_tag',       sanitize_text_field($_POST['smsgwnet_api_tag']));
            $message = __('Options has been saved', 'smsgwnet');
            Smsgwnet::print_message($message);
            Smsgwnet::getBalance();
        }

        $return['providers_list'] = Smsgwnet::getProvidersList();
        return $return;
    }
?>