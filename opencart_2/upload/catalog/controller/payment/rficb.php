<?php
/**
 * Модуль оплаты через ЗАО "РФИ БАНК" https://rficb.ru,
 */
class ControllerPaymentRFICB extends Controller {
	public function index() {
		$this->language->load('payment/rficb');
		$this->load->model('localisation/currency');
		$to_cur = $this->model_localisation_currency->getCurrencyByCode('RUB');
		if (!isset($to_cur['currency_id'])) {
			echo '<div class="warning">'.$this->language->get('error_no_rub').'</div>';
			exit;
		}

		$data['button_confirm'] = $this->language->get('button_confirm');
		
		$this->load->model('checkout/order');
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$data['key'] = $this->config->get('rficb_key');

		$from_cur = $this->model_localisation_currency->getCurrencyByCode($order_info['currency_code']);
		$data['cost'] = $order_info['total']*$order_info['currency_value']*$to_cur['value']/$from_cur['value'];

		$data['name'] = $this->config->get('rficb_name');

		$data['email'] = $order_info['email'];

		$data['order_id'] = $order_info['order_id']; 
    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/rficb.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/rficb.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/rficb.tpl', $data);
		}
	}

	public function error() {
		$this->language->load('payment/rficb');
		$this->session->data['error'] = $this->language->get('text_rficb_error');
		$this->redirect($this->url->link('checkout/checkout', '', 'SSL'));
	}
	
	public function callback() {

    $this->load->language('payment/rficb');
    $request = array(
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
    $ch = join('', array_values($request)) . $this->config->get('rficb_secret') ;
    echo "test2-".$ch ;
		$check = md5(join('', array_values($request)) . $this->config->get('rficb_secret'));
    echo "test-".$check ;   
     
    print_r($request) ;
		$data['title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));

		if (!$this->request->server['HTTPS']) {
			$data['base'] = $this->config->get('config_url');
		} else {
			$data['base'] = $this->config->get('config_ssl');
		}

		$data['language'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));

		$data['text_response'] = $this->language->get('text_response');
		$data['text_success'] = $this->language->get('text_success');
		$data['text_success_wait'] = sprintf($this->language->get('text_success_wait'), $this->url->link('checkout/success'));
		$data['text_failure'] = $this->language->get('text_failure');
		$data['text_failure_wait'] = sprintf($this->language->get('text_failure_wait'), $this->url->link('checkout/checkout', '', 'SSL'));

		if (isset($this->request->post['tid'])) {
			$message = '';

			if (isset($this->request->post['tid'])) {
				$message .= 'tid: ' . $this->request->post['tid'] . "\n";
			}

			$this->load->model('checkout/order');

			// If returned successful but callbackPW doesn't match, set order to pendind and record reason
			if (isset($this->request->post['check']) && ($this->request->post['check'] == $check)) {
				$this->model_checkout_order->addOrderHistory($this->request->post['order_id'], $this->config->get('rficb_order_status_id'), $message, false);
			} else {
				$this->model_checkout_order->addOrderHistory($this->request->post['order_id'], $this->config->get('config_order_status_id'), $this->language->get('text_pw_mismatch'));
			}

	/*		$data['continue'] = $this->url->link('checkout/success');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/rficb_success.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/payment/rficb_success.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/payment/rficb_success.tpl', $data));
			} */
		} else {
			$data['continue'] = $this->url->link('checkout/cart');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/rficb_failure.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/payment/rficb_failure.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/payment/rficb_failure.tpl', $data));
			}
		}
	}    
  
}
?>
