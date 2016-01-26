<?php
/**
 * Модуль оплаты через ЗАО "РФИ БАНК" https://rficb.ru,
 * 
 * This code is provided under FreeBSD Copyright (license.txt)
 * Исходный код распространяется по лицензии FreeBSD (license.txt)
 *
 * Александр Топорков
 * toporchillo@gmail.com
 */
class ControllerPaymentRFICB extends Controller {
	protected function index() {
		$this->language->load('payment/rficb');
		$this->load->model('localisation/currency');
		$to_cur = $this->model_localisation_currency->getCurrencyByCode('RUB');
		if (!isset($to_cur['currency_id'])) {
			echo '<div class="warning">'.$this->language->get('error_no_rub').'</div>';
			exit;
		}

		$this->data['button_confirm'] = $this->language->get('button_confirm');
		
		$this->load->model('checkout/order');
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$this->data['key'] = $this->config->get('rficb_key');
		$this->data['comission'] = $this->config->get('rficb_commission');
		$this->data['pay_type'] = $this->config->get('rficb_payment_type');
		$this->data['pay_spg'] = $this->config->get('rficb_payment_spg');
		$this->data['pay_wm'] = $this->config->get('rficb_payment_wm');
		$this->data['pay_ym'] = $this->config->get('rficb_payment_ym');
		$this->data['pay_mc'] = $this->config->get('rficb_payment_mc');
		$this->data['pay_qiwi'] = $this->config->get('rficb_payment_qiwi');

		$from_cur = $this->model_localisation_currency->getCurrencyByCode($order_info['currency_code']);
		$this->data['cost'] = $order_info['total']*$order_info['currency_value']*$to_cur['value']/$from_cur['value'];

		$this->data['name'] = $this->config->get('rficb_name');

		$this->data['email'] = $order_info['email'];
		$this->data['phone'] = $order_info['telephone'];

		$this->data['order_id'] = $order_info['order_id'];
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/rficb.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/rficb.tpl';
		} else {
			$this->template = 'default/template/payment/rficb.tpl';
		}	
		
		$this->render();
	}

	public function error() {
		$this->language->load('payment/rficb');
		$this->session->data['error'] = $this->language->get('text_rficb_error');
		$this->redirect($this->url->link('checkout/checkout', '', 'SSL'));
	}
	
	public function callback() {
		$err = false;
		echo 'test';
		$data = array(
			'tid'=>$this->request->post['tid'],
			'name'=>$this->request->post['name'],
			'comment'=>$this->request->post['comment'],
			'partner_id'=>$this->request->post['partner_id'],
			'service_id'=>$this->request->post['service_id'],
			'order_id'=>$this->request->post['order_id'],
			'type'=>$this->request->post['type'],
			'partner_income'=>$this->request->post['partner_income'],
			'system_income'=>$this->request->post['system_income'],
			'test'=>$this->request->post['test']
		);

		$check = md5(join('', array_values($data)) . $this->config->get('rficb_secret'));

		if ($check != $this->request->post['check']) {
			$err_message = date('d.m.Y H:i:s').' Wrong signature. 	'.json_encode($this->request->post);
		    $fp = fopen(DIR_SYSTEM.'logs/rficb_error.txt', 'a');
		    fwrite($fp, $err_message."\n");
		    fclose($fp);
			echo $err_message;
			exit;
		}

		$this->load->model('checkout/order');
		$order_id = $this->request->post['order_id'];
		$order_info = $this->model_checkout_order->getOrder($order_id);

		if (!isset($order_info['order_id']) || !$order_info['order_id']) {
			$err_message = date('d.m.Y H:i:s').' Order ID: '.$order_id.' not found. 	'.json_encode($this->request->post);
		    $fp = fopen(DIR_SYSTEM.'logs/rficb_error.txt', 'a');
		    fwrite($fp, $err_message."\n");
		    fclose($fp);
			echo $err_message;
			exit;
		}

		$this->load->model('localisation/currency');
		$to_cur = $this->model_localisation_currency->getCurrencyByCode('RUB');
		$from_cur = $this->model_localisation_currency->getCurrencyByCode($order_info['currency_code']);

		$cost = $order_info['total']*$order_info['currency_value']*$to_cur['value']/$from_cur['value'];
		$sysincome = floatval($this->request->post['system_income']);

		if ($sysincome < $cost) {
			$err_message = date('d.m.Y H:i:s').' Wrong system_income: '.$sysincome.' vs '.$cost.'. Order ID: '.$order_id.'. 	'.json_encode($this->request->post);
			$fp = fopen(DIR_SYSTEM.'logs/rficb_error.txt', 'a');
			fwrite($fp, $err_message."\n");
			fclose($fp);
			echo $err_message;
			exit;
		}

		if ($order_info['order_status_id'] == 0) {
			$this->model_checkout_order->confirm($order_id, $this->config->get('rficb_order_status_id'), 'RFICB');
		}
		$message = date('d.m.Y H:i:s').' Payment successfull! Order ID: '.$order_id.'. 	'.json_encode($this->request->post);
		$fp = fopen(DIR_SYSTEM.'logs/rficb_success.txt', 'a');
		fwrite($fp, $message."\n");
		fclose($fp);
		echo $message;
	}
}
?>
