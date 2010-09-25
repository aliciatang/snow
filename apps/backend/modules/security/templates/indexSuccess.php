<h1>Securitys List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Symbol</th>
      <th>Market</th>
      <th>Google</th>
      <th>Yahoo</th>
      <th>Scottrade</th>
      <th>Name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($securitys as $security): ?>
    <tr>
      <td><a href="<?php echo url_for('security/show?id='.$security->getId()) ?>"><?php echo $security->getId() ?></a></td>
      <td><?php echo $security->getSymbol() ?></td>
      <td><?php echo $security->getMarket() ?></td>
      <td><?php echo $security->getGoogleId() ?></td>
      <td><?php echo $security->getYahooId() ?></td>
      <td><?php echo $security->getScottradeId() ?></td>
      <td><?php echo $security->getName() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('security/new') ?>">New</a>
