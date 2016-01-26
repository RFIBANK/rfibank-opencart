<?php
/**
 * Модуль оплаты через ЗАО "РФИ БАНК" https://rficb.ru,
 */
?>
<?php echo $header; ?>  <?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-rficb" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="container-fluid">
     <div class="panel-body">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-rficb">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_rficb_name; ?></td>
            <td><input type="text" name="rficb_name" value="<?php echo $rficb_name; ?>" />
              <?php if (isset($_error['rficb_name'])) { ?>
              <span class="error"><?php echo $_error['rficb_name']; ?></span>
              <?php } ?></td>
          </tr>

          <tr>
            <td> <?php echo $entry_rficb_callback; ?></td>
            <td><?php echo HTTP_CATALOG.'index.php?route=payment/rficb/callback'; ?></td>
          </tr>
          <tr>
            <td> <?php echo $entry_rficb_success; ?></td>
            <td><?php echo HTTP_CATALOG.'index.php?route=checkout/success'; ?></td>
          </tr>
          <tr>
            <td> <?php echo $entry_rficb_error; ?></td>
            <td><?php echo HTTP_CATALOG.'index.php?route=payment/rficb/error'; ?></td>
          </tr>

          <tr>
            <td><span class="required">*</span> <?php echo $entry_rficb_secret; ?></td>
            <td><input type="text" name="rficb_secret" value="<?php echo $rficb_secret; ?>" />
              <?php if (isset($_error['rficb_secret'])) { ?>
              <span class="error"><?php echo $_error['rficb_secret']; ?></span>
              <?php } ?></td>
          </tr>
          
          
          <tr>
          </tr>
          
          <tr>
            <td><span class="required">*</span> <?php echo $entry_rficb_key; ?></td>
            <td><input type="text" name="rficb_key" value="<?php echo $rficb_key; ?>" />
              <?php if (isset($_error['rficb_key'])) { ?>
              <span class="error"><?php echo $_error['rficb_key']; ?></span>
              <?php } ?></td>
          </tr>
          
          <tr>
            <td><?php echo $entry_rficb_total; ?></td>
            <td><input type="text" name="rficb_total" value="<?php echo $rficb_total; ?>" /></td>
          </tr>          
          <tr>
            <td><?php echo $entry_rficb_order_status_id; ?></td>
            <td><select name="rficb_order_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $rficb_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          
          <tr>
            <td><?php echo $entry_rficb_geo_zone_id; ?></td>
            <td><select name="rficb_geo_zone_id">
                <option value="0"><?php echo $lang->get('text_all_zones'); ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $rficb_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          
          <tr>
            <td><?php echo $entry_rficb_status; ?></td>
            <td><select name="rficb_status">
                <?php if ($rficb_status) { ?>
                <option value="1" selected="selected"><?php echo $lang->get('text_enabled'); ?></option>
                <option value="0"><?php echo $lang->get('text_disabled'); ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $lang->get('text_enabled'); ?></option>
                <option value="0" selected="selected"><?php echo $lang->get('text_disabled'); ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_rficb_sort_order; ?></td>
            <td><input type="text" name="rficb_sort_order" value="<?php echo $rficb_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>
