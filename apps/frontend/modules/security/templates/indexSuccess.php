<?php 
  include_partial('holdingList',
    array('csecurities'=>$csecurities,'hsecurities'=>$hsecurities,'balance'=>$balance));
?>
<?php
  include_partial('holdingChart',array('csecurities'=>$csecurities,'balance'=>$balance));
?>