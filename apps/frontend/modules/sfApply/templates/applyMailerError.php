<?php use_helper('I18N') ?>
<div class="sf_apply_notice">
<?php echo __(<<<EOM
<p>
An error took place during the email delivery process. Please try
again later.
</p>
EOM
) ?>
<?php include_partial('sfApply/continue') ?>
</div>
