<?php
class ControllerTotalTaxaPorTipoPagamento extends Controller {
	private $error = array();

	public function index() {
		#Carrega Primeiro as Extensoes de Pagamento Ativas para Evitar Conflito de Idioma com o Módulo
		$this->load->model('setting/extension');		
		
		$extensions = $this->model_setting_extension->getInstalled('payment');
		
		for ($i=0; $i < count($extensions); $i++) {
			$this->data['payment_methods'][$i]['payment_code'] = $extensions[$i];
			$this->load->language('payment/'.$extensions[$i]);
			$this->data['payment_methods'][$i]['title'] = $this->language->get('heading_title');			
		}
		#----Fim do Carregamento das Extensoes de Pagamento Ativas----#
		
		$this->load->language('total/taxa_por_tipo_pagamento');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('taxa_por_tipo_pagamento', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');


		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');

		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_metodo_pagamento'] = $this->language->get('entry_metodo_pagamento');
		$this->data['entry_operador'] = $this->language->get('entry_operador');
		$this->data['entry_taxa'] = $this->language->get('entry_taxa');
		$this->data['entry_tipo_taxa'] = $this->language->get('entry_tipo_taxa');
		$this->data['entry_valor_minimo'] = $this->language->get('entry_valor_minimo');
		$this->data['entry_valor_maximo'] = $this->language->get('entry_valor_maximo');
		$this->data['entry_descricao'] = $this->language->get('entry_descricao');
		
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
		
		$this->data['button_remove_metodo'] = $this->language->get('button_remove_metodo');
		$this->data['button_add_metodo'] = $this->language->get('button_add_metodo');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

      $this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_total'),
      		'separator' => ' :: '
   		);
   		
   		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('total/taxa_por_tipo_pagamento', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('total/taxa_por_tipo_pagamento', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['taxa_por_tipo_pagamento_status'])) {
			$this->data['taxa_por_tipo_pagamento_status'] = $this->request->post['taxa_por_tipo_pagamento_status'];
		} else {
			$this->data['taxa_por_tipo_pagamento_status'] = $this->config->get('taxa_por_tipo_pagamento_status');
		}

		if (isset($this->request->post['taxa_por_tipo_pagamento_sort_order'])) {
			$this->data['taxa_por_tipo_pagamento_sort_order'] = $this->request->post['taxa_por_tipo_pagamento_sort_order'];
		} else {
			$this->data['taxa_por_tipo_pagamento_sort_order'] = $this->config->get('taxa_por_tipo_pagamento_sort_order');
		}

		if (isset($this->request->post['taxa_por_tipo_pagamento_metodos'])) {
			$this->data['taxa_por_tipo_pagamento_metodos'] = $this->request->post['taxa_por_tipo_pagamento_metodos'];
		} else {
			$this->data['taxa_por_tipo_pagamento_metodos'] = $this->config->get('taxa_por_tipo_pagamento_metodos');
		}
		
		$this->template = 'total/taxa_por_tipo_pagamento.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);		

		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'total/taxa_por_tipo_pagamento')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>