<?php


class SecurityTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Security');
    }
    public static function loadPrice()
    {
        $yahoo = new Yahoo();
        $list = self::getInstance()->findAll();
        return $yahoo->loadPrices($list);
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
