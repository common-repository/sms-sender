            <p><?php _e('The configurations, Find more at', 'smsgwnet')?> <a href="http://smsgw.net/">SMSgw.net</a>, <a href="http://mobily.ws/">Mobily.ws</a>, <a href="http://4jawaly.net/">4jawaly.net</a>, <a href="http://malath.net.sa/">malath.net.sa</a> , <a href="http://resalty.net/">resalty.net</a>, <a href="http://ashharsms.com/">AshharSMS.com</a></p>
    <form method="post">
        <p><?php _e('API Provider:', 'smsgwnet')?><br />
        <select name="smsgwnet_api_provider" id="smsgwnet_api_provider" style="width:388px">
        <?php foreach ($providers_list as $key => $provider_file) { ?>
            <?php echo '<option value="'.$provider_file.'" '.((get_option('smsgwnet_api_provider')==$provider_file)?'selected':'').'>'.$provider_file.'</option>' ?>
        <?php } ?>
        </select>
        </p>
        <p><?php _e('API TagName:', 'smsgwnet')?><br />
            <input type="text" style="width:400px" name="smsgwnet_api_tag" value="<?php echo get_option('smsgwnet_api_tag')?>" />
        </p>
        <p><?php _e('API User:', 'smsgwnet')?><br />
            <input type="text" style="width:400px" name="smsgwnet_api_user" value="<?php echo get_option('smsgwnet_api_user')?>" />
        </p>
        <p><?php _e('API Pass:', 'smsgwnet')?><br />
            <input type="text" style="width:400px" name="smsgwnet_api_pass" value="<?php echo get_option('smsgwnet_api_pass')?>" />
        </p>
        <p><?php _e('SMS Balance:', 'smsgwnet')?><br />
            <input type="text" style="width:400px" readonly="readonly" value="<?php echo get_option('smsgwnet_credit')?>" />
        </p>
        <p class="submit"><input type="submit" name="sms-submit" class="button button-primary" value="<?php _e('Update', 'smsgwnet')?>"/></p>
    </form>