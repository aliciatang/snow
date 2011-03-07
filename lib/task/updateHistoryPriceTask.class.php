<?php

class updateHistoryPriceTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name','backend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));
    $this->addOption('symbol',null,sfCommandOption::PARAMETER_OPTIONAL,'symbol');
    //$this->addOption('dir',null,sfCommandOption::PARAMETER_OPTIONAL,'The directory contains all cvs files');
    
    $this->namespace        = 'snow';
    $this->name             = 'update-history-price';
    $this->briefDescription = 'update historical price from yahoo';
    $this->detailedDescription = <<<EOF
The [updatePrice|INFO] task update the price of stock currently holding from yahoo to price table.
Call it with:

  [php symfony snow:updatePrice|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // add your code here
    $list = array();
    if(! $options['symbol'])
    {
       $q = SecurityTable::getInstance()
            ->createQuery('s')
            ->select('s.yahoo_id')
            ->where('s.status = ?', 'listed')
            ->andWhere("s.market <> 'OPTION' ")
            ->andWhere("s.market <> '' ")
            ->fetchArray(array(),Doctrine::HYDRATE_SCALAR  );
       foreach($q as $s) $list[]=$s['yahoo_id'];
    }
    else $list =array($options['symbol']);
    foreach($list as $s)
    {
      Yahoo::historyPrices($s,'2007-4-7','2011-3-3');
    }
    //Yahoo::loadHistoryPrices($list);
  }
}
