<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestFunctional(new sfBrowser());
$test    = $browser->test();
$conn    = Doctrine::getConnectionByTableName('account');

$conn->beginTransaction();
$browser
  ->call('/account/index', 'GET', array())
  ->with('request')->begin()
    ->isForwardedTo('sfGuardAuth', 'signin')
  ->end()
  ->with('response')->begin()
    ->isStatusCode(401)
  ->end()
;

$browser
  ->call('/login', 'POST', array (
  'signin' => 
  array (
    'username' => 'admin',
    'password' => 'junesnow',
    'remember' => 'on',
  ),
))
  /*   ->get('/login')
  ->click('alt or value of submit here', array (
  'signin' => 
  array (
    'username' => 'admin',
    'password' => 'junesnow',
    'remember' => 'on',
  ),
)) */ 
  ->with('request')->begin()
    ->isParameter('module', 'sfGuardAuth')
    ->isParameter('action', 'signin')
  ->end()
;
$browser
  ->with('response')->begin()
    ->isRedirected(1)
    ->isStatusCode(302)
  ->end()
  ->followRedirect()
;

$browser
  ->with('request')->begin()
    ->isParameter('module', 'account')
    ->isParameter('action', 'index')
  ->end()
  ->with('response')->begin()
    ->isStatusCode(200)
  ->end()
;



$conn->rollback();
