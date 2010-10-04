<table>
  <thead>
    <th>Symbol</th>
    <th>Shares</th>
    <th>Shares Bought</th>
    <th>Shares Sold</th>
    <th>Buy Price</th>
    <th>Sell Price</th>
    <th>Gain</th>
    <th>Dividend</th>
    <th>Total Gain</th>
  </thead>
  <tbody>
<?php foreach($securities as $s):?>
    <tr>
      <td><?php echo $s['symbol']?></td>
      <td><?php echo $s['quantity']?></td>
      <td><?php echo $s['buy_quantity']?></td>
      <td><?php echo $s['sell_quantity']?></td>
      <td><?php echo $s['buy_quantity']?number_format($s['buy_amount']/$s['buy_quantity'],2):'--'?></td>
      <td><?php echo $s['sell_quantity']?number_format($s['sell_amount']/$s['sell_quantity'],2):'--'?></td>
      <td><?php echo number_format($s['gain'])?></td>
      <td><?php echo number_format($s['dividend'])?></td>
      <td><?php echo number_format($s['amount'])?></td>
    </tr>
<?php endforeach;?>
  </tbody>
</table>