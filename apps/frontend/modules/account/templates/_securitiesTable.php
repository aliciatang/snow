<?php if(!$securities->count()):?>
  <?php echo "No record."?>
<?php else:?>
<?php   //var_dump($securities);?>
  <table>
    <thead>
      <tr>
        <th>Symbol</th>
        <th>Shares</th>
        <th>Avg. Buy</th>
        <th>Avg. Sell</th>
        <th>Dividend</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($securities as $sec):?>
      <tr>
        <td><?php echo $sec['Security']['symbol']?></td>
        <td><?php echo $sec['quantity']?></td>
        <td><?php echo number_format($sec['avg_buy_price'],2)?></td>
        <td><?php echo number_format($sec['avg_sell_price'],2)?></td>
        <td><?php echo number_format($sec['other_amount'],2)?></td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
<?php endif?>
