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
    $this->accounts = $this->getUser()->getAttribute('accounts');
    $this->balance = $this->accounts['total'];
    $this->twr = $this->getUser()->getAttribute('twr');
    $this->csecurities = $this->getUser()->getGuardUser()->getSecurities('current');
    $this->hsecurities = $this->getUser()->getGuardUser()->getSecurities('history');
  }
}
