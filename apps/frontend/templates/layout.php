<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <script type="text/javascript">/* <![CDATA[ */
    <?php if (has_slot('jQuery')): ?>
      jQuery(document).ready(function(){
      	<?php include_slot('jQuery');?>
      });
    <?php endif;?>
    /* ]]> */</script>
  </head>
  <body>
    <?php include_partial('global/header')?>
    <div id="body_back">
    <div class="container_12">
      <div id="content" class="grid_8 alpha">
	<?php echo $sf_content ?>
      </div>
      <div id="sidebar" class="grid_4 alpha">
      <?php include_slot('sidebar')?>
      </div>
    </div>
    </div>
    <?php include_partial('global/footer')?>
  </body>
</html>
