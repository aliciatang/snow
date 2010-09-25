<?php


class PriceTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Price');
    }
    public static function findOneBySdate( $sid, $date)
    {
	$ret = Doctrine_Query::create()
		->from('Price p') 
		->where('p.security_id =?',$sid)
		->andWhere('p.date = ?',$date)
		->fetchOne();
        return $ret;
    }
}
