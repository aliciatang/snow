<?php

/**
 * PriceAlert form.
 *
 * @package    valueInvest
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PriceAlertForm extends BasePriceAlertForm
{
  public function configure()
  {
    $this->alert = $this->getObject()->getAlert();
    if(! is_Object($this->alert))
    {
      $this->alert = new Alert();
      $this->getObject()->setAlert($this->alert);
    }
    $this->removeFields();
    $alertForm = new AlertForm($this->alert);
    $this->embedForm('alert',$alertForm);
    if($this->isNew())
    {
      $this->getObject()->setUser( $this->getOption('user') );
    }
  }
  protected function removeFields()
  {
    unset(
      $this['created_at'], 
      $this['updated_at'],
      $this['alert_id'],
      $this['user_id']
    );
  }

}
