<?php

class updatePriceTask extends sfBaseTask
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
    $this->addOption('user',null,sfCommandOption::PARAMETER_OPTIONAL,'for a specified user');
    //$this->addOption('dir',null,sfCommandOption::PARAMETER_OPTIONAL,'The directory contains all cvs files');
    
    $this->namespace        = 'snow';
    $this->name             = 'updatePrice';
    $this->briefDescription = 'update the price of stock currently holding from yahoo to price table';
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
    $this->logSection('updatePrice', $options['user'].": ".$options['user']);
    $list = Doctrine_Manager::getInstance()
            ->getCurrentConnection()
            ->fetchColumn('SELECT DISTINCT s.`yahoo_id` FROM `account_security` sa LEFT JOIN (`security` s) on s.`id` = sa.`security_id`  WHERE sa.`quantity` >0 AND s.`id`>1 && s.`market` <>\'OPTION\'',array(1),0);
    Yahoo::loadPrices($list);
  }
}
