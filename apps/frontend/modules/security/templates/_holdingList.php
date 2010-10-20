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
    <th>Total Gain</th>
  </thead>
  <tbody>
<?php foreach($csecurities as $key =>$s):?>
    <tr>
      <?php if($s['symbol'] == 'Total') break;?>
      <td><?php echo $s['symbol']?></td>
      <td class="shares"><?php echo $s['quantity']?>
      </td>
      <td><?php echo number_format($s['buy_price'],2)?></td>
      <td><?php echo number_format($s['sell_price'],2)?></td>
      <td><?php echo number_format($s['mkt_value'],2)?></td>
      <td class="<?php echo ($s['gain']>0)?'positive':'negative' ?>"><?php echo number_format($s['gain'],2)?>%</td>
      <td><?php echo number_format($s['dividend'],2)?></td>
      <td><?php echo number_format($s['total_gain'],2)?></td>
    </tr>
<?php endforeach;?>
  </tbody>
  <tfoot>
    <tr>
      <td>Cash</td>
      <td colspan="3">--</td>
      <td><?php echo $balance['balance'];?></td>
      <td colspan="3">--</td>
    </tr>
    <tr>
      <td><?php echo $s['symbol']?></td>
      <td><?php echo $s['quantity']?></td>
      <td><?php echo number_format($s['buy_price'],2)?></td>
      <td><?php echo number_format($s['sell_price'],2)?></td>
      <td><?php echo number_format($s['mkt_value']+$balance['balance'],2)?></td>
      <td class="<?php echo ($s['gain']>0)?'positive':'negative' ?>"><?php echo number_format($s['gain'],2)?>%</td>
      <td><?php echo number_format($s['dividend'],2)?></td>
      <td><?php echo number_format($s['total_gain'],2)?></td>
    </tr>
  </tfoot>
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
      <?php if($s['symbol'] == 'Total') break;?>
      <td><?php echo $s['symbol']?></td>
      <td><?php echo $s['quantity']?></td>
      <td><?php echo number_format($s['buy_price'],2)?></td>
      <td><?php echo number_format($s['sell_price'],2)?></td>
      <td class="<?php echo ($s['gain']>0)?'positive':'negative' ?>"><?php echo number_format($s['gain'],2)?>%</td>
      <td><?php echo number_format($s['dividend'],2)?></td>
      <td><?php echo number_format($s['total_gain'],2)?></td>
    </tr>
<?php endforeach;?>
  </tbody>
  <tfoot>
    <td><?php echo $s['symbol']?></td>
    <td><?php echo $s['quantity']?></td>
    <td><?php echo number_format($s['buy_price'],2)?></td>
    <td><?php echo number_format($s['sell_price'],2)?></td>
    <td class="<?php echo ($s['gain']>0)?'positive':'negative' ?>"><?php echo number_format($s['gain'],2)?>%</td>
    <td><?php echo number_format($s['dividend'],2)?></td>
    <td><?php echo number_format($s['total_gain'],2)?></td>
  </tfoot>
</table>