<?php
/**
 * resalty.net API Class
 *
 * connect to resalty.net API.
 *
 * @class       ResaltynetProvider
 * @version     0.1
 * @author      smsgw.net
 */

class ResaltynetProvider implements ProviderInterface{

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
        $api_url = 'http://www.resalty.net/api/sendSMS.php';
        $post = [
                'userid'    => get_option('smsgwnet_api_user'), 
                'password'  => get_option('smsgwnet_api_pass'), 
                'sender'    => get_option('smsgwnet_api_tag'),  
                'to'        => implode(',', $mobiles), 
                'msg'       => $message, 
                'encoding'  => 'utf-8',
            ];
        $response = wp_remote_post( $api_url, array('timeout' => 20, 'body' => $post) );
        if ( is_wp_error( $response ) ) {
            return($response->get_error_message());
        } else {
            if(preg_match('/MessageID/i', $response['body'])) {
                return('1');
            }
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
        $api_url = 'http://www.resalty.net/api/getBalance.php';
        $post = [
                'userid'    => get_option('smsgwnet_api_user'), 
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