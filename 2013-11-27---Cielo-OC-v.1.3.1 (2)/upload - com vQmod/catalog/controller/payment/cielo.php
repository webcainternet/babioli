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
		
	private $cielo_config;
	
	private $json;
	
	public function __construct($registry) {
		parent::__construct($registry);
		$this->cielo_config = $this->config->get('cielo_config');
		$this->language->load('payment/cielo');
		$this->load->model('payment/cielo');
		$this->load->model('checkout/order');
		$this->session->data['GA']['cielo']['user'] = 'catalog';
		$this->load->library('Cielo/includes');
		if ($this->cielo_config['sandbox'])	$this->session->data['cielo']['warning'] = $this->language->get('warning_sandbox_mode');
	
	}
	
	protected function index() {
		
		$strings = array(
			'cielo_buy_page_info',
			'loja_buy_page_info',
			'erro_sem_operacoes',
			'entry_nome_portador',
			'entry_numero_cartao',
			'entry_validade_cartao',
			'entry_codigo_seguranca',
			'form_1_parcela',
			'form_1_parcela_desconto',
			'form_parcelas_sem_juros',
			'form_parcelas_com_juros',
			'form_parcelas_juros_adm',
			'text_script_nao_feche',
			'text_script_title',
			'text_script_erro_preenchimento',
			'text_script_falha_comunicacao',
			'text_script_ocorreu_um_erro',
			'text_script_redirecionando',
			'text_script_pedido_aprovado',
			'text_script_erro_inesperado',
			'text_script_erro_timeout',
			'text_script_erro_tecnico',
			'text_script_botao_retornar',
			'text_script_botao_retry',
			'text_script_botao_redirecionar',
			'text_script_botao_finalizar',
			'text_script_botao_contato',
			'text_codigo_inexistente',
			'text_codigo_ilegivel',
			'text_envia_erro',
			'cielo_instrucoes_cvv',
			'button_confirm'
			);
			
		foreach($strings as $string) {
			$this->data[$string] = $this->language->get($string);
		}
		
		$this->data['buy_page'] = $this->cielo_config['buy_page'];
		
		$this->data['customer_name'] = isset($this->session->data['guest']['firstname']) ? $this->session->data['guest']['firstname'] : $this->customer->getFirstName();
		$this->data['customer_email'] = isset($this->session->data['guest']['email']) ? $this->session->data['guest']['email'] : $this->customer->getEmail();
		
		$order_data = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
		$this->total = $order_data['total'];
		
		$this->orderCurrency = $order_data['currency_code'];
		
		//$this->session->data['cielo']['total'] = $this->total;
		
		$this->cart_total = $this->cart->getTotal();
		
		//$this->session->data['cielo']['cart_total'] = $this->cart_total;
				
		if (isset($this->session->data['cielo']['warning'])) {
			$this->data['cielo_warning'] = $this->session->data['cielo']['warning'];
			unset($this->session->data['cielo']['warning']);
		}
		
		foreach($this->cielo_config['operacoes'] as $key => $operacao) {
			if($operacao['ativo']) $this->build($key, $operacao);
		}
		
		$this->data['operacoes_erro'] = isset($this->data['operacoes']) ? false : true;
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/cielo.tpl')) {
			$this->template	= $this->config->get('config_template') . '/template/payment/cielo.tpl';
		} else {
			$this->template	= 'default/template/payment/cielo.tpl';
		}
		
		$this->render();
	}
	
	private function build($key, $operacao) {
				
		$atotal = $this->total;
		
		$acart_total = $this->cart_total;
		
		if ($this->config->get('config_currency') != 'BRL') {
			$atotal = $this->currency->convert($atotal, $this->config->get('config_currency'), 'BRL');
			$acart_total = $this->currency->convert($acart_total, $this->config->get('config_currency'), 'BRL');
		}
		
		$desc = $acart_total * $operacao['desconto'] * 0.01;
		
		$atotal_desc = max(0, $atotal - $desc);

		if ($atotal_desc < $operacao['valor_minimo']) return;
		
		$parcelas = array();
		
		$parcelas[1]['valor'] = $atotal_desc;
		$parcelas[1]['valor_parc'] = $atotal_desc;
		$parcelas[1]['juros'] = false;
		$parcelas[1]['desconto'] = $operacao['desconto'];

		for ($i = 2; $i <= $operacao['max_parc']; $i++) {
			
			if ($atotal/$i < $operacao['parc_minima']) break;
			
			$parcelas[$i]['num_parc'] = $i;
			
			
			if ($i <= $operacao['max_parc_sj']) {
				$parcelas[$i]['valor'] = $atotal;
				$parcelas[$i]['valor_parc'] = $atotal/$i;
				$parcelas[$i]['juros'] = false;
				continue;
			}

			if ($operacao['juros_loja'] != 0 && $i <= $operacao['max_parc_jl']) {
				$temp = $atotal * $operacao['juros_loja'] * 0.01 / (1 - 1/pow(1 + $operacao['juros_loja'] * 0.01, $i));
				$parcelas[$i]['valor'] = $temp * $i;
				$parcelas[$i]['valor_parc'] = $temp;
				$parcelas[$i]['juros'] = $operacao['juros_loja'];
				unset($temp);
			} else {
				$parcelas[$i]['valor'] = $atotal;
				$parcelas[$i]['valor_parc'] = 0;
				$parcelas[$i]['juros'] = true;
			}
		}
		
		foreach ($parcelas as &$parcela) {
			$parcela['valor'] = $this->currency->format($this->currency->convert($parcela['valor'], 'BRL', $this->config->get('config_currency')));
			$parcela['valor_parc'] = $this->currency->format($this->currency->convert($parcela['valor_parc'], 'BRL', $this->config->get('config_currency')));
		}
				
		$this->data['operacoes'][] = array(
										'nome' => $operacao['nome'],
										'key' => $key,
										'parcelas' => $parcelas
										);
		
		unset($parcelas);
		
	}
	
	public function confirm() {
				
		if (!$this->validate()) {
			$this->json['error']['message'] = implode('<br />', $this->json['error']);
			$this->json['error']['code'] = 'XX';
			$this->response->setOutput(json_encode($this->json));
			return;
		}
		
		$this->session->data['cielo']['operacao'] = $this->request->post['operacao'];
		
		$Cielo = new Cielo($this->registry);
		
		$sucesso = $this->traduzir($Cielo->processar());
		
		$this->model_payment_cielo->add($Cielo);

		if (!$sucesso) {
			$status = $this->json['error']['retry'] == 'yes' ? $this->cielo_config['status_pedido']['erro_com_retry'] : $this->cielo_config['status_pedido']['erro_sem_retry'];
			$this->model_checkout_order->update($this->session->data['order_id'], $status);
			$this->response->setOutput(json_encode($this->json));
			return;
		}
		
		if ($sucesso && isset($this->json['redirect'])) {
			$this->model_checkout_order->update($this->session->data['order_id'], $this->cielo_config['status_pedido']['pendente']);
			
//			$this->session->data['cielo']['tid'] = $Cielo->get('tid');
			$this->session->data['cielo']['nomeOperacao'] = $Cielo->get('nomeOperacao');
			$this->session->data['cielo']['valor'] = $Cielo->get('dadosPedidoValor');
			$this->session->data['cielo']['desconto'] = $Cielo->get('desconto');
			$this->session->data['cielo']['juros'] = $Cielo->get('juros');
			$this->response->setOutput(json_encode($this->json));
			return;
		}
		
		if ($sucesso) {

			unset($this->session->data['cielo']);
			
			$status = $this->cielo_config['operacoes'][$this->request->post['operacao']]['auto_capturar'] ? $this->cielo_config['status_pedido']['sucesso_com_captura'] : $this->cielo_config['status_pedido']['sucesso_sem_captura'];

			$this->model_checkout_order->confirm($this->session->data['order_id'], $status);
			
			$this->model_payment_cielo->confirm($this->session->data['order_id'], $Cielo);
			
			$this->response->setOutput(json_encode($this->json));
		}
		
		
	}
	
	private function validate() {
		
		$this->json = array();
		
		$bandeiras = array();
		
		foreach($this->cielo_config['operacoes'] as $key => $operacao) {
			if($operacao['ativo']) $bandeiras[] = $key;
		}

		if(!isset($this->request->post['operacao'])) {
			$this->json['error']['operacao'] = $this->language->get('erro_bandeira_nao_selecionada');
		} elseif (!in_array($this->request->post['operacao'], $bandeiras)) {
			$this->json['error']['operacao'] = $this->language->get('erro_bandeira_invalida');
		}
		
		if(!isset($this->request->post['num_parcelas'])) {
			$this->json['error']['num_parcelas'] = $this->language->get('erro_numero_parcelas_nao_selecionado');
		} elseif ((int)$this->request->post['num_parcelas'] < 1 || (int)$this->request->post['num_parcelas'] > $this->cielo_config['operacoes'][$this->request->post['operacao']]['max_parc']) {
			$this->json['error']['num_parcelas'] = $this->language->get('erro_numero_parcelas_invalido');
		}
	
		if ($this->cielo_config['buy_page'] == 'loja') {
			
			$this->request->post['codigo_ilegivel'] = isset($this->request->post['codigo_ilegivel']) ? (bool)$this->request->post['codigo_ilegivel'] : false;
			$this->request->post['codigo_inexistente'] = isset($this->request->post['codigo_inexistente']) ? (bool)$this->request->post['codigo_inexistente'] : false;

			if(isset($this->request->post['codigo_seguranca'])) {
				$this->request->post['codigo_seguranca'] = preg_replace('/\D/', '', $this->request->post['codigo_seguranca']);
			} else {
				$this->request->post['codigo_seguranca'] = '';
			}
			
			if(isset($this->request->post['nome_portador'])) {
				$this->request->post['nome_portador'] = mb_strtoupper(preg_replace('/^\s+|[^\w\s]|(?<!\w)\s{2,}|\s+$/u', '', $this->request->post['nome_portador']), 'UTF-8');
			} else {
				$this->request->post['nome_portador'] = '';
			}
			
			if(isset($this->request->post['numero_cartao'])) {
				$this->request->post['numero_cartao'] = preg_replace('/\D/', '', $this->request->post['numero_cartao']);
				if (!$this->luhn($this->request->post['numero_cartao'])) $this->json['error']['numero_cartao'] = $this->language->get('erro_numero_cartao_invalido');
			} else {
				$this->request->post['numero_cartao'] = '';
				$this->json['error']['numero_cartao'] = $this->language->get('erro_numero_cartao_nao_preenchido');
			}
			
			if(isset($this->request->post['val_ano']) && isset($this->request->post['val_ano'])) {
				$this->request->post['validade_cartao'] = preg_replace('/\D/', '', $this->request->post['val_ano'] . $this->request->post['val_mes']);
				if ((int)$this->request->post['validade_cartao'] < (int)date('Ym')) $this->json['error']['validade_cartao'] = $this->language->get('erro_validade_inferior_atual');
			} else {
				$this->request->post['validade_cartao'] = '';
				$this->json['error']['validade_cartao'] = $this->language->get('erro_validade_nao_preenchida');
			}
		}
		
		if ($this->cielo_config['buy_page'] == 'cielo') {
		
			$this->request->post['numero_cartao'] = '';
			$this->request->post['validade_cartao'] = '';
			$this->request->post['codigo_ilegivel'] = false;
			$this->request->post['codigo_inexistente'] = false;
			$this->request->post['codigo_seguranca'] = '';
		
		}
		
		if (isset($this->json['error'])) return false;
		
		return true;
	
	}
	
	private function luhn($value) {
		
		$checksum = 0;
		$length = strlen($value);
		
		for ($i = 1 - ($length % 2); $i < $length; $i += 2) {
			$checksum += (int)substr($value, $i, 1);
		}
		
		for ($i = ($length % 2); $i < $length; $i += 2) {
			$digit = (int)substr($value, $i, 1) * 2;
			$checksum += ($digit < 10) ? $digit : $digit - 9;
		}
		
	 	return ($checksum % 10 == 0);

	}
	
	private function traduzir($resultado) {
		
		$this->json = array();
		
		$XML = $resultado['xml'];
			
		if (!isset($XML->tid) && $resultado['codigo'] == 'curl_error') {
			$this->json['error']['retry'] = 'yes';
			$this->json['error']['code'] = 'SERVER';
			$this->json['error']['message']	= $this->language->get('erro_code_server');
			return false;
		}
		
		if (!isset($XML->tid) && $resultado['codigo'] != 'curl_error' && in_array((int)$XML->codigo, array(3,11,12,15,17,18,97,98,99))) {
			$this->json['error']['retry'] = 'yes';
			$this->json['error']['code'] = (string)$XML->codigo;
			$this->json['error']['message']	= $this->language->get('XML_error_code_' . (string)$XML->codigo);
			return false;
		}
				
		if (!isset($XML->tid) && $resultado['codigo'] != 'curl_error') {
			$this->json['error']['retry'] = 'no';
			$this->json['error']['code'] = (string)$XML->codigo;
			$nnn = !in_array((int)$XML->codigo, array(1,2,3,10,11,12,13,14,15,16,17,18,19,20,21,25,30,31,32,33,40,41,42,43,53,97,98,99));
			$this->json['error']['message']	= $this->language->get('XML_error_code_' . ($nnn ? 'NNN' : (string)$XML->codigo));
			return false;
		}
		
		if (isset($XML->autorizacao->lr) && in_array((string)$XML->autorizacao->lr, array('06','51','76','78','91','96','AA'))) {
			$this->json['error']['retry'] = 'yes';
			$this->json['error']['code'] = (string)$XML->autorizacao->lr;
			$this->json['error']['message']	= $this->language->get('XML_lr_code_' . (string)$XML->autorizacao->lr);
			$this->session->data['cielo']['tid'] = (string)$XML->tid;
			$this->session->data['cielo']['tid_status'] = (string)$XML->status;
			return false;
		}
		
		if (isset($XML->autorizacao->lr) && $XML->autorizacao->lr != '00' && !isset($XML->{'url-autenticacao'})) {
			$this->json['error']['retry'] = 'no';
			$this->json['error']['code'] = (string)$XML->autorizacao->lr;
			$nnn = !in_array((string)$XML->autorizacao->lr, array('01','04','05','06','07','12','13','14','15','41','51','54','57','58','62','63','76','78','82','91','96','AA','AC','GA','N7'));
			$this->json['error']['message']	= $this->language->get('XML_lr_code_' .  ($nnn ? 'NNN' : (string)$XML->autorizacao->lr));
			return false;
		}
		
		$operacao = $this->session->data['cielo']['operacao'];
		
		if (isset($XML->{'url-autenticacao'}) && ($this->cielo_config['buy_page'] == 'cielo' || in_array($this->cielo_config['operacoes'][$operacao]['autorizacao'], array(0, 1, 2)))) {
			$this->json['redirect'] = (string)$XML->{'url-autenticacao'};
			$this->session->data['cielo']['tid'] = (string)$XML->tid;
			$this->session->data['cielo']['tid_status'] = (string)$XML->status;
			return true;
		}
		
		if (isset($XML->autorizacao->lr) && (string)$XML->autorizacao->lr == '00') {
			$this->json['success'] = 'success';
			$this->json['final_url'] = $this->url->link('checkout/success');
			return true;
		} 
		
		$operacao = $this->cielo_config['operacoes'][$this->session->data['cielo']['operacao']];
		
		switch ((string)$XML->status) {
			case '4': // Autorizada
			case '6': // Capturada
				$this->json['success'] = 'success';
				$this->json['final_url'] = $this->url->link('checkout/success');
				$sucesso = true;
				break;
			case '0': // Criada
			case '1': // Em andamento
			case '3': // Não autenticada
			case '10': // Em autenticação
				$this->json['error']['retry'] = 'yes';
				$this->json['error']['code'] = 'Status' . (string)$XML->status;
				$this->json['error']['message']	= $this->language->get('XML_status_code_' . (string)$XML->status);
				$sucesso = false;
				break;
			case '5': // Não autorizada
			case '9': // Cancelada
			case '12': // Em cancelamento
				$this->json['error']['retry'] = 'no';
				$this->json['error']['code'] = 'Status' . (string)$XML->status;
				$this->json['error']['message']	= $this->language->get('XML_status_code_' . (string)$XML->status);
				$sucesso = false;
				break;
			case '2': // Autenticada
				if ($operacao['autorizacao'] === 0) {
					$this->json['success'] = 'success';
					$this->json['final_url'] = $this->url->link('checkout/success');
					$sucesso = true;
				} else {
					$this->json['error']['retry'] = 'yes';
					$this->json['error']['code'] = 'Status' . (string)$XML->status;
					$this->json['error']['message']	= $this->language->get('XML_status_code_' . (string)$XML->status);
					$sucesso = false;
				}
				break;
			case '8': // Não capturada
				if (!$operacao['auto_capturar']) {
					$this->json['success'] = 'success';
					$this->json['final_url'] = $this->url->link('checkout/success');
					$sucesso = true;
				} else {
					$this->json['error']['retry'] = 'yes';
					$this->json['error']['code'] = 'Status' . (string)$XML->status;
					$this->json['error']['message']	= $this->language->get('XML_status_code_' . (string)$XML->status);
					$sucesso = false;
				}
				break;
			default: // Não definido
				$this->json['error']['retry'] = 'no';
				$this->json['error']['code'] = 'StatusNA';
				$this->json['error']['message']	= $this->language->get('XML_status_code_NA');
				break;
		}
		
		return $sucesso;
		
	}
		
	public function retorno() {
	
		$Cielo = new Cielo($this->registry);
		
		$Cielo->set('dadosPedidoNumero', $this->session->data['order_id']);
		$Cielo->set('dadosPedidoValor', $this->session->data['cielo']['valor']);
		$Cielo->set('nomeOperacao', $this->session->data['cielo']['nomeOperacao']);
		if($this->session->data['cielo']['desconto']) $Cielo->set('desconto', $this->session->data['cielo']['desconto']);
		if($this->session->data['cielo']['juros']) $Cielo->set('juros', $this->session->data['cielo']['juros']);
		
		$sucesso = $this->traduzir($Cielo->consultar($this->session->data['cielo']['tid']));
		
		$this->model_payment_cielo->add($Cielo);

		if ($sucesso) {
			
			$status = $this->cielo_config['operacoes'][$this->session->data['cielo']['operacao']]['auto_capturar'] ? $this->cielo_config['status_pedido']['sucesso_com_captura'] : $this->cielo_config['status_pedido']['sucesso_sem_captura'];
			$this->model_checkout_order->confirm($this->session->data['order_id'], $status);
			
			
			$this->model_payment_cielo->confirm($this->session->data['order_id'], $Cielo);
			
			unset($this->session->data['cielo']);
			
			$this->redirect($this->url->link('checkout/success'));
	
		} else {
		
			$status = $this->json['error']['retry'] == 'yes' ? $this->cielo_config['status_pedido']['erro_com_retry'] : $this->cielo_config['status_pedido']['erro_sem_retry'];
			$this->model_checkout_order->update($this->session->data['order_id'], $status);
		}
			
		$this->data['cielo_json'] = $this->json;
			
		$this->document->setTitle($this->language->get('retorno_heading_title')); 
			
		$strings = array(
			'retorno_heading_title',
			'retorno_compra_nao_confirmada',
			'retorno_codigo_evento',
			'retorno_descricao_evento',
			'retorno_erro_nao_definitivo',
			'retorno_escolher_outra_forma',
			'retorno_voltar_ao_checkout',
			'button_continue'
		);
		
		foreach($strings as $string) {
			$this->data[$string] = $this->language->get($string);
		}
				
		$this->data['continue'] = $this->url->link('checkout/checkout', '', 'SSL');
						
		if (isset($this->session->data['cielo']['warning'])) {
			$this->data['cielo_warning'] = $this->session->data['cielo']['warning'];
			unset($this->session->data['cielo']['warning']);
		}
		
		$this->data['breadcrumbs'] = array();
		
      	$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
			'separator' => false
      	); 
		
      	$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_checkout'),
			'href'      => $this->url->link('checkout/checkout', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
      	);
		
      	$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('retorno_heading_title'),
			'href'      => '#',
			'separator' => $this->language->get('text_separator')
      	);
			
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/cielo_retorno.tpl')) {
			$this->template	= $this->config->get('config_template') . '/template/payment/cielo_retorno.tpl';
		} else {
			$this->template	= 'default/template/payment/cielo_retorno.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);
		
		$this->response->setOutput($this->render());
	}

}
?>