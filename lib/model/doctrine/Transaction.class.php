<?php

/**
 * Transaction
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    valueInvest
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Transaction extends BaseTransaction
{
  public function preInsert($event)
  {
    if($this->action_id == 16 && $this->description == 'MONEY DIRECT DEPOSIT')
    {
      $this->action_id = 109;
    }
  }
}
