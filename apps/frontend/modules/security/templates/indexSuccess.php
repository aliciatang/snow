<?php 
  include_partial('holdingList',
    array('csecurities'=>$csecurities,'hsecurities'=>$hsecurities,'balance'=>$balance));
?>
<?php slot('sidebar') ?>
<h1>Shut up</h1>
<?php include_partial('global/summary', array('accounts'=>$accounts,'twr'=>$twr))?>
<?php
  include_partial('holdingChart',array('csecurities'=>$csecurities,'balance'=>$balance));
?>
<?php end_slot() ?>