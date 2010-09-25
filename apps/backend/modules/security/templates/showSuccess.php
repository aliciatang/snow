<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $security->getId() ?></td>
    </tr>
    <tr>
      <th>Symbol:</th>
      <td><?php echo $security->getSymbol() ?></td>
    </tr>
    <tr>
      <th>Market:</th>
      <td><?php echo $security->getMarket() ?></td>
    </tr>
    <tr>
      <th>Google:</th>
      <td><?php echo $security->getGoogleId() ?></td>
    </tr>
    <tr>
      <th>Yahoo:</th>
      <td><?php echo $security->getYahooId() ?></td>
    </tr>
    <tr>
      <th>Scottrade:</th>
      <td><?php echo $security->getScottradeId() ?></td>
    </tr>
    <tr>
      <th>Name:</th>
      <td><?php echo $security->getName() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('security/edit?id='.$security->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('security/index') ?>">List</a>
