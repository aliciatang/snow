<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('price/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('price/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'price/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['security_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['security_id']->renderError() ?>
          <?php echo $form['security_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['date']->renderLabel() ?></th>
        <td>
          <?php echo $form['date']->renderError() ?>
          <?php echo $form['date'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['open']->renderLabel() ?></th>
        <td>
          <?php echo $form['open']->renderError() ?>
          <?php echo $form['open'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['close']->renderLabel() ?></th>
        <td>
          <?php echo $form['close']->renderError() ?>
          <?php echo $form['close'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['high']->renderLabel() ?></th>
        <td>
          <?php echo $form['high']->renderError() ?>
          <?php echo $form['high'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['low']->renderLabel() ?></th>
        <td>
          <?php echo $form['low']->renderError() ?>
          <?php echo $form['low'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['volumn']->renderLabel() ?></th>
        <td>
          <?php echo $form['volumn']->renderError() ?>
          <?php echo $form['volumn'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
