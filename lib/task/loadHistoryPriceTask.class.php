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
    $url = Yahoo::$historyUrl."s=".$options['symbol'];
    $min = min(strtotime($options['start']),strtotime($options['end']));
    $max = max(strtotime($options['start']),strtotime($options['end']));
    $url .= "&a=".(date('m',$min)-1);
    $url .= "&b=".date('d',$min);
    $url .= "&c=".date('Y',$min);
    
    $url .= "&d=".(date('m',$max)-1);
    $url .= "&e=".date('d',$max);
    $url .= "&f=".date('Y',$max);
    $url .= '&g=d';
    $url .= '&ignore=.csv';
    echo $url."\n";
    $reader = new sfCsvReader($url);
    $reader->setSelectColumns(array(
      'Date','Open','High','Low','Close','Volume'
      ));
    $reader->open();
    $count=0;
    $security = SecurityTable::findOneByScottradeId($options['symbol']);
    while ($data = $reader->read())
    {
      $count++;
      $price = Doctrine_Query::create()
          ->from('Price p')
          ->where('security_id = ? AND date=?',array($security->id,$data['Date']))
          ->fetchOne();
      if(!$price)
      {
        $price = new Price();
        $price->setSecurity($security);
        $price->setDate($data['Date']);
        $security->Price[] = $price;
      }
      $price->low=$data['Low'];
      $price->open=$data['Open'];
      $price->high=$data['High'];
      $price->close=$data['Close'];
      $price->volume=$data['Volume'];
    }
    $reader->close();
    $security->getPrice()->save();
    echo $count;
  }
}
