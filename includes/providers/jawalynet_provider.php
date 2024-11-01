<?php
/**
 * 4jawaly.net API Class
 *
 * connect to 4jawaly.net API.
 *
 * @class       JawalynetProvider
 * @version     0.1
 * @author      smsgw.net
 */

class JawalynetProvider implements ProviderInterface{

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
        $api_url = 'http://www.4jawaly.net/api/sendsms.php';
        $post = [
                'username'      => get_option('smsgwnet_api_user'), 
                'password'      => get_option('smsgwnet_api_pass'), 
                'sender'        => get_option('smsgwnet_api_tag'),  
                'numbers'       => implode(',', $mobiles),
                'message'       => $message,
                'return'        => 'string',
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
        $api_url = 'http://www.4jawaly.net/api/getbalance.php';
        $post = [
                'username'  => get_option('smsgwnet_api_user'), 
                'password'  => get_option('smsgwnet_api_pass'), 
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