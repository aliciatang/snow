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
  public function executeIndex(sfWebRequest $request)
  {
    $this->securitys = Doctrine::getTable('Security')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->security = Doctrine::getTable('Security')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->security);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new SecurityForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new SecurityForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($security = Doctrine::getTable('Security')->find(array($request->getParameter('id'))), sprintf('Object security does not exist (%s).', $request->getParameter('id')));
    $this->form = new SecurityForm($security);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($security = Doctrine::getTable('Security')->find(array($request->getParameter('id'))), sprintf('Object security does not exist (%s).', $request->getParameter('id')));
    $this->form = new SecurityForm($security);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($security = Doctrine::getTable('Security')->find(array($request->getParameter('id'))), sprintf('Object security does not exist (%s).', $request->getParameter('id')));
    $security->delete();

    $this->redirect('security/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $security = $form->save();

      $this->redirect('security/edit?id='.$security->getId());
    }
  }
}
