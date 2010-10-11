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
    Doctrine_Manager::getInstance()
            ->getCurrentConnection()
            ->execute('INSERT INTO `account_security`(`account_id`, `security_id`,`quantity`,`buy_quantity`,`sell_quantity`,`sell_amount`,`buy_amount`,`amount`,`dividend`) 
            SELECT t.`account_id`, t.`security_id`,
              SUM(t.`quantity`) as `quantity`,
              SUM(if(t.`quantity`>0,t.`quantity`,if(t.`security_id`=1 && t.`amount`>0 && t.`action_id` NOT IN (2,4,7),t.`amount`,0))) as `buy_quantity`,
              SUM(if(t.`quantity`<0 ,t.`quantity`,if(t.`security_id`=1 && t.`amount`<0 && t.`action_id` NOT IN (2,4,7),t.`amount`,0))) as `sell_quantity`, 
              SUM(if(t.`amount`>0 && t.`action_id` NOT IN (116,2,4,7),t.`amount`,0)) as `sell_amount`, 
              SUM(if(t.`amount`<0 && t.`action_id` NOT IN (116,2,4,7),t.`amount`,0)) as `buy_amount`, 
              SUM(t.`amount`) as `amount`, sum(if(action_id IN (116,2,4,7),t.amount,0)) as `dividend` 
            FROM `transaction` t  
            WHERE t.`action_id` NOT IN (17,18) 
            GROUP BY t.`security_id`,t.`account_id` 
            ON DUPLICATE KEY UPDATE `quantity`=VALUES(`quantity`),`buy_quantity`=VALUES(`buy_quantity`),`sell_quantity`=VALUES(`sell_quantity`),`sell_amount`=VALUES(`sell_amount`),`buy_amount`=VALUES(`buy_amount`),`amount`=VALUES(`amount`),`dividend`=VALUES(`dividend`)');
    Doctrine_Manager::getInstance()
            ->getCurrentConnection()
            ->execute('INSERT INTO `account_security`(`account_id`, `security_id`,`quantity`,`amount`) 
            SELECT t.`account_id`,"1",sum(t.`amount`),sum(t.`amount`) 
            FROM `transaction` t 
            GROUP BY t.`account_id` 
            ON DUPLICATE KEY UPDATE `quantity`=VALUES(`quantity`),`amount`=VALUES(`amount`)');
  }
}
