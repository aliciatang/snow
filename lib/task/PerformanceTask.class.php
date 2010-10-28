<?php

class PerformanceTask extends sfBaseTask
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
    $this->addOption('date',null,sfCommandOption::PARAMETER_OPTIONAL,'the date to compute','all');
    
    $this->namespace        = 'snow';
    $this->name             = 'performance';
    $this->briefDescription = 'Re-compute the sum for each transactions';
    $this->detailedDescription = <<<EOF
The [performance|INFO] compute the performance for the given date. 
Call it with:

  [php symfony snow:performance|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // add your code here
    $this->logSection('performance', 'computing market value');
    $ret = Doctrine_Manager::getInstance()
           ->getCurrentConnection()
           ->execute('INSERT INTO `performance` (`account_id`,`date`,`security_market_value`)
                      SELECT `account_id`,`date`,sum(`market_value`) 
                      FROM `holding_history`
                      GROUP BY `account_id`,`date`
                      ON DUPLICATE KEY UPDATE `security_market_value`=VALUES(`security_market_value`)');
    $this->logSection('performance', 'computing deposit');
    $ret = Doctrine_Manager::getInstance()
           ->getCurrentConnection()
           ->execute('INSERT INTO `performance` (`account_id`,`date`,`deposit`)
                      SELECT `account_id`,`trade_date`,sum(`amount`) 
                      FROM `transaction`
                      WHERE `security_id`=1 AND `amount`>0 AND `action_id` NOT IN (2,4,7,116)
                      GROUP BY `account_id`,`trade_date`
                      ON DUPLICATE KEY UPDATE `deposit`=VALUES(`deposit`)');
    
    $this->logSection('performance', 'computing cash balance');
    $performances = PerformanceTable::getInstance()->findAll();
    foreach($performances as $p )
    {
      $ret = Doctrine_Manager::getInstance()
             ->getCurrentConnection()
             ->fetchAll('SELECT `total_amount`  FROM `transaction` WHERE `account_id`='.$p['account_id'].' && `trade_date` = 
                        (SELECT MAX(trade_date) FROM `transaction` WHERE `trade_date` <=\''.$p['date'].'\' && account_id='.$p['account_id'].')
                        ORDER BY `id` DESC');
      $p->cash_balance = $ret[0]['total_amount'];
      $p->save();
    }
    $ret = Doctrine_Manager::getInstance()
           ->getCurrentConnection()
           ->execute('UPDATE `performance` p SET p.`total_market_value`=p.`security_market_value`+p.`cash_balance`');
    $accounts = AccountTable::getInstance()->findAll();
    foreach($accounts as $a)
    {
      $this->logSection('performance', "... computing account".$a['id']);
      $q = Doctrine_Query::create()
             ->from('Performance t')
             ->where('t.account_id = ?', $a['id'])
             ->orderBy('t.date');
      $performances = $q->execute();
      $performances[0]->time_weighted_return=1;
      $performances[0]->save();
     // if($a['id']==2)var_dump($performances[0]->toArray());
      for($i = 1; $i < $performances->count(); $i++)
      {
       // if($a['id']==2)var_dump($performances[$i]->toArray());
        $performances[$i]->time_weighted_return=($performances[$i]->total_market_value-$performances[$i]->deposit)/($performances[$i-1]->total_market_value)*$performances[$i-1]->time_weighted_return;
        $performances[$i]->save();
      //  if($a['id']==2)var_dump($performances[$i]->toArray());
      }
    }
  }
}
