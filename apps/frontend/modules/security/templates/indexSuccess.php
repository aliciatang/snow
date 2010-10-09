<h1>Current holdings</h1>
<table>
  <thead>
    <th>Symbol</th>
    <th>Shares</th>
    <th>Buy Price</th>
    <th>Price</th>
    <th>Market Value</th>
    <th>Gain</th>
    <th>Dividend</th>
  </thead>
  <tbody>
<?php foreach($csecurities as $key =>$s):?>
    <tr>
      <td><?php echo $s['symbol']?></td>
      <td class="shares"><?php echo $s['quantity']?>
      </td>
      <td><?php echo $s['buy_quantity']?number_format($s['buy_amount']/$s['buy_quantity'],2):'--'?></td>
      <td><?php echo number_format($s['cprice'],2)?></td>
      <td><?php echo number_format($s['mkt_value'],2)?></td>
      <td><?php echo number_format($s['gain'],2)?></td>
      <td><?php echo number_format($s['dividend'],2)?></td>
    </tr>
<?php endforeach;?>
  </tbody>
</table>
<h1>Historical Holdings</h1>
<table>
  <thead>
    <th>Symbol</th>
    <th>Shares</th>
    <th>Buy Price</th>
    <th>Sell Price</th>
    <th>Gain</th>
    <th>Dividend</th>
    <th>Total Gain</th>
  </thead>
  <tbody>
<?php foreach($hsecurities as $s):?>
    <tr>
      <td><?php echo $s['symbol']?></td>
      <td><?php echo $s['buy_quantity']?></td>
      <td><?php echo $s['buy_quantity']?number_format($s['buy_amount']/$s['buy_quantity'],2):'--'?></td>
      <td><?php echo $s['sell_quantity']?number_format($s['sell_amount']/$s['sell_quantity'],2):'--'?></td>
      <td><?php echo number_format($s['gain'],2)?>(<?php echo number_format(floatval($s['buy_amount'])?($s['gain']*100/$s['buy_amount']):0,2) ?>%)</td>
      <td><?php echo number_format($s['dividend'],2)?>(<?php echo number_format(floatval($s['buy_amount'])?($s['dividend']*100/$s['buy_amount']):0,2) ?>%)</td>
      <td><?php echo number_format($s['amount'],2)?>(<?php echo number_format(floatval($s['buy_amount'])?($s['amount']*100/$s['buy_amount']):0,2) ?>%)</td>
    </tr>
<?php endforeach;?>
  </tbody>
</table>