<?php

class DalyPerformanceTask extends sfBaseTask
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
    $this->addOption('date',null,sfCommandOption::PARAMETER_REQUIRED,'the date to compute');
    $this->addOption('account',null,sfCommandOption::PARAMETER_REQUIRED,'account id not account number');
    
    $this->namespace        = 'snow';
    $this->name             = 'dp';
    $this->briefDescription = 'Re-compute the sum for each transactions';
    $this->detailedDescription = <<<EOF
The [performance|INFO] compute the performance for the given date. 
Use this to patch the performance tabe if any date is missing.
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
           ->fetchAll('SELECT *  FROM `holding_history` WHERE `account_id`='.$options['account'].' && date = 
                      (SELECT MAX(date) FROM `holding_history` WHERE `date` <=\''.$options['date'].'\' && account_id='.$options['account'].')');
    $performance =Doctrine::getTable('Performance')->createQuery('p')
              ->where('account_id = ?',$options['account'])
              ->andWhere('date = ?', $options['date'])
              ->fetchOne();
    if(! $performance )
    {
      $ret = Doctrine_Manager::getInstance()
             ->getCurrentConnection()
             ->fetchAll('SELECT *  FROM `performance` WHERE `account_id`='.$options['account'].' && date = 
                        (SELECT MAX(date) FROM `performance` WHERE `date` <=\''.$options['date'].'\' && account_id='.$options['account'].')');
      //var_dump($ret);
      $p = new Performance();
      $p->account_id=$options['account'];
      $p->date = $options['date'];
      $p->cash_balance = $ret[0]['cash_balance'];
      $p->total_market_value = $ret[0]['total_market_value'];
      $p->time_weighted_return = $ret[0]['time_weighted_return'];
      $p->save();
    }
    //var_dump($performance->toArray());
  }
}
