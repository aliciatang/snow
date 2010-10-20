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
    $this->accounts = $this->getUser()->getGuardUser()->getAccounts();
    $this->getUser()->setAttribute('accounts',$this->accounts);
    //SecurityTable::loadPrice();
  }
  /**
    * Executes show action
    *
    * @param sfRequest $request A request object
    */
  public function executeShow(sfWebRequest $request)
  {
    $id=$request->getParameter('id');
    if(! $accounts = $this->getUser()->getAttribute('accounts'))
    {
      $accounts = $this->getUser()->getGuardUser()->getAccounts();
      $this->getUser()->setAttribute('accounts',$accounts);
    }
    $this->balance = $accounts['total'];
    $this->account = $accounts[$id];
    $this->csecurities = AccountTable::getHoldings($id,'current');
    $this->hsecurities = AccountTable::getHoldings($id,'history');
    
  }
}
