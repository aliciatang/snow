<?php

/**
 * price_alert actions.
 *
 * @package    valueInvest
 * @subpackage price_alert
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class price_alertActions extends sfActions
{
  public function preExecute()
  {
     $this->user = $this->getUser()->getGuardUser();
  }
  public function executeIndex(sfWebRequest $request)
  {
    $this->price_alerts = Doctrine::getTable('PriceAlert')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->price_alert = Doctrine::getTable('PriceAlert')->find(array($request->getParameter('user_id'),
                                            $request->getParameter('alert_id'),
                                            $request->getParameter('security_id')));
    $this->forward404Unless($this->price_alert);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PriceAlertForm(null,array('user'=>$this->user));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PriceAlertForm(null,array('user'=>$this->user));
    $this->form->bind(
      $request->getParameter($this->form->getName()), 
     $request->getFiles($this->form->getName())
    );
    if(!$this->form->isValid())
    {
     $this->setTemplate('new');
    }
    $alert = $this->form->save();
    $this->redirect('price_alert/index');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($price_alert = Doctrine::getTable('PriceAlert')->find(array($request->getParameter('user_id'),
                      $request->getParameter('alert_id'),
                      $request->getParameter('security_id'))), sprintf('Object price_alert does not exist (%s).', $request->getParameter('user_id'),
                      $request->getParameter('alert_id'),
                      $request->getParameter('security_id')));
    $this->form = new PriceAlertForm($price_alert);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($price_alert = Doctrine::getTable('PriceAlert')->find(array($request->getParameter('user_id'),
                      $request->getParameter('alert_id'),
                      $request->getParameter('security_id'))), sprintf('Object price_alert does not exist (%s).', $request->getParameter('user_id'),
                      $request->getParameter('alert_id'),
                      $request->getParameter('security_id')));
    $this->form = new PriceAlertForm($price_alert);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($price_alert = Doctrine::getTable('PriceAlert')->find(array($request->getParameter('user_id'),
                      $request->getParameter('alert_id'),
                      $request->getParameter('security_id'))), sprintf('Object price_alert does not exist (%s).', $request->getParameter('user_id'),
                      $request->getParameter('alert_id'),
                      $request->getParameter('security_id')));
    $price_alert->delete();

    $this->redirect('price_alert/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $price_alert = $form->save();

      $this->redirect('price_alert/edit?user_id='.$price_alert->getUserId().'&alert_id='.$price_alert->getAlertId().'&security_id='.$price_alert->getSecurityId());
    }
  }
}
