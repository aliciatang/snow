<?php

/**
 * sfGuardUser form.
 *
 * @package    valueInvest
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserForm extends PluginsfGuardUserForm
{
  public function configure()
  {
    $this->removeFields();
  }
  protected function removeFields()
  {
    unset(
      $this['created_at'], $this['updated_at']
    );
  }

}
