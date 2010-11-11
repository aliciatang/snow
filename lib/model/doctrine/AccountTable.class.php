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
              ->fetchAll('select s.symbol,h.account_id,h.security_id,h.date,h.quantity,p.cprice*h.quantity as mkt_value,(select sum(t.amount) from transaction t where t.account_id=h.account_id && t.trade_date<=h.date && t.security_id=h.security_id && t.action_id NOT IN (2,5,17,18,116) && t.amount<0 )/h.quantity*(-1) as buy_price,p.cprice as sell_price,(select sum(amount) from transaction where action_id=2 && security_id=h.security_id && trade_date<=h.date) as dividend from holding_history h left join (price p,security s) on (p.security_id=h.security_id && p.date=h.date && s.id=h.security_id) where h.account_id='.$id.' && h.date=(select max(date) from holding_history where account_id='.$id.')');        
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
        $ret[$key]['gain'] = (floatval($s['sell_price'])/floatval($s['buy_price'])-1)*100;
        $total['quantity'] += $s['quantity'];
        $total['buy_price'] += $s['buy_price']*$s['quantity'];
        $total['sell_price'] += $s['sell_price']*$s['quantity'];
        $total['mkt_value'] += $s['mkt_value'];
        $total['dividend'] += $s['dividend'];
        $ret[$key]['total_gain'] = ($s['sell_price']-$s['buy_price'])*$s['quantity'];
        $total['total_gain'] = ($s['sell_price']-$s['buy_price'])*$s['quantity'];        
      }
      $total['gain'] = ($total['buy_price']>0)?100*($total['sell_price']/$total['buy_price']-1):0;
      $total['buy_price'] = ($total['quantity']>0)?$total['buy_price']/$total['quantity']:0;
      $total['sell_price'] = ($total['quantity']>0)?$total['sell_price']/$total['quantity']:0;
      $ret[]=$total;
      return $ret;
    }
}