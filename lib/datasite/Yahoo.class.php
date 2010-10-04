<?php
class Yahoo
{
  private static $stockUrl='http://finance.yahoo.com/';
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
    }
    return $fret;
  }
}
?>
