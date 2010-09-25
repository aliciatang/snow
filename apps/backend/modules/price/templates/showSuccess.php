<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $price->getId() ?></td>
    </tr>
    <tr>
      <th>Security:</th>
      <td><?php echo $price->getSecurityId() ?></td>
    </tr>
    <tr>
      <th>Date:</th>
      <td><?php echo $price->getDate() ?></td>
    </tr>
    <tr>
      <th>Open:</th>
      <td><?php echo $price->getOpen() ?></td>
    </tr>
    <tr>
      <th>Close:</th>
      <td><?php echo $price->getClose() ?></td>
    </tr>
    <tr>
      <th>High:</th>
      <td><?php echo $price->getHigh() ?></td>
    </tr>
    <tr>
      <th>Low:</th>
      <td><?php echo $price->getLow() ?></td>
    </tr>
    <tr>
      <th>Volumn:</th>
      <td><?php echo $price->getVolumn() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $price->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $price->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('price/edit?id='.$price->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('price/index') ?>">List</a>
