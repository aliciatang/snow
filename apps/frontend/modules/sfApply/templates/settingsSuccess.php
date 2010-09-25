<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<?php use_helper("I18N") ?>
<div class="sf_apply sf_apply_settings">
<h2><?php echo __("Account Settings") ?></h2>
<form method="POST" action="<?php echo url_for("sfApply/settings") ?>" name="sf_apply_settings_form" id="sf_apply_settings_form">
<ul>
<?php echo $form ?>
<li>
<input type="submit" value="<?php echo __("Save") ?>" /> <?php echo(__("or")) ?>
<?php echo link_to(__('Cancel'), sfConfig::get('app_sfApplyPlugin_after', '@homepage')) ?>
</li>
</ul>
</form>
<form method="GET" action="<?php echo url_for("sfApply/resetRequest") ?>" name="sf_apply_reset_request" id="sf_apply_reset_request">
<p>
<?php echo __(<<<EOM
Click the button below to change your password. For security reasons, you 
will receive a confirmation email containing a link allowing you to complete 
the password change. 
EOM
) ?>
</p>
<input type="submit" value="<?php echo __("Reset Password") ?>" />
</form>
</div>
