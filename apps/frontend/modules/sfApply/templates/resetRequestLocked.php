<?php use_helper('I18N') ?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<div class="sf_apply_notice">
<?php echo __(<<<EOM
<p>
This account is inactive. Please contact the administrator.
</p>
EOM
) ?>
<?php include_partial('sfApply/continue') ?>
</div>
