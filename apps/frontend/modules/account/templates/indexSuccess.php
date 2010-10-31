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
      <th>%</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($accounts as $key=>$account): ?>
    <?php if($key =='total') continue;?>
    <tr>
      <td><?php echo link_to($account['number'],'account/show?id='.$account['id']) ?></td>
      <td><?php echo $account['type'] ?></td>
      <td><?php echo number_format($account['balance'],2) ?></td>
      <td><?php echo number_format($account['deposit'],2) ?></td>
      <td><?php echo number_format($account['mkt_value'],2) ?></td>
      <td><?php echo number_format($account['gain'],2) ?></td>
      <td class="<?php echo ($account['pgain']>0)?'positive':'negative' ?>"><?php echo number_format($account['pgain'],2)?>%</td>
    </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <td><?php echo $accounts['total']['number'] ?></td>
    <td><?php echo $accounts['total']['type'] ?></td>
    <td><?php echo number_format($accounts['total']['balance'],2) ?></td>
    <td><?php echo number_format($accounts['total']['deposit'],2) ?></td>
    <td><?php echo number_format($accounts['total']['mkt_value'],2) ?></td>
    <td><?php echo number_format($accounts['total']['gain'],2) ?></td>
    <td class="<?php echo ($accounts['total']['pgain']>0)?'positive':'negative' ?>"><?php echo number_format($accounts['total']['pgain'],2)?>%</td>
  </tfoot>
</table>
<?php slot('jQuery') ?>
<?php end_slot()?>
