<form action="admin.php?page=sms-gw" method="post">
    <p>
        <?php _e('Groups:', 'smsgwnet')?><br />
        <select name="groups[]" id="groups" multiple="multiple" style="width:388px">
        <?php foreach ($groups as $key => $row) { ?>
            <?php echo '<option value="'.$row->group_id.'" data-count="'.$row->count.'">'.$row->group_name.' ('.$row->count.')</option>';?>
        <?php } ?>
        </select>
    </p>
    <p>
        <?php _e('Contacts:', 'smsgwnet')?><br />
        <select name="contacts[]" id="contacts" multiple="multiple" style="width:388px">'
        <?php foreach ($contacts as $key => $row) { ?>
            <?php echo '<option value="'.$row->contact_id.'">'.$row->contact_name.'</option>';?>
        <?php } ?>
        </select>
    </p>
    <p style="max-width: 400px;">
        <?php _e('Message:', 'smsgwnet')?> <span id="countmessages">0 Chars, 0 points</span> <span id="balance"><?php _e('Your Balance:', 'smsgwnet')?> <?php  echo get_option('smsgwnet_credit')?></span><br />
        <textarea style="width:100%;height:200px;font-size:130%;" id="smsmessage" name="sms-message"><?php  echo ((isset( $_POST["sms-message"] )) ? esc_attr( $_POST["sms-message"] ) : '' ) ?></textarea>
    </p>
    <p><input type="submit" id="send" name="sms-submit" class="button button-primary" value="<?php _e('Send', 'smsgwnet')?>"/></p>
</form>