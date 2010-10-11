<h1>Your Account List</h1>

<table id="account-list" class="expandContainer">
  <thead>
    <tr>
      <th>Account</th>
      <th>Type</th>
      <th>Balance</th>
      <th>Deposit</th>
      <th>Market Value</th>
      <th>Gain</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($accounts as $account): ?>
    <?php if($account['number']=='Total') break;?>
    <tr>
      <td><?php echo link_to($account['number'],'account/show?id='.$account['id']) ?></td>
      <td><?php echo $account['type'] ?></td>
      <td><?php echo number_format($account['balance'],2) ?></td>
      <td><?php echo number_format($account['deposit'],2) ?></td>
      <td><?php echo number_format($account['mkt_value'],2) ?></td>
      <td class="<?php echo ($account['gain']>0)?'positive':'negative' ?>"><?php echo number_format($account['gain'],2)?>%</td>
    </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <td><?php echo $account['number'] ?></td>
    <td><?php echo $account['type'] ?></td>
    <td><?php echo number_format($account['balance'],2) ?></td>
    <td><?php echo number_format($account['deposit'],2) ?></td>
    <td><?php echo number_format($account['mkt_value'],2) ?></td>
    <td class="<?php echo ($account['gain']>0)?'positive':'negative' ?>"><?php echo number_format($account['gain'],2)?>%</td>
  </tfoot>
</table>
<?php slot('jQuery') ?>
<?php end_slot()?>
