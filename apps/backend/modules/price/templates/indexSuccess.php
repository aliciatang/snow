<h1>Prices List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Security</th>
      <th>Date</th>
      <th>Open</th>
      <th>Price</th>
      <th>Change</th>
      <th>Percentage</th>
      <th>High</th>
      <th>Low</th>
      <th>Volumn</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($prices as $price): ?>
    <tr>
      <td><a href="<?php echo url_for('price/show?id='.$price->getId()) ?>"><?php echo $price->getId() ?></a></td>
      <td><?php echo $price->getSecurity()->symbol ?></td>
      <td><?php echo $price->getDate() ?></td>
      <td><?php echo $price->getOpen() ?></td>
      <td><?php echo $price->getCprice() ?></td>
      <td><?php echo $price->getPchange() ?></td>
      <td><?php echo $price->getPpchange() ?>%</td>
      <td><?php echo $price->getHigh() ?></td>
      <td><?php echo $price->getLow() ?></td>
      <td><?php echo $price->getVolumn() ?></td>
      <td><?php echo $price->getCreatedAt() ?></td>
      <td><?php echo $price->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('price/new') ?>">New</a>
