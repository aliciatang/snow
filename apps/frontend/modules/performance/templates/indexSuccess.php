<script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {'packages':['annotatedtimeline']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', 'Time Weighted Return');
        data.addColumn('number', 'S&P 500');
//        data.addColumn('number', 'Market Value');        
        data.addRows([
<?php foreach($data as $d): ?>
<? $t = strtotime($d['date']); ?>
          [new Date(<?php echo date('Y',$t).','.(date('m',$t)-1).','.date('d',$t) ?>), <?php echo ($d['twr']-1)*100?>,<?php echo $d['close']?>],
<?php endforeach; ?>
        ]);

        var chart = new google.visualization.AnnotatedTimeLine(document.getElementById('chart_div'));
        chart.draw(data, {displayAnnotations: true});
        var data2 = new google.visualization.DataTable();
        data2.addColumn('date', 'Date');
        data2.addColumn('number', 'Deposit');
        data2.addColumn('number', 'Market Value');
        data2.addRows([
<?php foreach($data as $d): ?>
  <? $t = strtotime($d['date']); ?>
            [new Date(<?php echo date('Y',$t).','.(date('m',$t)-1).','.date('d',$t) ?>), <?php echo $d['deposit']?>,<?php echo $d['market_value'];?>],
<?php endforeach; ?>
        ]);
        var chart2 = new google.visualization.AnnotatedTimeLine(document.getElementById('chart_div2'));
        chart2.draw(data2, {displayAnnotations: true});
        
      }
    </script>
<div id="chart_div" style="width:960px;height:500px;margin:10px;"></div>
<div id="chart_div2" style="width:960px;height:500px;margin:10px;"></div>
