    <h2><?php _e('Messages', 'smsgwnet')?></h2>
    <p><?php _e('Control your messages.', 'smsgwnet')?></p>

    <?php if(isset($message)) { ?>
        <table class="widefat">
        <tr>
          <th><?php _e('ID', 'smsgwnet')?></th>
          <td><?php echo $message->msg_id?></td>
        </tr>
        <tr>
          <th><?php _e('Date', 'smsgwnet')?></th>
          <td><?php echo $message->msg_date?></td>
        </tr>
        <tr>
          <th><?php _e('Message', 'smsgwnet')?></th>
          <td><?php echo $message->msg_text?></td>
        </tr>
        <tr>
          <th><?php _e('Count', 'smsgwnet')?></th>
          <td><?php echo $message->count?></td>
        </tr>
        </table>
        <p><?php _e('Mobile numbers:', 'smsgwnet')?></p>
        <table class="widefat">
            <thead>
            <tr>
                <th><?php _e('ID', 'smsgwnet')?></th>
                <th><?php _e('Date', 'smsgwnet')?></th>
                <th><?php _e('Mobile', 'smsgwnet')?></th>
                <th><?php _e('Status', 'smsgwnet')?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ( $sends as $row ){ ?>
            <tr>
                <td><?php echo $row->send_id?></td>
                <td><?php echo $row->send_date?></td>
                <td><?php echo $row->send_mobile?></td>
                <td><?php echo $row->send_status?></td>
            </tr>
            <?php } ?>
            <tbody>
        </table>

    <?php } else {?>
        <table class="widefat">
            <thead>
            <tr>
                <th><?php _e('ID', 'smsgwnet')?></th>
                <th><?php _e('Date', 'smsgwnet')?></th>
                <th><?php _e('Message', 'smsgwnet')?></th>
                <th><?php _e('Contacts', 'smsgwnet')?></th>
                <th><?php _e('Action', 'smsgwnet')?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ( $messages as $row ){ ?>
            <tr>
                <td><?php echo $row->msg_id?></td>
                <td><?php echo $row->msg_date?></td>
                <td><?php echo $row->msg_text?></td>
                <td><?php echo $row->count?></td>
            <td>
              <a class="button edit-button" href="admin.php?page=sms-gw&action=messages&do=show&id=<?php echo $row->msg_id?>"><?php _e('Show', 'smsgwnet')?></a>
              <a class="button delete-button" href="admin.php?page=sms-gw&action=messages&do=delete&id=<?php echo $row->msg_id?>"><?php _e('Delete', 'smsgwnet')?></a>
            </td>
            </tr>
            <?php } ?>
            <tbody>
        </table>
    <?php } ?>

