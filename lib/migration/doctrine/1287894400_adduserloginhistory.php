<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Adduserloginhistory extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('user_login_history', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => 8,
              'autoincrement' => true,
              'primary' => true,
             ),
             'ip' => 
             array(
              'type' => 'string',
              'length' => 16,
             ),
             'state' => 
             array(
              'type' => 'string',
              'length' => 6,
             ),
             'user_id' => 
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
             ), array(
             'indexes' => 
             array(
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
        $this->dropTable('user_login_history');
    }
}