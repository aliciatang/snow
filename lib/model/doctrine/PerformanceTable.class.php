<?php

/**
 * PerformanceTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PerformanceTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PerformanceTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Performance');
    }
    public static function getPerformanceData()
    {
      $ret = Doctrine_Manager::getInstance()
             ->getCurrentConnection()
             ->fetchAll('select * from (select date, sum(deposit) as deposit, sum(total_market_value) as market_value from performance group by date) a join (select date, close from price where security_id=39 ) p ON p.date=a.date ');
      $ret[0]['twr']=1;
      for($i=1; $i<count($ret); $i++)
      {
        $ret[$i]['twr']=($ret[$i]['market_value']-$ret[$i]['deposit'])/$ret[$i-1]['market_value'];
      }
      for($i=1; $i<count($ret); $i++)
      {
        $ret[$i]['twr'] *=$ret[$i-1]['twr'];
        $ret[$i]['close'] =($ret[$i]['close']/$ret[0]['close']-1)*100;
        //echo $ret[$i]['twr']."<br>";
      }
      $ret[0]['close']=0;
      return $ret;
    }
}