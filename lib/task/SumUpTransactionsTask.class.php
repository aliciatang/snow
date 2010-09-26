<?php

class SumUpTransactionsTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));
    $this->addOption('user',null,sfCommandOption::PARAMETER_OPTIONAL,'The cvs file name','all');
    
    $this->namespace        = 'snow';
    $this->name             = 'sumUpTransactions';
    $this->briefDescription = 'Re-compute the sum for each transactions';
    $this->detailedDescription = <<<EOF
The [SumUpTransactions|INFO] re-compute the sume for each transaction. 
This task need to be run every time new transaction is added.
Call it with:

  [php symfony snow:sumUpTransactions|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // add your code here
    $this->logSection('sum', "starting for user:".$options['user']);
    $accounts = AccountTable::getAllWithTransactions();
    foreach($accounts as $account)
    {
      if(!$account->Transactions->count())
      {
        $this->logSection('sum', "No records for account(".$account->getDisplayName().").");
        continue;
      }
      $pre_tran = null;
      $cur_sec = null;
      $total_amount = 0;
      $total_quantity = 0;
      $total_buy_amount = 0;
      $total_buy_quantity = 0;
      $total_sell_amount = 0;
      $total_sell_quantity = 0;
      $total_other_amount = 0;
      foreach($account->Transactions as $tran)
      {
        if($tran->security_id != $cur_sec)
        {
          $tran->setTransaction(null);
          $total_amount = $tran->amount;
          $total_quantity = $tran->quantity;
          $total_buy_amount = ($tran->quantity > 0)?$tran->amount:0;
          $total_buy_quantity = ($tran->quantity > 0)?$tran->quantity:0;
          $total_sell_amount = ($tran->quantity < 0)?$tran->amount:0;
          $total_sell_quantity = ($tran->quantity < 0)?$tran->quantity:0;
          $total_other_amount = ($tran->quantity == 0)?$tran->amount:0;
          $cur_sec = $tran->security_id;
        }
        else
        {
          $tran->setTransaction($pre_tran);
          $total_amount += $tran->amount;
          $total_quantity += $tran->quantity;
          $total_buy_amount += ($tran->quantity > 0)?$tran->amount:0;
          $total_buy_quantity += ($tran->quantity > 0)?$tran->quantity:0;
          $total_sell_amount += ($tran->quantity < 0)?$tran->amount:0;
          $total_sell_quantity += ($tran->quantity < 0)?$tran->quantity:0;
          $total_other_amount += ($tran->quantity == 0)?$tran->amount:0;
        }
        $tran->total_amount = $total_amount;
        $tran->total_quantity = $total_quantity;
        $tran->total_buy_amount = $total_buy_amount;
        $tran->total_buy_quantity = $total_buy_quantity;
        $tran->total_sell_amount = $total_sell_amount;
        $tran->total_sell_quantity = $total_sell_quantity;
        $tran->total_other_amount = $total_other_amount;

        $pre_tran = $tran;        
      }
      $account->setLastCompute(date('Y-m-d H:i:s'));
      $account->save();
      $this->logSection('sum', "Done computing records for account(".$account->getDisplayName().").");
    }
    $this->logSection('sum', "transaction computation is done.");
    $q1 = Doctrine_Query::create()
        ->select('t.prev_tran')
        ->from('Transaction t')
        ->where('t.prev_tran IS NOT NULL');
    $idList = array();
    foreach($q1->fetchArray() as $t)
    {
      $idList[]=$t['prev_tran'];
    }
    $q = Doctrine_Query::create()
        ->select('t.security_id,t.account_id,t.total_quantity as quantity,t.total_amount as amount,t.total_buy_amount as buy_amount,t.total_sell_amount as sell_amount,t.total_buy_quantity as buy_quantity,t.total_sell_quantity as sell_quantity,t.total_other_amount as other_amount')
        ->from('Transaction t, Transaction d')
        ->whereNotIn('t.id',$idList)
        ->orderBy('t.security_id,t.account_id')
        ;
    $acountSecurity = $q->fetchArray();
    foreach($acountSecurity as $as)
    {
      $aso = Doctrine_Core::getTable('AccountSecurity')->find(array($as['account_id'],$as['security_id']));
      unset($as['id']);
      $aso->fromArray($as);
      $aso->save();
    }
    $this->logSection('sum', "Update AccountSecurity is done");
  }
}
