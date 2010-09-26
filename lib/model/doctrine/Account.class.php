<?php

/**
 * Account
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    valueInvest
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Account extends BaseAccount
{
  public function getDisplayName()
  {
    return ucfirst($this->getAgency()).": ****".substr($this->getNumber(),-4);
  }
  public function getDisplayNumber()
  {
    return "****".substr($this->getNumber(),-4);
  }
}
