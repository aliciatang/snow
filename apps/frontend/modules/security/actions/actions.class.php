<?php

/**
 * security actions.
 *
 * @package    valueInvest
 * @subpackage security
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class securityActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    if(! $accounts = $this->getUser()->getAttribute('accounts'))
    {
      $accounts = $this->getUser()->getGuardUser()->getAccounts();
      $this->getUser()->setAttribute('accounts',$accounts);
    }
    $this->balance = $accounts['total'];
    $this->csecurities = $this->getUser()->getGuardUser()->getSecurities('current');
    $this->hsecurities = $this->getUser()->getGuardUser()->getSecurities('history');
  }
}
