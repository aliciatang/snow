<h1>Your Account List</h1>

<table id="account-list" class="expandContainer">
  <thead>
    <tr>
      <th>Account</th>
      <th>Type</th>
      <th>Balance<?php $balance=0?></th>
      <th>Deposit</th>
      <th>Last Record</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($accounts as $account): ?>
    <tr class="expandable">
      <td><?php echo $account['number'] ?></td>
      <td><?php echo $account['type'] ?></td>
      <td><?php echo number_format(isset($account['amount'])?$account['amount']:0,2); $balance+=$account['amount']; ?></td>
      <td><?php echo number_format(isset($account['deposit'])?$account['deposit']:0,2) ?></td>
      <td><?php echo date('Y-m-d',strtotime($account['last_record'])) ?></td>
    </tr>
    <tr>
      <td colspan="5">
        <?php include_partial('securitiesTable',array('securities'=>$account['AccountSecurities']))?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="5"><?php echo $balance;?></td>
    </tr>
    <td colspan="5">
    <a href="<?php echo url_for('account/new') ?>">Add a new account</a>
    </td>
  </tfoot>
</table>
<?php slot('jQuery') ?>
$('tr.expandable').click(function() {
		$(this).next().toggle();
		return false;
}).next().hide();
<?php end_slot()?>
