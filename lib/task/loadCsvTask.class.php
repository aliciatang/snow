<?php

class loadCsvTask extends sfBaseTask
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
    $this->addOption('file',null,sfCommandOption::PARAMETER_OPTIONAL,'The cvs file name');
    $this->addOption('account',null,sfCommandOption::PARAMETER_OPTIONAL,'The account number should be associated to a file');
    //$this->addOption('dir',null,sfCommandOption::PARAMETER_OPTIONAL,'The directory contains all cvs files');
    
    $this->namespace        = 'snow';
    $this->name             = 'loadCsv';
    $this->briefDescription = 'load cvs data to transaction table';
    $this->detailedDescription = <<<EOF
The [loadCSV|INFO] task load cvs data downloaded from scottrade to database.
Call it with:

  [php symfony snow:loadCsv|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // add your code here
    $this->logSection('loadCsv', $options['account'].": ".$options['file']);
    $account = Doctrine::getTable('Account')->findOneByNumber($options['account']);
    if(! $account)
    {
      $this->logSection('loadCsv', 'Cannot find account number:'.$options['account']);
      return;
    }
    $reader = new sfCsvReader($options['file']);
    $reader->setSelectColumns(array(
      'Symbol', 
      'Quantity',
      'Price',
      'ActionNameUS',
      'TradeDate',
      'SettledDate',
      'Amount',
      'Commission',
      'Description',
      'ActionId',
      'TradeNumber'
      ));
    $reader->open();
    $count = 0;
    while ($data = $reader->read())
    {
      $count++;
      // Do something with $data['column_A'] and $data['column_B'];
      $sercurity = SecurityTable::findOneByScottradeId($data['Symbol']);
      $sercurity->save();
      $action = ActionTable::findOneByIdName($data['ActionId'],$data['ActionNameUS']);
      $action->save();
      
      $transaction = new Transaction();
      $account->Transactions[] = $transaction;
      
      $transaction->Security = $sercurity;
      $transaction->quantity = $data['Quantity'];
      $transaction->price = $data['Price'];
      $transaction->trade_date = date('Y-m-d',strtotime($data['TradeDate']));
      $transaction->settled_date = empty($data['SettledDate'])?null:date('Y-m-d',strtotime($data['SettledDate']));
      $transaction->amount = $data['Amount'];
      $transaction->commission = $data['Commission'];
      $transaction->description = $data['Description'];
      $transaction->Action = $action;
      $transaction->Account = $account;
    }
    $reader->close();
    $account->save();
    $this->logSection('loadCsv', $count.' transactions loaded.');
    
  }
}
