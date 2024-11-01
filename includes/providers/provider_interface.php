<?php
/**
 * ProviderInterface
 *
 * use this interface to create new SMS provider class 
 *
 * @class       ProviderInterface
 * @version     0.1
 * @author      smsgw.net
 */

interface ProviderInterface
{
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
    public static function SendSMS($mobiles, $message);

    /**
     * GetBalance function.
     *
     * return user account balance.
     *
     * @access public
     * @return integer
     */
    public static function GetBalance();
}

?>