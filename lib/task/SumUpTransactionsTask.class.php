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
  }
}
