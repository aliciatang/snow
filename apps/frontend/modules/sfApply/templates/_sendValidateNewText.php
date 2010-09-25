<?php use_helper('I18N', 'Url') ?>
<?php echo __(<<<EOM
Thanks for applying for an account with %1%.

To prevent abuse of the site, we require that you activate your
account by clicking on the following link:

%2%

Thanks again for joining us.
EOM
, array("%1%" => $sf_request->getHost(),
  "%2%" => url_for("sfApply/confirm?validate=$validate", true))) ?>
