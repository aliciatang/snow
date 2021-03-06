<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addprice extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('price', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => 8,
              'autoincrement' => true,
              'primary' => true,
             ),
             'security_id' => 
             array(
              'type' => 'integer',
              'notnull' => true,
              'length' => 8,
             ),
             'date' => 
             array(
              'type' => 'date',
              'notnull' => true,
              'length' => 25,
             ),
             'cprice' => 
             array(
              'type' => 'decimal',
              'scale' => 4,
              'length' => 16,
             ),
             'pchange' => 
             array(
              'type' => 'decimal',
              'scale' => 4,
              'length' => 16,
             ),
             'ppchange' => 
             array(
              'type' => 'decimal',
              'scale' => 4,
              'length' => 16,
             ),
             'open' => 
             array(
              'type' => 'decimal',
              'scale' => 4,
              'length' => 16,
             ),
             'close' => 
             array(
              'type' => 'decimal',
              'scale' => 4,
              'length' => 16,
             ),
             'high' => 
             array(
              'type' => 'decimal',
              'scale' => 4,
              'length' => 16,
             ),
             'low' => 
             array(
              'type' => 'decimal',
              'scale' => 4,
              'length' => 16,
             ),
             'volume' => 
             array(
              'type' => 'integer',
              'length' => 8,
             ),
             'created_at' => 
             array(
              'notnull' => true,
              'type' => 'timestamp',
              'length' => 25,
             ),
             'updated_at' => 
             array(
              'notnull' => true,
              'type' => 'timestamp',
              'length' => 25,
             ),
             ), array(
             'indexes' => 
             array(
              'sdate' => 
              array(
              'fields' => 
              array(
               0 => 'security_id',
               1 => 'date',
              ),
              'type' => 'unique',
              ),
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             'charset' => 'UTF8',
             ));
    }

    public function down()
    {
        $this->dropTable('price');
    }
}