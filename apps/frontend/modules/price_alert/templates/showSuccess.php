<table>
  <tbody>
    <tr>
      <th>User:</th>
      <td><?php echo $price_alert->getUserId() ?></td>
    </tr>
    <tr>
      <th>Alert:</th>
      <td><?php echo $price_alert->getAlertId() ?></td>
    </tr>
    <tr>
      <th>Security:</th>
      <td><?php echo $price_alert->getSecurityId() ?></td>
    </tr>
    <tr>
      <th>Description:</th>
      <td><?php echo $price_alert->getDescription() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $price_alert->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $price_alert->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('price_alert/edit?user_id='.$price_alert->getUserId().'&alert_id='.$price_alert->getAlertId().'&security_id='.$price_alert->getSecurityId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('price_alert/index') ?>">List</a>
