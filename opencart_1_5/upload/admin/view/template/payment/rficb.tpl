<?php
/**
 * Модуль оплаты через ЗАО "РФИ БАНК" https://rficb.ru,
 * 
 * This code is provided under FreeBSD Copyright (license.txt)
 * Исходный код распространяется по лицензии FreeBSD (license.txt)
 */
?>
<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $lang->get('heading_title'); ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $lang->get('button_save'); ?></a><a onclick="location = '<?php echo $lang->get('cancel'); ?>';" class="button"><?php echo $lang->get('button_cancel'); ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
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

<tr> <td><?php echo $entry_rficb_commission; ?></td>
		<td>
<?php if ($rficb_commission) { ?>
<input type="checkbox" name="rficb_commission" checked="checked" />
<?php } else { ?>
<input type="checkbox" name="rficb_commission" />
<?php }?>
</td>
	  </tr>  
	  <tr> <td><?php echo $entry_rficb_payment_type; ?></td>
		<td>
<?php if ($rficb_payment_type) { ?>
<input type="checkbox" name="rficb_payment_type" checked="checked" />
<?php } else { ?>
<input type="checkbox" name="rficb_payment_type" />
<?php }?></td>
	  </tr> 
 <tr> <td><?php echo $entry_rficb_payment_spg; ?></td>
		<td>
<?php if ($rficb_payment_spg) { ?>
<input type="checkbox" name="rficb_payment_spg" checked="checked" />
<?php } else { ?>
<input type="checkbox" name="rficb_payment_spg" />
<?php }?></td>
	  </tr> 

 <tr> <td><?php echo $entry_rficb_payment_wm; ?></td>
		<td>
<?php if ($rficb_payment_wm) { ?>
<input type="checkbox" name="rficb_payment_wm" checked="checked" />
<?php } else { ?>
<input type="checkbox" name="rficb_payment_wm" />
<?php }?></td>
	  </tr>  

 <tr> <td><?php echo $entry_rficb_payment_ym; ?></td>
		<td>
<?php if ($rficb_payment_ym) { ?>
<input type="checkbox" name="rficb_payment_ym" checked="checked" />
<?php } else { ?>
<input type="checkbox" name="rficb_payment_ym" />
<?php }?></td>
	  </tr>   

 <tr> <td><?php echo $entry_rficb_payment_mc; ?></td>
		<td>
<?php if ($rficb_payment_mc) { ?>
<input type="checkbox" name="rficb_payment_mc" checked="checked" />
<?php } else { ?>
<input type="checkbox" name="rficb_payment_mc" />
<?php }?></td>
	  </tr>  

 <tr> <td><?php echo $entry_rficb_payment_qiwi; ?></td>
		<td>
<?php if ($rficb_payment_qiwi) { ?>
<input type="checkbox" name="rficb_payment_qiwi" checked="checked" />
<?php } else { ?>
<input type="checkbox" name="rficb_payment_qiwi" />
<?php }?></td>
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
