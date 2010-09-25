<h1>Price alerts List</h1>

<table>
  <thead>
    <tr>
      <th>Security</th>
      <th>Price</th>
      <th>Buy</th>
      <th>Sell</th>
      <th>Description</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($price_alerts as $price_alert): ?>
    <tr>
      <td><?php echo $price_alert->getSecurity()->getName() ?></td>
      <td><?php echo $price_alert->getSecurity()->getCprice()->getCprice() ?></td>
      <td><?php echo $price_alert->getAlert()->getMin() ?></td>
      <td><?php echo $price_alert->getAlert()->getMax() ?></td>
      <td><?php echo $price_alert->getDescription() ?></td>
      <td><?php echo $price_alert->getCreatedAt() ?></td>
      <td><?php echo $price_alert->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('price_alert/new') ?>">New</a>
