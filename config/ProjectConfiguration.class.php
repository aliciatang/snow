<?php

require_once dirname(__FILE__).'/../lib/vendor/1.4/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    set_include_path('/usr/local/php5/include/php'.PATH_SEPARATOR . get_include_path());
    set_include_path('/usr/local/php5/include/php' . get_include_path());
    $this->enablePlugins('sfDoctrinePlugin');
    $this->enablePlugins('sfDoctrineGuardPlugin');
    $this->enablePlugins('sfDoctrineApplyPlugin');
    $this->enablePlugins('sfDoctrineGuardLoginHistoryPlugin');
    $this->enablePlugins('sfCsvPlugin');
  }
}
