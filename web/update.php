<?php
$snow='/mnt/hgfs/snow/project/symfony  snow:';
$date=date('Y-m-d',strtotime('-10 days'));
system('/mnt/hgfs/snow/project/symfony  snow:loadHistoryPrice --symbol="SPY" --start="'.$date.'"');
system('/mnt/hgfs/snow/project/symfony  snow:sumUpTransactions');
system($snow.'holding');
system($snow.'loadHistoryPrice --start="'.$date.'"');
system($snow.'updateP');
system($snow.'perf');
?>
