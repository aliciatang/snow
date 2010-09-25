<?php

/**
 * price actions.
 *
 * @package    valueInvest
 * @subpackage price
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class priceActions extends sfActions
{
  public function preExecute()
  {
    $this->user = $this->getUser()->getGuardUser();;
  }
  public function executeIndex(sfWebRequest $request)
  {
    SecurityTable::loadPrice();
    $this->prices = Doctrine::getTable('Price')->findAll();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->price = Doctrine::getTable('Price')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->price);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PriceForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PriceForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($price = Doctrine::getTable('Price')->find(array($request->getParameter('id'))), sprintf('Object price does not exist (%s).', $request->getParameter('id')));
    $this->form = new PriceForm($price);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($price = Doctrine::getTable('Price')->find(array($request->getParameter('id'))), sprintf('Object price does not exist (%s).', $request->getParameter('id')));
    $this->form = new PriceForm($price);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($price = Doctrine::getTable('Price')->find(array($request->getParameter('id'))), sprintf('Object price does not exist (%s).', $request->getParameter('id')));
    $price->delete();

    $this->redirect('price/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $price = $form->save();

      $this->redirect('price/edit?id='.$price->getId());
    }
  }
}
