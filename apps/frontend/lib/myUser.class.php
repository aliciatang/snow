<?php

class myUser extends sfGuardSecurityUser
{
  function __construct(sfEventDispatcher $ed, sfStorage $st)
  {
    parent::__construct($ed,$st);
    $this->init();
  }
  /**
   * cache Accounts of the user which have records 
   * and compute the market value and gains for the latest date on record.
   * @return Array an array with key as account_id (or Total), 
   * and contains columns for 
   *         number: **** dd 
   *         account_type:
   *         mkt_value:
   *         balance:
   *         deposit:    
   */
  private function init()
  {
    if(!$this->isAuthenticated()) return;
    $accounts = $this->getAttribute('accounts',array());
    if(!empty($accounts)) return;
    $accounts['total']['number'] = 'Total';
    $accounts['total']['type'] = 'All';
    $accounts['total']['balance'] = 0;
    $accounts['total']['mkt_value'] = 0;
    $accounts['total']['deposit'] = 0;
    $accounts['total']['gain'] = 0;
    foreach($this->getGuardUser()->getAccounts() as $a)
    {
      $b = $a->getBalance();
      $m = $a->getMarketValue();
      $d = $a->getDeposit();
      $g = $m+$b-$d;
      $accounts[$a['id']] = array(
        'id' => $a['id'],
        'number'=>'**** '.substr($a['number'],-2),
        'type' =>$a['type'],
        'balance' => $b,
        'mkt_value' =>$m,
        'deposit' => $d,
        'gain' => $g,
        'pgain'=> ($d)?($g/$d*100):0
        );
      $accounts['total']['balance']   +=$b;
      $accounts['total']['mkt_value'] +=$m;
      $accounts['total']['deposit']   +=$d;
      $accounts['total']['gain']      +=$g;
    }
    $accounts['total']['pgain'] = $accounts['total']['gain']/$accounts['total']['deposit']*100;
    //var_dump(count($accounts));
    $this->setAttribute('accounts',$accounts); 
  }

}
