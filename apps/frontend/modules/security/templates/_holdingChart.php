<?php 
  $url = "http://chart.apis.google.com/chart?chxs=0,000000,14&chs=300x220&cht=p&chd=t:";
  $total = $csecurities[count($csecurities)-1]['mkt_value']+$balance['balance'];
  //var_dump($total);
  $values = array();
  $labels = array();
  foreach($csecurities as $key =>$s)
  {
    //var_dump($s['mkt_value']);
    //var_dump($total['mkt_value']);
    if($s['symbol'] == 'Total') break;
    $value= $s['mkt_value']/$total*100;
    $labels[] = $s['symbol']."(".number_format($value,2)."%)";
    $values[] =$value;
  }
  $value = $balance['balance']/$total*100;
  $labels[] = 'Cash('.number_format($value,2).'%)';
  $values[] = $value;
  $url .= implode(',',$values);
  //$url .= "&chdl=".implode('|',$labels);
  $url .= "&chdl=".implode('|',$labels);
  $url .= "&chdls=000000,14";
  $url .= "&chtt=Holdings";
  $url .= "&chco=FF0000|FF9900|FFFF88|008000|3399CC|224499|7777CC|80C65A|AA0033|FF9914|FFF4C2|00FF00";
  $url .= "&chp=4.71";
  $url .= "&chma=0,0,0,0|0,700";
?>
<?php slot('sidebar') ?>
<img style="border: 1px solid #EEE" src="<?php echo $url;?>" />
<?php end_slot() ?>