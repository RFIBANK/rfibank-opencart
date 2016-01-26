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

class ModelPaymentRFICB extends Model {
	public function getMethod($address, $total) {
		$this->load->language('payment/rficb');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('rficb_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('rficb_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('rficb_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'rficb',
				'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('rficb_sort_order')
			);
		}
		return $method_data;
	}
}
?>
