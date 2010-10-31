<table>
  <thead><th colspan="2">Summary</th></thead>
  <tbody>
    <tr>
      <td>Balance</td>
      <td><?php echo number_format($accounts['total']['balance'],2) ?></td>
    </tr>
    <tr>
      <td>Deposit</td>
      <td><?php echo number_format($accounts['total']['deposit'],2) ?></td>
    </tr>
    <tr>
      <td>Market Value</td>
      <td><?php echo number_format($accounts['total']['mkt_value'],2) ?></td>
    </tr>
    <tr>
      <td>Gain</td>
      <td><?php echo number_format($accounts['total']['gain'],2) ?></td>
    </tr>
    <tr>
      <td>Gain %</td>
      <td class="<?php echo ($accounts['total']['pgain']>0)?'positive':'negative' ?>"><?php echo number_format($accounts['total']['pgain'],2)?>%</td>
    </tr>
    <tr>
      <td>Time Weighted Return</td>
      <td class="<?php echo ($twr>1)?'positive':'negative'?>"><?php echo number_format(($twr-1)*100,2)?>%</td>
    </tr>
    <tr>
      <td>Annualized:</td>
      <?php 
        $days = floor((strtotime('-2 days')-strtotime('2007-04-02'))/3600/24);
        $ret = log($twr)*365/$days;
        $ret = exp($ret);
      ?>
      <td><?php echo number_format(($ret-1)*100,2)?>%</td>
    </tr>
  </tbody>
  <tfoot></tfoot>
</table>