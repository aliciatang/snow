<?php

/**
 * performance actions.
 *
 * @package    valueInvest
 * @subpackage performance
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class performanceActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->data = PerformanceTable::getPerformanceData();
    $twr = count($this->data)-2;
    $twr = $this->data[$twr]['twr'];
    $this->getUser()->setAttribute('twr',$twr);
  }
}
