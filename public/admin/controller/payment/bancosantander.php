<?php 
class ControllerPaymentBancoSantander extends Controller {
	private $error = array(); 
	 
	public function index() { 
		$this->language->load('payment/bancosantander');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('bancosantander', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		
		$this->data['entry_nome'] = $this->language->get('entry_nome');
		$this->data['entry_cedente'] = $this->language->get('entry_cedente');
		$this->data['entry_cpfcnpj'] = $this->language->get('entry_cpfcnpj');
		$this->data['entry_endereco'] = $this->language->get('entry_endereco');
		$this->data['entry_cliente'] = $this->language->get('entry_cliente');
		$this->data['entry_venda'] = $this->language->get('entry_venda');
		$this->data['entry_taxa'] = $this->language->get('entry_taxa');
		$this->data['entry_dias'] = $this->language->get('entry_dias');
		$this->data['entry_demo1'] = $this->language->get('entry_demo1');
		$this->data['entry_demo2'] = $this->language->get('entry_demo2');
		$this->data['entry_demo3'] = $this->language->get('entry_demo3');
		$this->data['entry_ins1'] = $this->language->get('entry_ins1');
		$this->data['entry_ins2'] = $this->language->get('entry_ins2');
		$this->data['entry_ins3'] = $this->language->get('entry_ins3');
		$this->data['entry_ins4'] = $this->language->get('entry_ins4');
		
		$this->data['entry_config'] = $this->language->get('entry_config');
		$this->data['entry_about'] = $this->language->get('entry_about');
		$this->data['entry_about_name'] = $this->language->get('entry_about_name');
		$this->data['entry_about_name_description'] = $this->language->get('entry_about_name_description');
		$this->data['entry_about_version'] = $this->language->get('entry_about_version');
		$this->data['entry_about_version_description'] = $this->language->get('entry_about_version_description');
		$this->data['entry_about_author'] = $this->language->get('entry_about_author');
		$this->data['entry_about_author_description'] = $this->language->get('entry_about_author_description');
		$this->data['entry_about_support'] = $this->language->get('entry_about_support');
		$this->data['entry_about_support_description'] = $this->language->get('entry_about_support_description');
		$this->data['entry_about_support_ped'] = $this->language->get('entry_about_support_ped');
		$this->data['entry_about_support_ped_description'] = $this->language->get('entry_about_support_ped_description');
		
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');		
		$this->data['entry_total'] = $this->language->get('entry_total');	
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/bancosantander', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('payment/bancosantander', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');	
		
		if (isset($this->request->post['bancosantander_nome'])) {
			$this->data['bancosantander_nome'] = $this->request->post['bancosantander_nome'];
		} else {
			$this->data['bancosantander_nome'] = $this->config->get('bancosantander_nome'); 
		}
		
		if (isset($this->request->post['bancosantander_cedente'])) {
			$this->data['bancosantander_cedente'] = $this->request->post['bancosantander_cedente'];
		} else {
			$this->data['bancosantander_cedente'] = $this->config->get('bancosantander_cedente'); 
		}
		
		if (isset($this->request->post['bancosantander_cpfcnpj'])) {
			$this->data['bancosantander_cpfcnpj'] = $this->request->post['bancosantander_cpfcnpj'];
		} else {
			$this->data['bancosantander_cpfcnpj'] = $this->config->get('bancosantander_cpfcnpj'); 
		}
		
		if (isset($this->request->post['bancosantander_endereco'])) {
			$this->data['bancosantander_endereco'] = $this->request->post['bancosantander_endereco'];
		} else {
			$this->data['bancosantander_endereco'] = $this->config->get('bancosantander_endereco'); 
		}
		
		if (isset($this->request->post['bancosantander_cliente'])) {
			$this->data['bancosantander_cliente'] = $this->request->post['bancosantander_cliente'];
		} else {
			$this->data['bancosantander_cliente'] = $this->config->get('bancosantander_cliente'); 
		}
		
		if (isset($this->request->post['bancosantander_venda'])) {
			$this->data['bancosantander_venda'] = $this->request->post['bancosantander_venda'];
		} else {
			$this->data['bancosantander_venda'] = $this->config->get('bancosantander_venda'); 
		}
		
		if (isset($this->request->post['bancosantander_taxa'])) {
			$this->data['bancosantander_taxa'] = $this->request->post['bancosantander_taxa'];
		} else {
			$this->data['bancosantander_taxa'] = $this->config->get('bancosantander_taxa'); 
		}
		
		if (isset($this->request->post['bancosantander_dias'])) {
			$this->data['bancosantander_dias'] = $this->request->post['bancosantander_dias'];
		} else {
			$this->data['bancosantander_dias'] = $this->config->get('bancosantander_dias'); 
		}
		
		if (isset($this->request->post['bancosantander_demo1'])) {
			$this->data['bancosantander_demo1'] = $this->request->post['bancosantander_demo1'];
		} else {
			$this->data['bancosantander_demo1'] = $this->config->get('bancosantander_demo1'); 
		}
		
		if (isset($this->request->post['bancosantander_demo2'])) {
			$this->data['bancosantander_demo2'] = $this->request->post['bancosantander_demo2'];
		} else {
			$this->data['bancosantander_demo2'] = $this->config->get('bancosantander_demo2'); 
		}
		
		if (isset($this->request->post['bancosantander_demo3'])) {
			$this->data['bancosantander_demo3'] = $this->request->post['bancosantander_demo3'];
		} else {
			$this->data['bancosantander_demo3'] = $this->config->get('bancosantander_demo3'); 
		}
		
		if (isset($this->request->post['bancosantander_ins1'])) {
			$this->data['bancosantander_ins1'] = $this->request->post['bancosantander_ins1'];
		} else {
			$this->data['bancosantander_ins1'] = $this->config->get('bancosantander_ins1'); 
		}
		
		if (isset($this->request->post['bancosantander_ins2'])) {
			$this->data['bancosantander_ins2'] = $this->request->post['bancosantander_ins2'];
		} else {
			$this->data['bancosantander_ins2'] = $this->config->get('bancosantander_ins2'); 
		}
		
		if (isset($this->request->post['bancosantander_ins3'])) {
			$this->data['bancosantander_ins3'] = $this->request->post['bancosantander_ins3'];
		} else {
			$this->data['bancosantander_ins3'] = $this->config->get('bancosantander_ins3'); 
		}
		
		if (isset($this->request->post['bancosantander_ins4'])) {
			$this->data['bancosantander_ins4'] = $this->request->post['bancosantander_ins4'];
		} else {
			$this->data['bancosantander_ins4'] = $this->config->get('bancosantander_ins4'); 
		}
		
		if (isset($this->request->post['bancosantander_total'])) {
			$this->data['bancosantander_total'] = $this->request->post['bancosantander_total'];
		} else {
			$this->data['bancosantander_total'] = $this->config->get('bancosantander_total'); 
		}
				
		if (isset($this->request->post['bancosantander_order_status_id'])) {
			$this->data['bancosantander_order_status_id'] = $this->request->post['bancosantander_order_status_id'];
		} else {
			$this->data['bancosantander_order_status_id'] = $this->config->get('bancosantander_order_status_id'); 
		} 
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['bancosantander_geo_zone_id'])) {
			$this->data['bancosantander_geo_zone_id'] = $this->request->post['bancosantander_geo_zone_id'];
		} else {
			$this->data['bancosantander_geo_zone_id'] = $this->config->get('bancosantander_geo_zone_id'); 
		} 
		
		$this->load->model('localisation/geo_zone');						
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['bancosantander_status'])) {
			$this->data['bancosantander_status'] = $this->request->post['bancosantander_status'];
		} else {
			$this->data['bancosantander_status'] = $this->config->get('bancosantander_status');
		}
		
		if (isset($this->request->post['bancosantander_sort_order'])) {
			$this->data['bancosantander_sort_order'] = $this->request->post['bancosantander_sort_order'];
		} else {
			$this->data['bancosantander_sort_order'] = $this->config->get('bancosantander_sort_order');
		}

		$this->template = 'payment/bancosantander.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	protected function validate() {
		return true;	
	}
}
?>