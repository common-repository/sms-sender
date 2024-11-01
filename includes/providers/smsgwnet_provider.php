<?php
/**
 * smsgw.net API Class
 *
 * connect to smsgw.net API.
 *
 * @class       SmsgwnetProvider
 * @version     0.1
 * @author      smsgw.net
 */

class SmsgwnetProvider implements ProviderInterface{

    /**
     * SendSMS function.
     *
     * send sms to mobile list using sms gateway and return 1 on success or error message on fail.
     *
     * @access public
     * @param array $mobiles
     * @param string $messages
     * @return mixed
     */
    public static function SendSMS($mobiles, $message) {
        $api_url = 'http://api.smsgw.net/SendBulkSMS';
        $post = [
                'strUserName'           => get_option('smsgwnet_api_user'), 
                'strPassword'           => get_option('smsgwnet_api_pass'), 
                'strTagName'            => get_option('smsgwnet_api_tag'),  
                'strRecepientNumbers'   => implode(';', $mobiles), 
                'strMessage'            => $message, 
                'sendDateTime'          => '0', 
            ];
        $response = wp_remote_post( $api_url, array('timeout' => 20, 'body' => $post) );
        if ( is_wp_error( $response ) ) {
            return($response->get_error_message());
        } else {
            return($response['body']);
        }
    }

    /**
     * GetBalance function.
     *
     * return user account balance.
     *
     * @access public
     * @return integer
     */
    public static function GetBalance() {
        $api_url = 'http://api.smsgw.net/GetCredit';
        $post = [
                'strUserName'           => get_option('smsgwnet_api_user'), 
                'strPassword'           => get_option('smsgwnet_api_pass'), 
            ];
        $response = wp_remote_post( $api_url, array('timeout' => 20, 'body' => $post) );
        if ( is_wp_error( $response ) ) {
            return($response->get_error_message());
        } else {
            return($response['body']);
        }
    }

}

?>