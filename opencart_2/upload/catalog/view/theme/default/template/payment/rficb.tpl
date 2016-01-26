<form method="POST" class="application" accept-charset="UTF-8" action="https://partner.rficb.ru/a1lite/input">
<input type="hidden" name="key" value="<?php echo $key; ?>" />
<input type="hidden" name="cost" value="<?php echo $cost; ?>" />
<input type="hidden" name="name" value="<?php echo $name; ?>"/>
<input type="hidden" name="email" value="<?php echo $email; ?>" />
<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
  <div class="buttons">
    <div class="pull-right">
      <input type="submit" value="<?php echo $button_confirm; ?>" class="btn btn-primary" />
    </div>
  </div>
</form>
