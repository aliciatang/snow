<?php
class Scottrade
{
  private static $stockUrl='http://research.scottrade.com/public/stocks/';
  private static $tabs=array(
    'summary'=>'snapshot/snapshot.asp?symbol=',
    'news'=>'news/news.asp?symbol=',
    'charts'=>'charts/charts.asp?symbol=',
    'options'=>'options/options.asp?symbol=',
    'fundamentals'=>'fundamentals/fundamentals.asp?symbol=',
    'insiders'=>'insiders/insiders.asp?symbol=',
    'earnings'=>'earnings/earnings.asp?symbol=',
    'financials'=>'financials/financials_is.asp?symbol=',
    'SEC filings'=>'secfilings/secfilings.asp?symbol='
    );
  
}
?>