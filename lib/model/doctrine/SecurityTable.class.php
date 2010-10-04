<?php


class SecurityTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Security');
    }
    public static function loadPrice()
    {
      $q = Doctrine_Query::create()
          ->from('Security s')
          ->where('s.market <> ?', 'OPTION')
          ->andWhere('s.id > ?', 1)
          ;
      $list = $q->fetchArray();
      return Yahoo::loadPrices($list);
    }
    public function findOneByScottradeId($symbol)
    {
      $security = self::getInstance()->findOneBy('scottrade_id',$symbol);
      if(! $security)
      {
        $security = new Security();
        $security->scottrade_id = $symbol;
        $security->symbol = ucwords($symbol);
      }
      return $security;
    }
}
