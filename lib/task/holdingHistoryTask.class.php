<?php

class HoldingHistoryTask extends sfBaseTask
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
    $this->name             = 'holdingHistory';
    $this->briefDescription = 'compute the holding history table';
    $this->detailedDescription = <<<EOF
The [performance|INFO] compute the holding history table. 
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
    $this->logSection('hh:', "computing for date:".$options['date']);
    $date = $options['date'];
    $date = '2007-04-07';
    while(strtotime($date) <= time())
    {
      //var_dump($date);echo "\n";
      $ret = Doctrine_Manager::getInstance()
          ->getCurrentConnection()
          ->execute('INSERT INTO `holding_history` (`account_id`,`security_id`,`date`,`quantity`, `market_value`)
                     SELECT t.`account_id`,t.`security_id`,"'.$date.'", sum(`quantity`) as q, p.close*sum(`quantity`)
                     FROM `transaction` t LEFT JOIN `price` p ON p.`security_id`=t.`security_id` WHERE t.`trade_date`<="'.$date.'" && t.`action_id` NOT IN (17,18 ) && p.`date`="'.$date.'"
                     GROUP BY t.`account_id`,t.`security_id` HAVING q <>0
                     ON DUPLICATE KEY UPDATE `quantity`=VALUES(`quantity`), `market_value`=VALUES(`market_value`)');
      $this->logSection('hh:', "computing for date:".$date);
      $tomorrow = strtotime($date) + 25*3600;
      $date = date('Y-m-d', $tomorrow);
      //var_dump($date);return;
    }
  }
    
}
