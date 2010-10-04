<?php

/**
 * sfGuardUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    valueInvest
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class sfGuardUser extends PluginsfGuardUser
{
  public function getAccountsWithTransactions()
  {
    $q = Doctrine_Query::create()
        ->from('Account a')
        ->leftJoin('a.Transactions t')
        ->orderBy('t.security_id,t.trade_date')
        ->where('a.user_id = ?', $this->getId())
        ;
    return $q->execute();
  }
  public function getAccountsWithSecurities()
  {
    $q = Doctrine_Query::create()
        ->from('Account a')
        ->leftJoin('a.Securities s')
        ->where('a.user_id = ?', $this->getId())
        ;
    return $q->execute();
  }
  public function getAccountsWithAccountSecurities()
  {
    $q = Doctrine_Query::create()
        ->from('Account a')
        ->leftJoin('a.AccountSecurities s')
        ->leftJoin('s.Security ss')
        ->where('a.user_id = ?', $this->getId())
        ->orderBy('a.id,s.quantity')
        ;
    $ret = $q->fetchArray();
    foreach($ret as $i=>$a)
    {
      $ret[$i]['amount'] = 0;
      $ret[$i]['number'] = "****".substr($a['number'],-4);
      foreach($a['AccountSecurities'] as $j=>$s)
      {
        $ret[$i]['amount'] += $s['buy_amount']+$s['sell_amount']+$s['other_amount'];
        $ret[$i]['AccountSecurities'][$j]['avg_buy_price']=(!$s['buy_quantity'])?0:(floatval($s['buy_amount'])/intval($s['buy_quantity']));
        $ret[$i]['AccountSecurities'][$j]['avg_sell_price']=(!$s['sell_quantity'])?0:(floatval($s['sell_amount'])/intval($s['sell_quantity']));
        if($s['security_id'] == '7')$ret[$i]['deposit'] = $s['other_amount'];
      }
    }
    return $ret;
  }
  public function getSecurities( $state='current')
  {
    $q = Doctrine_Query::create()
        ->select('s.symbol')
        ->addSelect('SUM(as.quantity) as quantity')
        ->addSelect('SUM(as.buy_quantity) as buy_quantity')
        ->addSelect('SUM(as.sell_quantity)*(-1) as sell_quantity')
        ->addSelect('SUM(as.buy_amount) as buy_amount')
        ->addSelect('SUM(as.sell_amount) as sell_amount')
        ->from('Security s')
        ->leftJoin('s.AccountSecurities as')
        ->leftJoin('as.Account a')
        ->where('a.user_id = ?', $this->getId())
        ->orderBy('quantity')
        ->groupBy('s.id')
        ;
    switch($state)
    {
      case 'current':
        $q->having('quantity <> ?', 0 );break;
      case 'history':
        $q->having('quantity = ?', 0 );break;
      default:
        break;
    }
    $ret = $q->fetchArray();
    return $ret;
  }
}
