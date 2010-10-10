<?php if(!$securities->count()):?>
  <?php echo "No record."?>
<?php else:?>
<?php   //var_dump($securities);?>
  <table class="expandTable">
    <thead>
      <tr>
        <th>Symbol</th>
        <th>Shares</th>
        <th>Buy</th>
        <th>Price</th>
        <th>Market Value</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($securities as $sec):?>
      <tr>
        <td><?php echo $sec['Security']['symbol']?></td>
        <td><?php echo $sec['quantity']?></td>
        <td><?php echo number_format($sec['avg_buy_price'],2)?></td>
        <td><?php echo number_format($sec['cprice'],2)?></td>
        <td><?php echo number_format($sec['market_value'],2)?></td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
<?php endif?>
