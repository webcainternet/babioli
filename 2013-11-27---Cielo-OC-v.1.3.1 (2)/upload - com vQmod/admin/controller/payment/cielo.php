<?php
/**
 * Módulo Cielo para OpenCart 1.5.3.1 a 1.5.6
 * Integração direta com a Cielo,
 * sem utilização de Gateways de pagamento
 * 
 * Todos os direitos reservados.
 * Proibido modificar, distribuir, reutilizar, etc.,
 * seja no todo ou em parte, sem a permissão do autor.
 * 
 * Para utilizar esse módulo, você deve comprar uma licença
 * Visite a página de módulos do OpenCart
 * ou envie um e-mail para mim.
 * 
 * As licenças são por loja. Cada loja, uma licença.
 * 
 * Os arquivos 'language' podem ser livremente traduzidos,
 * conforme a sua necessidade. Os arquivos 'template' podem
 * ser alterados para adequação ao seu layout.
 * 
 * Se você precisar de um serviço de hospedagem bom e barato para a sua loja
 * recomendamos a Hostgator - http://www.hostgator.com.br/6860.html
 * No plano G você obtém SSL e IP dedicado grátis.
 * 
 * @author  Victor Schröder <domains@egeeks.com.br>
 * @copyright  Copyright (c) 2012, Victor Schröder. All rights reserved. Must buy a Commercial Licence (per store).
 * @link  http://www.opencart.com/index.php?route=extension/extension/info&extension_id=8855
 */

class ControllerPaymentCielo extends Controller {
	
	private $version = '2.0';
	private $error = array();
	
	public function __construct($registry) {
		parent::__construct($registry);
		$this->load->language('payment/cielo');
		$this->load->model('payment/cielo');
		$this->load->model('setting/setting');
		$this->load->model('localisation/order_status');
		$this->load->model('localisation/geo_zone');
		$this->session->data['GA']['cielo']['user'] = 'admin';
		$this->load->library('Cielo/includes');
		if($this->model_payment_cielo->normalizeConfig($this->version)) $this->redirect($this->url->link('payment/cielo', 'token=' . $this->session->data['token'], 'SSL'));
		$this->model_payment_cielo->checkUpdate($this->version);
	}

	public function index() {
		
		$this->document->addScript('view/javascript/jquery/cluetip/jquery.cluetip.js');
		$this->document->addStyle('view/javascript/jquery/cluetip/jquery.cluetip.css');
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			
			$settings_array['cielo_config'] = $this->request->post['cielo_config'];
			
			$settings_array['cielo_config']['version'] = $this->version;
			$settings_array['cielo_config']['sandbox'] = (bool)$settings_array['cielo_config']['sandbox'];			
			$settings_array['cielo_config']['soft_descriptor'] = isset($settings_array['cielo_config']['soft_descriptor']) ? (string)$settings_array['cielo_config']['soft_descriptor'] : '';

			$settings_array['cielo_config']['operacoes']['visa_electron']['codigo'] = 'visa';
			$settings_array['cielo_config']['operacoes']['redeshop']['codigo'] = 'mastercard';
			$settings_array['cielo_config']['operacoes']['visa']['codigo'] = 'visa';
			$settings_array['cielo_config']['operacoes']['mastercard']['codigo'] = 'mastercard';
			$settings_array['cielo_config']['operacoes']['diners']['codigo'] = 'diners';
			$settings_array['cielo_config']['operacoes']['amex']['codigo'] = 'amex';
			$settings_array['cielo_config']['operacoes']['elo']['codigo'] = 'elo';
			$settings_array['cielo_config']['operacoes']['discover']['codigo'] = 'discover';
			$settings_array['cielo_config']['operacoes']['jcb']['codigo'] = 'jcb';
			$settings_array['cielo_config']['operacoes']['aura']['codigo'] = 'aura';
			
			$settings_array['cielo_config']['operacoes']['visa_electron']['tipo'] = 'debito';
			$settings_array['cielo_config']['operacoes']['redeshop']['tipo'] = 'debito';
			$settings_array['cielo_config']['operacoes']['visa']['tipo'] = 'credito';
			$settings_array['cielo_config']['operacoes']['mastercard']['tipo'] = 'credito';
			$settings_array['cielo_config']['operacoes']['diners']['tipo'] = 'credito';
			$settings_array['cielo_config']['operacoes']['amex']['tipo'] = 'credito';
			$settings_array['cielo_config']['operacoes']['elo']['tipo'] = 'credito';
			$settings_array['cielo_config']['operacoes']['discover']['tipo'] = 'credito';
			$settings_array['cielo_config']['operacoes']['jcb']['tipo'] = 'credito';
			$settings_array['cielo_config']['operacoes']['aura']['tipo'] = 'credito';
			
			foreach ($settings_array['cielo_config']['operacoes'] as $operacao) {
			
				$operacao['ativo'] = (bool)$operacao['ativo'];
				$operacao['valor_minimo'] = (float)$operacao['valor_minimo'];
				$operacao['max_parc'] = (int)$operacao['max_parc'];
				$operacao['max_parc_sj'] = (int)$operacao['max_parc_sj'];
				$operacao['max_parc_jl'] = (int)$operacao['max_parc_jl'];
				$operacao['juros_loja'] = (float)$operacao['juros_loja'];
				$operacao['desconto'] = (float)$operacao['desconto'];
				$operacao['auto_capturar'] = (bool)$operacao['auto_capturar'];
				$operacao['autorizacao'] = (int)$operacao['autorizacao'];
			
			}
			
			$settings_array['cielo_status'] = $this->request->post['cielo_status'];
			$settings_array['cielo_sort_order'] = $this->request->post['cielo_sort_order'];
			
			if (!$this->error) {
				$this->model_setting_setting->editSetting('cielo', $settings_array);
				$this->session->data['success'] = $this->language->get('text_success');
				$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
			}
			
		}
		
		$this->data['token'] = $this->session->data['token'];
		
		$text_strings = array(
			'heading_title',
			'text_description',
			'entry_sandbox_mode',
			'entry_estabelecimento',
			'entry_chave_seguranca',
			'entry_img_seguranca',
			'entry_buy_page',
			'text_buy_page_loja',
			'entry_soft_descriptor',
			'entry_exibicao_checkout',
			'text_exibicao_checkout_img',
			'text_exibicao_checkout_text',
			'text_usar_nenhum',
			'text_usar_num_pedido',
			'text_usar_outro',
			'entry_habilitar_operacao',
			'entry_operacao_nome',
			'entry_operacao_valor_minimo',
			'entry_operacao_parc_minima',
			'entry_operacao_desconto',
			'entry_operacao_max_parc',
			'entry_operacao_max_parc_sj',
			'entry_operacao_max_parc_jl',
			'entry_operacao_juros_loja',
			'entry_operacao_img',
			'entry_operacao_auto_capturar',
			'entry_operacao_autorizacao',
			'text_autorizacao_0',
			'text_autorizacao_1',
			'text_autorizacao_2',
			'text_autorizacao_3',
			'text_autorizacao_4',
			'entry_status_pedido_pendente',
			'entry_status_pedido_erro_sem_retry',
			'entry_status_pedido_erro_com_retry',
			'entry_status_pedido_sucesso_sem_captura',
			'entry_status_pedido_sucesso_com_captura',
			'entry_geo_zone',
			'entry_status',
			'entry_sort_order',
			'text_author',
			'text_payment',
			'text_script_title_alerta',
			'text_script_erro_negativo',
			'text_script_erro_NAN',
			'text_script_botao_retornar',
			'text_script_erro_soft_descriptor',
			'text_script_erro_valor_minimo',
			'text_script_parc_sj_desativado',
			'text_script_parc_loja_desativado',
			'text_script_parc_admin_desativado',
			'text_script_parc_sj_ativo',
			'text_script_parc_loja_ativo',
			'text_script_parc_admin_ativo',
			
			'text_all_zones',
			'button_save',
			'button_cancel',
			'text_yes',
			'text_no',
			'text_enabled',
			'text_disabled'
		);
		
		foreach ($text_strings as $text) {
			$this->data[$text] = $this->language->get($text);
		}
				
		$labels = array(
			'visa_electron',
			'redeshop',
			'visa',
			'mastercard',
			'diners',
			'amex',
			'elo',
			'discover',
			'jcb',
			'aura'
		);

		foreach ($labels as $label) {
			$this->data['entry_operacao'][$label] = $this->language->get('entry_operacao_' . $label);
		}
	
		$cielo_config = $this->config->get('cielo_config');
		
		$config_data = array(
			'sandbox',
			'estabelecimento',
			'chave',
			'img_segura',
			'buy_page',
			'soft_descriptor',
			'exibicao_checkout',
			'geo_zone_id'
		);
		
		$operacoes_data = array(
			'nome',
			'codigo',
			'ativo',
			'tipo',
			'valor_minimo',
			'parc_minima',
			'max_parc',
			'max_parc_jl',
			'max_parc_sj',
			'juros_loja',
			'desconto',
			'img',
			'auto_capturar',
			'autorizacao'
		);
		
		$status_pedido = array (
			'pendente',
			'erro_sem_retry',
			'erro_com_retry',
			'sucesso_sem_captura',
			'sucesso_com_captura'
		);
		
		if (isset($this->request->post['cielo_status'])) {
			$this->data['cielo_status'] = $this->request->post['cielo_status'];
		} else {
			$this->data['cielo_status'] = $this->config->get('cielo_status');
		}

		if (isset($this->request->post['cielo_sort_order'])) {
			$this->data['cielo_sort_order'] = $this->request->post['cielo_sort_order'];
		} else {
			$this->data['cielo_sort_order'] = $this->config->get('cielo_sort_order');
		}
		
		foreach ($config_data as $conf) {
			if (isset($this->request->post['cielo_config'][$conf])) {
				$this->data['cielo_config'][$conf] = $this->request->post['cielo_config'][$conf];
			} else {
				$this->data['cielo_config'][$conf] = isset($cielo_config[$conf]) ? $cielo_config[$conf] : '';
			}
		}
		
		foreach ($labels as $label) {
			foreach ($operacoes_data as $conf) {
				if (isset($this->request->post['cielo_config']['operacoes'][$label][$conf])) {
					$this->data['cielo_config']['operacoes'][$label][$conf] = $this->request->post['cielo_config']['operacoes'][$label][$conf];
				} else {
					$this->data['cielo_config']['operacoes'][$label][$conf] = isset($cielo_config['operacoes'][$label][$conf]) ? $cielo_config['operacoes'][$label][$conf] : '';
				}
			}
		}
		
		foreach ($status_pedido as $conf) {
			if (isset($this->request->post['cielo_config']['status_pedido'][$conf])) {
				$this->data['cielo_config']['status_pedido'][$conf] = $this->request->post['cielo_config']['status_pedido'][$conf];
			} else {
				$this->data['cielo_config']['status_pedido'][$conf] = isset($cielo_config['status_pedido'][$conf]) ? $cielo_config['status_pedido'][$conf] : '';
			}
		}
		
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
				
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
		'href'      => $this->url->link('payment/cielo', 'token=' . $this->session->data['token'], 'SSL'),
		'separator' => ' :: '
		);
		
		$this->data['action'] = $this->url->link('payment/cielo', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->template = 'payment/cielo.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
		
		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/cielo')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	public function install() {
		
		$this->model_payment_cielo->installCieloTables();
		$this->model_payment_cielo->installGATables();
			
		$settings_array = array(
			'cielo_config' => array(
				'version' => '2.0',
				'estabelecimento' => '',
				'chave' => '',
				'buy_page' => 'cielo',
				'soft_descriptor' => '',
				'geo_zone_id' => '0',
				'exibicao_checkout' => 'img',
				'sandbox' => true,
				'operacoes' => array(
					'visa_electron' => array(
						'nome' => 'Visa Electron',
						'codigo' => 'visa',
						'ativo' => false,
						'tipo' => 'debito',
						'valor_minimo' => 5,
						'parc_minima' => 5,
						'max_parc' => 1,
						'max_parc_jl' => 0,
						'max_parc_sj' => 0,
						'juros_loja' => 0,
						'desconto' => 0,
						'auto_capturar' => true,
						'autorizacao' => 1),
					'redeshop'  => array(
						'nome' => 'Redeshop/Maestro',
						'codigo' => 'mastercard',
						'ativo' => false,
						'tipo' => 'debito',
						'valor_minimo' => 5,
						'parc_minima' => 5,
						'max_parc' => 1,
						'max_parc_jl' => 0,
						'max_parc_sj' => 0,
						'juros_loja' => 0,
						'desconto' => 0,
						'auto_capturar' => true,
						'autorizacao' => 1),
					'visa' => array(
						'nome' => 'Visa',
						'codigo' => 'visa',
						'ativo' => false,
						'tipo' => 'credito',
						'valor_minimo' => 5,
						'parc_minima' => 5,
						'max_parc' => 1,
						'max_parc_jl' => 0,
						'max_parc_sj' => 0,
						'juros_loja' => 0,
						'desconto' => 0,
						'auto_capturar' => false,
						'autorizacao' => 3),
					'mastercard' => array(
						'nome' => 'Mastercard',
						'codigo' => 'mastercard',
						'ativo' => false,
						'tipo' => 'credito',
						'valor_minimo' => 5,
						'parc_minima' => 5,
						'max_parc' => 1,
						'max_parc_jl' => 0,
						'max_parc_sj' => 0,
						'juros_loja' => 0,
						'desconto' => 0,
						'auto_capturar' => false,
						'autorizacao' => 3),
					'diners' => array(
						'nome' => 'Diners Club',
						'codigo' => 'diners',
						'ativo' => false,
						'tipo' => 'credito',
						'valor_minimo' => 5,
						'parc_minima' => 5,
						'max_parc' => 0,
						'max_parc_jl' => 0,
						'max_parc_sj' => 0,
						'juros_loja' => 0,
						'desconto' => 0,
						'auto_capturar' => false,
						'autorizacao' => 3),
					'amex' => array(
						'nome' => 'American Express',
						'codigo' => 'amex',
						'ativo' => false,
						'tipo' => 'credito',
						'valor_minimo' => 5,
						'parc_minima' => 5,
						'max_parc' => 0,
						'max_parc_jl' => 0,
						'max_parc_sj' => 0,
						'juros_loja' => 0,
						'desconto' => 0,
						'auto_capturar' => false,
						'autorizacao' => 3),
					'elo' => array(
						'nome' => 'Elo',
						'codigo' => 'elo',
						'ativo' => false,
						'tipo' => 'credito',
						'valor_minimo' => 5,
						'parc_minima' => 5,
						'max_parc' => 1,
						'max_parc_jl' => 0,
						'max_parc_sj' => 0,
						'juros_loja' => 0,
						'desconto' => 0,
						'auto_capturar' => false,
						'autorizacao' => 3),
					'discover' => array(
						'nome' => 'Discover',
						'codigo' => 'diners',
						'ativo' => false,
						'tipo' => 'credito',
						'valor_minimo' => 5,
						'parc_minima' => 5,
						'max_parc' => 1,
						'max_parc_jl' => 0,
						'max_parc_sj' => 0,
						'juros_loja' => 0,
						'desconto' => 0,
						'auto_capturar' => false,
						'autorizacao' => 3),
					'jcb' => array(
						'nome' => 'JCB',
						'codigo' => 'jcb',
						'ativo' => false,
						'tipo' => 'credito',
						'valor_minimo' => 5,
						'parc_minima' => 5,
						'max_parc' => 1,
						'max_parc_jl' => 0,
						'max_parc_sj' => 0,
						'juros_loja' => 0,
						'desconto' => 0,
						'auto_capturar' => false,
						'autorizacao' => 3),
					'aura' => array(
						'nome' => 'Aura',
						'codigo' => 'aura',
						'ativo' => false,
						'tipo' => 'credito',
						'valor_minimo' => 5,
						'parc_minima' => 5,
						'max_parc' => 1,
						'max_parc_jl' => 0,
						'max_parc_sj' => 0,
						'juros_loja' => 0,
						'desconto' => 0,
						'auto_capturar' => false,
						'autorizacao' => 3)
					),
				'status_pedido' => array(
					'pendente' => 1,
					'erro_sem_retry' => 10,
					'erro_com_retry' => 1,
					'sucesso_sem_captura' => 2,
					'sucesso_com_captura' => 15)
				),
			'cielo_status' => false,
			'cielo_sort_order' => ''
			);
		
		$this->model_setting_setting->editSetting('cielo', $settings_array);
		$this->session->data['success'] = $this->language->get('install_success');
		$this->session->data['GA']['cielo']['ev'][] = 'install';
		return true;
	}

	public function uninstall() {

		if (!$this->user->hasPermission('modify', 'payment/cielo')) {
			
			$this->error['warning'] = $this->language->get('error_permission');
			
		} else {
			
			$this->load->model('tool/backup');
			$txt = $this->model_tool_backup->backup(array(0 => DB_PREFIX . 'order_cielo'));
			
			$file = DIR_LOGS . 'cielo_backup' . date('Ymd-His') . '.sql';
			$handle = fopen($file, 'a+');
			fwrite($handle, $txt);
			fclose($handle);

			$txt = $this->model_tool_backup->backup(array(0 => DB_PREFIX . 'ga_data'));
			
			$file = DIR_LOGS . 'ga_data' . date('Ymd-His') . '.sql';
			$handle = fopen($file, 'a+');
			fwrite($handle, $txt);
			fclose($handle);
			
			$this->model_payment_cielo->uninstallCieloTables();
			$this->model_payment_cielo->uninstallGATables();
			$this->session->data['success'] = $this->language->get('uninstall_success');
			$this->session->data['GA']['cielo']['ev'][] = 'uninstall';
			return true;
		}
	}


}

 ?>