<form method="POST" class="application" accept-charset="UTF-8" action="https://partner.rficb.ru/a1lite/input">
<input type="hidden" name="key" value="<?php echo $key; ?>" />
<input type="hidden" name="cost" value="<?php echo $cost; ?>" />
<input type="hidden" name="name" value="<?php echo $name; ?>"/>
<input type="hidden" name="email" value="<?php echo $email; ?>" />
<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />

<?php if($comission) { ?>
<input type="hidden" name="comission" value="abonent" />   
<input type="hidden" name="version" value="2.0" />
<?php } else { 
	      if($pay_type) {
?>
<link rel="stylesheet" type="text/css" href="/catalog/view/theme/default/stylesheet/rficb.css" /> 
<script language="javascript" type="text/javascript">
function ptype(paytype){
document.getElementById("payment_type").value = paytype;  

 } </script>
<input type="hidden" name="payment_type" value="spg" id="payment_type" />
<div id="pay-methods" >
            <div class="row">
		<div class="col-xs-3 pay-method spg">
                <input type="radio" name="pay_type" id="pay-method-spg" value="spg" checked="" onclick="ptype('spg')">
                <label for="pay-method-spg"><span>Visa / MasterCard</span></label>
              </div>

		<?php }
	    if ($email) { 
			 if ($pay_wm) {?>
 <div class="col-xs-3 pay-method wm">
                <input type="radio" name="pay_type" id="pay-method-wm" value="wm" onclick="ptype('wm')">
                <label for="pay-method-wm"><span>WebMoney</span></label>
		</div> <?php }
		    if ($pay_ym) {?>
              <div class="col-xs-3 pay-method ym">
                <input type="radio" name="pay_type" id="pay-method-ym" value="ym" onclick="ptype('ym')">
                <label for="pay-method-ym"><span>Яндекс. Деньги</span></label>
              </div>
		<?php } 
		}
	    if ($phone) { 
if ($pay_mc) {?>

  <div class="col-xs-3 pay-method mc">
                <input type="radio" name="pay_type" id="pay-method-mc" value="mc" onclick="ptype('mc')">
                <label for="pay-method-mc"><span>Мобильный платёж</span></label>
              </div>
 <?php }
		    if ($pay_qiwi) {?>
  <div class="col-xs-3 pay-method qiwi">
                <input type="radio" name="pay_type" id="pay-method-qiwi" value="qiwi" onclick="ptype('qiwi')">
                <label for="pay-method-qiwi"><span>QIWI</span></label>
              </div>
		<?php } ?>
<input type="hidden" name="phone_number" value="<?echo $phone?>" />
<?php } ?>
            </div>
          </div>

<?php } ?>
  <div class="buttons">
    <div class="right">
      <input type="submit" value="<?php echo $button_confirm; ?>" class="button" />
    </div>
  </div>
</form>
