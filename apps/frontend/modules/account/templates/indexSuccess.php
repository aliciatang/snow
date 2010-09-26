<h1>Your Account List</h1>

<table>
  <thead>
    <tr>
      <th>Account</th>
      <th>Type</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($accounts as $account): ?>
    <tr>
      <td><?php echo $account->getDisplayNumber() ?></td>
      <td><?php echo $account->getType() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<a href="<?php echo url_for('account/new') ?>">New</a>
