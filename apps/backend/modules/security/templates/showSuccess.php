<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $sec->getId() ?></td>
    </tr>
    <tr>
      <th>Symbol:</th>
      <td><?php echo $sec->getSymbol() ?></td>
    </tr>
    <tr>
      <th>Market:</th>
      <td><?php echo $sec->getMarket() ?></td>
    </tr>
    <tr>
      <th>Google:</th>
      <td><?php echo $sec->getGoogleId() ?></td>
    </tr>
    <tr>
      <th>Yahoo:</th>
      <td><?php echo $sec->getYahooId() ?></td>
    </tr>
    <tr>
      <th>Scottrade:</th>
      <td><?php echo $sec->getScottradeId() ?></td>
    </tr>
    <tr>
      <th>Name:</th>
      <td><?php echo $sec->getName() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('security/edit?id='.$sec->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('security/index') ?>">List</a>
