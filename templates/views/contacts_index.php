<h2><?php _e('Contacts', 'smsgwnet')?> <a class="add-new-h2" href="admin.php?page=sms-gw&action=contacts&do=add"><?php _e('Add New', 'smsgwnet')?></a></h2>
<p><?php _e('Control your contacts', 'smsgwnet')?>.</p>

    <?php if ( $_GET['do'] == 'add' ) { ?>
        <form method="post"><ul>
            <p><?php _e('Contact Group', 'smsgwnet')?></span>: <br />
            <select name="contact_group_id" id="groups" style="width:388px">
                <option value="0">&nbsp;</option>
            <?php foreach ($groups as $key => $row) { ?>
                <?php echo '<option value="'.$row->group_id.'">'.$row->group_name.' ('.$row->count.')</option>'?>
            <?php } ?>
            </select>
            </p>
            <p><?php _e('Contact Name', 'smsgwnet')?>: <br />
            <input type="text" style="width:400px" name="contact_name" value="" />
            </p>
            <p><?php _e('Contact Mobile', 'smsgwnet')?>: <br />
            <input type="text" style="width:400px" name="contact_mobile" value="" />
            </p>
            <p class="submit"><input type="submit" name="sms-submit" class="button button-primary" value="<?php _e('Save', 'smsgwnet')?>"/></p>
        </form>
    <?php }elseif ( $_GET['do'] == 'edit' ) { ?>
        <form method="post"><ul>
            <p><?php _e('Contact Group', 'smsgwnet')?></span>: <br />
            <select name="contact_group_id" id="groups" style="width:388px">
                <option value="0">&nbsp;</option>
            <?php foreach ($groups as $key => $row) { ?>
                <?php echo '<option value="'.$row->group_id.'" '.(($row->group_id==$contact->contact_group_id)?'selected':'').'>'.$row->group_name.' ('.$row->count.')</option>'?>
            <?php } ?>
            </select>
            </p>
            <p><?php _e('Contact Name', 'smsgwnet')?>: <br />
            <input type="text" style="width:400px" name="contact_name" value="<?php echo $contact->contact_name?>" />
            </p>
            <p><?php _e('Contact Mobile', 'smsgwnet')?>: <br />
            <input type="text" style="width:400px" name="contact_mobile" value="<?php echo $contact->contact_mobile?>" />
            </p>
            <p class="submit"><input type="submit" name="sms-submit" class="button button-primary" value="<?php _e('Save', 'smsgwnet')?>"/></p>
        </form>
    <?php } else { ?>
        <table class="widefat">
        <thead>
        <tr>
          <th><?php _e('ID', 'smsgwnet')?></th>
          <th><?php _e('Name', 'smsgwnet')?></th>
          <th><?php _e('Mobile', 'smsgwnet')?></th>
          <th><?php _e('Action', 'smsgwnet')?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ( $contacts as $row ){ ?>
            <tr>
              <td><?php echo $row->contact_id?></td>
              <td><?php echo $row->contact_name?></td>
              <td><?php echo $row->contact_mobile?></td>
              <td>
                  <a class="button edit-button" href="admin.php?page=sms-gw&action=contacts&do=edit&id=<?php echo $row->contact_id?>"><?php _e('Edit', 'smsgwnet')?></a>
                  <a class="button delete-button" href="admin.php?page=sms-gw&action=contacts&do=delete&id=<?php echo $row->contact_id?>"><?php _e('Delete', 'smsgwnet')?></a>
              </td>
            </tr>
        <?php } ?>
        <tbody>
        </table>
    <?php } ?>
