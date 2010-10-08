<?php
class Yahoo
{
  private static $stockUrl='http://finance.yahoo.com/';
  public static $historyUrl = 'http://ichart.finance.yahoo.com/table.csv?';
  private static $tabs=array(
    'summary'=>'q?d=s&s=',
    'realtime'=>'q/cq?d=e&s=',
    'basic'=>'q/cq?d=v1&s=',
    'daywatch'=>'q/cq?d=v2&s=',
    'performance'=>'q/cq?d=v3&s=',

    );
  /**
   * use to get list of price from yahoo
   * @param: array $list a list of security objects
   */
  public static function loadPrices($list)
  {
    if(empty($list))
    {
      throw new Exception("A list of security  must be provided.");
    }
    $symbols='';
    foreach($list as $security)
    {
      $symbols.=$security['yahoo_id'].',';
    }
    $url = self::$stockUrl.self::$tabs['daywatch'].$symbols;
    if (sfConfig::get('sf_logging_enabled'))
    {
      sfContext::getInstance()->getLogger()->info($url);
      
    }
    echo $url."\n";
    $content = file_get_contents($url);
    $start = stripos($content,'yfi_columnar_table',1000);
    $start = stripos($content,'>',$start)+1;
    $end   = stripos($content,'</table>',$start)+8;
    $content = substr($content,$start,$end-$start);
    $dom = new domDocument;
    $dom->loadHTML($content);
    $dom->preserveWhiteSpace = false;
    $tables = $dom->getElementsByTagName('table'); 
    $rows = $tables->item(0)->getElementsByTagName('tr');
    $fret = array();
    for ($i=1;$i < $rows->length; $i++)
    {
      $row = $rows->item($i);
      $cols = $row->getElementsByTagName('td');
      $ret = array();
      $ret['yahoo_id']= $cols->item(0)->nodeValue;
      if (sfConfig::get('sf_logging_enabled'))
      {
        sfContext::getInstance()->getLogger()->info("loading data for ".$ret['yahoo_id']);
      }
      echo $ret['yahoo_id'];
      $s = SecurityTable::getInstance()->findOneByYahoo_id($ret['yahoo_id']);
      $ret['date'] = date('Y-m-j',strtotime($cols->item(1)->nodeValue.",".date('Y')));
      $price = PriceTable::findOneBySdate($s->id,$ret['date']);
      $ret['cprice'] = floatval( $cols->item(2)->nodeValue );
      $ret['pchange'] = floatval( $cols->item(3)->nodeValue );
      $ret['ppchange'] = floatval( $cols->item(4)->nodeValue );
      $ret['volumn'] = intval(str_replace(',','',$cols->item(5)->nodeValue ));
      $ret['avgValumn']=intval(str_replace(',','',$cols->item(6)->nodeValue ));
      $ret['open'] = floatval( $cols->item(7)->nodeValue );
      $rang = $cols->item(8)->getElementsByTagName('span');
      if($rang->length > 3)
      {
        $ret['low']= floatval( $rang->item(0)->nodeValue );
        $ret['high']= floatval( $rang->item(3)->nodeValue );
      }
      $fret[]=$ret;
      $price = (is_Object($price))?$price:new Price();
      $price->fromArray($ret);
      $price->Security = SecurityTable::getInstance()->findOneByYahoo_id($ret['yahoo_id']);
      $price->save();
      if (sfConfig::get('sf_logging_enabled'))
      {
        sfContext::getInstance()->getLogger()->info("... done loading data for ".$ret['yahoo_id']);
      }
      echo " ... done.\n";
    }
    return $fret;
  }
  public static function historyPrices($symbol,$start,$end)
  {
    $url = self::$historyUrl."&s=".$symbol;
    $min = min($start,$end);
    $max = max($start,$end);
    $url .= "&a=".date('j',strtotime($min));
    $url .= "&b=".date('d',strtotime($min));
    $url .= "&c=".date('Y',strtotime($min));
    
    $url .= "&d=".date('j',strtotime($max));
    $url .= "&e=".date('d',strtotime($max));
    $url .= "&f=".date('Y',strtotime($max));
    $url .= '&g=d';
    $url .= '&ignore=.csv';
    echo $url;
    $content = file_get_contents($url);
    
  }
}
?>
