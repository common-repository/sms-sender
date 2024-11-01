    <h2><?php _e('Groups', 'smsgwnet')?> <a class="add-new-h2" href="admin.php?page=sms-gw&action=groups&do=add"><?php _e('Add New', 'smsgwnet')?></a></h2>
    <p><?php _e('Control your groups.', 'smsgwnet')?></p>
    
    <?php if ( $_GET['do'] == 'add' ) { ?>
        <form method="post">
        <ul>
          <li>
              <label><?php _e('Group Name:', 'smsgwnet')?></label>
              <input type="text" style="width:100%" name="group_name" value="" />
          </li>
        </ul>
        <p class="submit"><input type="submit" name="sms-submit" class="button button-primary" value="<?php _e('Save', 'smsgwnet')?>"/></p>
        </form>
    <?php }elseif ( $_GET['do'] == 'edit' ) { ?>
        <form method="post">
        <ul>
          <li>
              <label><?php _e('Group Name:', 'smsgwnet')?></label>
              <input type="text" style="width:100%" name="group_name" value="<?php echo $group->group_name?>" />
          </li>
        </ul>
        <p class="submit"><input type="submit" name="sms-submit" class="button button-primary" value="<?php _e('Save', 'smsgwnet')?>"/></p>
        </form>
    <?php } else { ?>
        <table class="widefat">
        <thead>
            <tr>
              <th><?php _e('ID', 'smsgwnet')?></th>
              <th><?php _e('Name', 'smsgwnet')?></th>
              <th><?php _e('Contacts', 'smsgwnet')?></th>
              <th><?php _e('Action', 'smsgwnet')?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ( $groups as $row ){ ?>
            <tr>
              <td><?php echo $row->group_id?></td>
              <td><?php echo $row->group_name?></td>
              <td><?php echo $row->count?></td>
              <td>
                  <a class="button edit-button" href="admin.php?page=sms-gw&action=groups&do=edit&id=<?php echo $row->group_id?>"><?php _e('Edit', 'smsgwnet')?></a>
                  <a class="button delete-button" href="admin.php?page=sms-gw&action=groups&do=delete&id=<?php echo $row->group_id?>"><?php _e('Delete', 'smsgwnet')?></a>
              </td>
            </tr>
        <?php } ?>
        <tbody>
        </table>
    <?php } ?>