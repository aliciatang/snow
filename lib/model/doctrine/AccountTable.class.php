<?php


class AccountTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Account');
    }
    public static function getHoldings($id,$state='current')
    {
      $ret = null;
      if($state == 'current')
      {
        $ret = Doctrine_Manager::getInstance()
              ->getCurrentConnection()
              ->fetchAll('SELECT s.`symbol`,sa.`quantity` AS `quantity`, if(sa.`buy_quantity`<>0, sa.`buy_amount`/sa.`buy_quantity`*(-1),0) AS `buy_price`, p.`cprice` AS `sell_price`, ((p.`cprice`*sa.`buy_quantity`*-1)/sa.`buy_amount`-1)*100 as gain,p.`cprice`*sa.`quantity` as `mkt_value`,sa.`dividend`,p.`cprice`*sa.`quantity`+sa.`dividend`+sa.`buy_amount` as `total_gain` FROM `account_security` sa LEFT JOIN (security s,(SELECT security_id,cprice FROM price GROUP BY security_id HAVING max(date)) p) ON (s.`id`=sa.`security_id` && p.`security_id`=sa.`security_id`) WHERE sa.`account_id`='.$id.' && sa.`security_id`>1 && sa.`quantity`<>0 GROUP BY sa.`security_id`');        
      }else if($state == 'history')
      {
        $ret = Doctrine_Manager::getInstance()
              ->getCurrentConnection()
              ->fetchAll('SELECT s.`symbol`,sa.`buy_quantity` AS `quantity`, if( sa.`buy_quantity`<>0, sa.`buy_amount`/sa.`buy_quantity`*(-1),0) AS `buy_price`, IF(sa.`sell_quantity`<>0, sa.`sell_amount`/sa.`sell_quantity`*(-1),0) AS `sell_price`, (sa.`sell_amount`/sa.`buy_amount`*(-1)-1)*100 as gain,sa.`sell_amount` as `mkt_value`,sa.`dividend`,sa.`sell_amount`+sa.`dividend`+sa.`buy_amount` as `total_gain` FROM `account_security` sa LEFT JOIN (security s) ON (s.`id`=sa.`security_id`) WHERE sa.`account_id`='.$id.' && sa.`security_id`>1 && sa.`quantity`=0 GROUP BY sa.`security_id`');      
        
      }
      $total=array();
      $total['symbol']='Total';
      $total['quantity'] = 0;
      $total['buy_price'] = 0;
      $total['sell_price'] = 0;
      $total['mkt_value'] = 0;
      $total['dividend'] = 0;
      $total['total_gain'] = 0;
      foreach($ret as $key=>$s)
      {
        $total['quantity'] += $s['quantity'];
        $total['buy_price'] += $s['buy_price']*$s['quantity'];
        $total['sell_price'] += $s['sell_price']*$s['quantity'];
        $total['mkt_value'] += $s['mkt_value'];
        $total['dividend'] += $s['dividend'];
        $total['total_gain'] = $s['total_gain'];        
      }
      $total['gain'] = ($total['buy_price']>0)?100*($total['sell_price']/$total['buy_price']-1):0;
      $total['buy_price'] = ($total['quantity']>0)?$total['buy_price']/$total['quantity']:0;
      $total['sell_price'] = ($total['quantity']>0)?$total['sell_price']/$total['quantity']:0;
      $ret[]=$total;
      return $ret;
    }
}