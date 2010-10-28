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
    if(! $options['symbol'])
    {
      $ret = Doctrine_Manager::getInstance()
            ->getCurrentConnection()
            ->fetchAll('SELECT s.`yahoo_id` as `symbol`,max(t.`trade_date`) as `date1`, min(t.`trade_date`) as `date2` FROM `transaction` t LEFT JOIN `security` s ON s.id = t.security_id  WHERE `security_id` <> 1 && s.`market` <> "OPTION" GROUP BY `security_id`');
      if(empty($ret))
      {
        $this->logSection(get_class($this),'No transactions in database, no need to update price.');
      }
      //var_dump($ret);die;
      foreach($ret as $s)
      {
        $this->updateOne($s['symbol'],date('Y-m-d'),max($s['date2'],$options['start']));
      }
    }
    else
    {
      $this->updateOne($options['symbol'],date('Y-m-d'),$options['start']);
    }
  }
  private function updateOne($symbol,$date1,$date2)
  {

    $this->logSection(__function__,'updating ...'.$symbol.": ".$date1."~".$date2);
    $url = Yahoo::$historyUrl."s=".$symbol;
    $min = min(strtotime($date1),strtotime($date2));
    $max = max(strtotime($date1),strtotime($date2));

    $url .= "&a=".(date('m',$min)-1);
    $url .= "&b=".date('d',$min);
    $url .= "&c=".date('Y',$min);
    
    $url .= "&d=".(date('m',$max)-1);
    $url .= "&e=".date('d',$max);
    $url .= "&f=".date('Y',$max);
    $url .= '&g=d';
    $url .= '&ignore=.csv';
    try
    {
      $reader = new sfCsvReader($url);
      $reader->setSelectColumns(array(
        'Date','Open','High','Low','Close','Volume'
        ));
      $reader->open();
      $count=0;
      $security = SecurityTable::findOneByYahooId($symbol);
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
        $price->low = $data['Low'];
        $price->open = $data['Open'];
        $price->high = $data['High'];
        $price->close = $data['Close'];
        $price->volume = $data['Volume'];
        $price->save();
      }
      $reader->close();
    } 
    catch (Exception $e) 
    {
      $this->logSection(__function__,$e->getMessage());
    }
  }
}
