<?php


class ActionTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Action');
    }
    public static function findOneByIdName($id,$name)
    {
      $action = self::getInstance()->findOneBy('id',$id);
      if(! $action)
      {
        $action = new Action();
        $action->id = $id;
        $action->name = $name;
      }
      return $action;
    }
}
