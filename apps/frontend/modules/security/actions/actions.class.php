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
    $this->securities = $this->getUser()->getGuardUser()->getSecurities('all');
  }
}
