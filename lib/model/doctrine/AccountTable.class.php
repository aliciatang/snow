<?php


class AccountTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Account');
    }
    public static function getAllWithTransactions()
    {
      $q = Doctrine_Query::create()
          ->from('Account a')
          ->leftJoin('a.Transactions t')
          ->orderBy('t.security_id,t.trade_date')
          ;
      return $q->execute();
    }
}