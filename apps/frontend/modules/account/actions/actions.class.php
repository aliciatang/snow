<?php

/**
 * account actions.
 *
 * @package    valueInvest
 * @subpackage account
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class accountActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //accounts ia an array not a doctrine_collection  
    $this->accounts = $this->getUser()->getGuardUser()->getAccountsWithCurrentHoldings();
    //SecurityTable::loadPrice();
  }
}
