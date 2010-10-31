<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addpricealert extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('price_alert', array(
             'user_id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'length' => 8,
             ),
             'alert_id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'length' => 8,
             ),
             'security_id' => 
             array(
              'type' => 'integer',
              'length' => 8,
             ),
             'description' => 
             array(
              'type' => 'text',
              'length' => NULL,
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
              'SU' => 
              array(
              'fields' => 
              array(
               0 => 'security_id',
               1 => 'user_id',
              ),
              'type' => 'unique',
              ),
             ),
             'primary' => 
             array(
              0 => 'user_id',
              1 => 'alert_id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
    }

    public function down()
    {
        $this->dropTable('price_alert');
    }
}