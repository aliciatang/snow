<?php use_helper('I18N') ?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<div class="sf_apply sf_apply_reset_request">
<form method="POST" action="<?php echo url_for('sfApply/resetRequest') ?>"
  name="sf_apply_reset_request" id="sf_apply_reset_request">
<p>
<?php echo __(<<<EOM
Forgot your username or password? No problem! Just enter your username <strong>or</strong>
your email address and click "Reset My Password." You will receive an email message containing both your username and
a link permitting you to change your password if you wish.
EOM
) ?>
</p>
<ul>
<?php echo $form ?>
<li>
<input type="submit" value="<?php echo __("Reset My Password") ?>"> 
<?php echo __("or") ?> 
<?php echo link_to(__('Cancel'), sfConfig::get('app_sfApplyPlugin_after', '@homepage')) ?>
</li>
</ul>
</form>
</div>
