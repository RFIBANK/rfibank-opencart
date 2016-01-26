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
	private $error = array();
	private $form;
	
  	public function index() {
		$this->load->language('payment/rficb');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

    	if ($this->request->server['REQUEST_METHOD'] == 'POST') {
    		if ($this->validate($this->request->post)) {
				$this->model_setting_setting->editSetting('rficb', $this->request->post);
				
				$this->session->data['success'] = $this->language->get('text_success');
	
				$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
    		}
    	}

      	$this->data['breadcrumbs'] = $this->getBreadCrumbs();
		$this->data['lang'] = $this->language;

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		$this->data['_error'] = $this->error;
		
    	$this->data['action'] = $this->url->link('payment/rficb', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('localisation/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
    $this->data['pay_types'] = array( 0 => array('name' => 'Страница выбора','cod' =>'0'),1 => array('name' => 'пластиковые карты','cod' =>'spg'),
                            2 => array('name' => 'мобильная коммерция','cod' =>'mc'),3 => array('name' => 'Webmoney','cod' =>'wm'), 
                           4 => array('name' => 'QIWI терминалы и кошелёк','cod' =>'qiwi'),5 => array('name' => 'Яндекс.Деньги','cod' =>'ym'),  ); 

		$defaults = array(
			'rficb_name' => '',
			'rficb_callback' => '',
			'rficb_success' => '',
			'rficb_error' => '',
			'rficb_secret' => '',
			'rficb_key' => '',
			'rficb_total' => '',
			'rficb_commission' => '', 
      			'rficb_payment_type' => '',
			'rficb_payment_spg' => '',
			'rficb_payment_wm' => '',
			'rficb_payment_ym' => '',
			'rficb_payment_mc' => '',
			'rficb_payment_qiwi' => '',
			'rficb_order_status_id' => '',
			'rficb_geo_zone_id' => '',
			'rficb_status' => '',
			'rficb_sort_order' => '',
		);
		foreach ($defaults as $key=>$value) {
			if (isset($this->request->post[$key])) {
				$defautls[$key] = $this->request->post[$key];
			}
			else {
				$defautls[$key] = $this->config->get($key);
			}
			$this->data[$key] = $defautls[$key];
			$this->data['entry_'.$key] = $this->language->get('entry_'.$key);
		}

		$this->template = 'payment/rficb.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());	
  	}

  	private function validate($post_data) {
		if (!$this->user->hasPermission('modify', 'payment/rficb')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$post_data['rficb_name']) {
			$this->error['warning'] = $this->language->get('error_form');
			$this->error['rficb_name'] = $this->language->get('error_empty_field');
		}
		if (!$post_data['rficb_secret']) {
			$this->error['warning'] = $this->language->get('error_form');
			$this->error['rficb_secret'] = $this->language->get('error_empty_field');
		}
		if (!$post_data['rficb_key']) {
			$this->error['warning'] = $this->language->get('error_form');
			$this->error['rficb_key'] = $this->language->get('error_empty_field');
		}
		
    	if (!$this->error || !sizeof($this->error)) {
      		return true;
    	} else {
      		return false;
    	}
  	}
	
	private function getBreadCrumbs() {
		$breadcrumbs = array();

   		$breadcrumbs[] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$breadcrumbs[] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$breadcrumbs[] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/rficb', 'token=' . $this->session->data['token'], 'SSL'),      		
      		'separator' => ' :: '
   		);
   		
      	return $breadcrumbs;
	}
}
?>
