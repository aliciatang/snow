<h1>Your Account List</h1>

<table>
  <thead>
    <tr>
      <th>Account</th>
      <th>Type</th>
      <th>Balance</th>
      <th>Deposit</th>
      <th>Last Record</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($accounts as $account): ?>
    <tr>
      <td><?php echo $account['number'] ?></td>
      <td><?php echo $account['type'] ?></td>
      <td><?php echo isset($account['amount'])?$account['amount']:0 ?></td>
      <td><?php echo isset($account['deposit'])?$account['deposit']:0 ?></td>
      <td><?php echo date('Y-m-d',strtotime($account['last_record'])) ?></td>
    </tr>
    <tr>
      <td colspan="5">
        <?php include_partial('securitiesTable',array('securities'=>$account['AccountSecurities']))?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<a href="<?php echo url_for('account/new') ?>">New</a>
