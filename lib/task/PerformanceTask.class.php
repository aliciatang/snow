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
    $accounts = AccountTable::getInstance()->findAll();
    foreach($accounts as $a)
    { 
      $id = $a['id'];
      $ret = Doctrine_Manager::getInstance()
             ->getCurrentConnection()
             ->execute('INSERT INTO `performance` (`account_id`,`date`,`security_market_value`)
                        SELECT '.$id.',p.date, IFNULL(security_market_value,0) as security_market_value 
                        FROM (select distinct date from price where date>= (select min(trade_date) from transaction where account_id='.$id.')) p left join (SELECT`date`,sum(`market_value`) as security_market_value FROM `holding_history` where account_id='.$id.' GROUP BY `date`) b on b.date=p.date order by p.date
                        ON DUPLICATE KEY UPDATE `security_market_value`=VALUES(`security_market_value`)');
    }
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
    $ret = Doctrine_Manager::getInstance()
           ->getCurrentConnection()
           ->execute('INSERT INTO `performance` (`account_id`,`date`,`cash_balance`)
                      SELECT DISTINCT p.`account_id`,date, (SELECT sum(t.`amount`) FROM `transaction` t  WHERE t.`account_id`=p.`account_id` AND t.`trade_date`<=p.`date`) FROM `performance` p
                      ON DUPLICATE KEY UPDATE `cash_balance`=VALUES(`cash_balance`)');
    $ret = Doctrine_Manager::getInstance()
           ->getCurrentConnection()
           ->execute('UPDATE `performance` p SET p.`total_market_value`=p.`security_market_value`+p.`cash_balance`');
    
    $accounts = Doctrine_Manager::getInstance()
                ->getCurrentConnection()
                ->fetchAll('SELECT distinct `account_id` FROM `transaction`');
    //var_dump($accounts);
    foreach($accounts as $a)
    {
      $this->logSection('performance', "... computing account".$a['account_id']);
      $q = Doctrine_Query::create()
             ->from('Performance t')
             ->where('t.account_id = ?', $a['account_id'])
             ->orderBy('t.date');
      $performances = $q->execute();
      $performances[0]->time_weighted_return=1;
      $performances[0]->save();
     // if($a['id']==2)var_dump($performances[0]->toArray());
      for($i = 1; $i < $performances->count(); $i++)
      {
        if($performances[$i-1]->total_market_value==0)var_dump($performances[$i-1]->toArray());
        $performances[$i]->time_weighted_return=($performances[$i]->total_market_value-$performances[$i]->deposit)/($performances[$i-1]->total_market_value)*$performances[$i-1]->time_weighted_return;
        $performances[$i]->save();
      //  if($a['id']==2)var_dump($performances[$i]->toArray());
      }
    }
  }
}
