<?php

class loadHistoryPriceTask extends sfBaseTask
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
    $this->addOption('symbol',null,sfCommandOption::PARAMETER_OPTIONAL,'symbol');
    $this->addOption('start',null,sfCommandOption::PARAMETER_OPTIONAL,'start date');
    $this->addOption('end',null,sfCommandOption::PARAMETER_OPTIONAL,'end date');
    
    $this->namespace        = 'snow';
    $this->name             = 'loadHistoryPrice';
    $this->briefDescription = 'load history price from yahoo';
    $this->detailedDescription = <<<EOF
The snow:[loadHistoryPrice|INFO] task does things.
Call it with:

  [php symfony snow:loadHistoryPrice|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    
    // add your code here
    $this->logSection('history', $options['symbol'].": ".$options['start']."~".$options['end']);
    $url = Yahoo::$historyUrl."&s=".$symbol;
    $min = min($options['start'],$options['end']);
    $max = max($options['start'],$options['end']);
    $url .= "&a=".date('j',strtotime($min));
    $url .= "&b=".date('d',strtotime($min));
    $url .= "&c=".date('Y',strtotime($min));
    
    $url .= "&d=".date('j',strtotime($max));
    $url .= "&e=".date('d',strtotime($max));
    $url .= "&f=".date('Y',strtotime($max));
    $url .= '&g=d';
    $url .= '&ignore=.csv';
    echo $url."\n";
    ini_set('user_agent', 'PHP/4.3.3');
    $file = fopen($url,'r');
    $reader = new sfCsvReader($url);
    
  }
}
