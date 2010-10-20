<?php 
  include_partial(
    'security/holdingList',
    array(
      'csecurities'=>$csecurities,
      'hsecurities'=>$hsecurities,
      'balance' => $balance
      )
    )?>
<?php slot('sidebar') ?>
<table>
  <thead><th colspan="2">Account Summary</th></thead>
  <tbody>
    <tr><td>Number</td><td><?php echo $account['number']?></td></tr>
    <tr><td>Type</td><td><?php echo $account['type']?></td></tr>
    <tr><td>Balance</td><td><?php echo number_format($account['balance'],2)?></td></tr>
    <tr><td>Deposit</td><td><?php echo number_format($account['deposit'],2)?></td></tr>
    <tr><td>Market Value</td><td><?php echo number_format($account['mkt_value'],2)?></td></tr>
    <tr><td>Gain</td><td><?php echo number_format($account['gain'],2)?></td></tr>
  </tbody>
  <tfoot></tfoot>
</table>
<?php end_slot() ?>