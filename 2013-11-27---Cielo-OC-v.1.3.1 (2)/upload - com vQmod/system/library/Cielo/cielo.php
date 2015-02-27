<?php
/**
 * Módulo Cielo para OpenCart 1.5.3.1 a 1.5.6
 * Integração direta com a Cielo,
 * sem utilização de Gateways de pagamento
 * 
 * Esta classe foi adaptada da classe "Pedido" fornecida
 * pela Cielo no kit de integração.
 * 
 * A classe original é de propriedade da Cielo.
 * Esta adaptação é de uso restrito ao módulo deste pacote.
 * 
 * @author  Victor Schröder <domains@egeeks.com.br>
 * @copyright  Copyright (c) 2012, Victor Schröder. All rights reserved. Must buy a Commercial Licence (per store).
 * @link  http://www.opencart.com/index.php?route=extension/extension/info&extension_id=8855
 */
	
class Cielo	{
	
	private $versao = '1.2.1';
	
	private $config;
	private $customer;
	private $session;
	private $settings;
	private $post;
	
	private $logger;

	private $estabNumero;
	private $estabChave;

	private $dadosPortadorNumero;
	private $dadosPortadorVal;
	private $dadosPortadorInd;
	private $dadosPortadorCodSeg;
	private $dadosPortadorNome;

	private $dadosPedidoNumero;
	private $dadosPedidoValor;
	private $dadosPedidoMoeda = '986';
	private $dadosPedidoData;
	private $dadosPedidoDescricao;
	private $dadosPedidoIdioma = 'PT';
	private $dadosSoftDescriptor;
	private $dadosPedidoTaxaEmbarque;

	private $formaPagamentoBandeira;
	private $formaPagamentoProduto;
	private $formaPagamentoParcelas;

	private $urlRetorno;
	private $autorizar;
	private $capturar;
	private $campoLivre;
	private $bin;
	private $gerarToken;

	private $AVS;
	private $AVSEndereco;
	private $AVSComplemento;
	private $AVSNumero;
	private $AVSBairro;
	private $AVSCEP;

	private $tid;
	private $status;
	private $urlAutenticacao;
	
	private $teste;
	private $nomeOperacao;
	private $desconto;
	private $juros;
	
	private $endereco;
	private $endTestes = 'https://qasecommerce.cielo.com.br/servicos/ecommwsec.do';
	private $endProducao = 'https://ecommerce.cielo.com.br/servicos/ecommwsec.do';
	
	private $estabNumeroTesteLoja = '1006993069';
	private $estabChaveTesteLoja = '25fbb99741c739dd84d7b06ec78c9bac718838630f30b112d033ce2e621b34f3';
	
	private $estabNumeroTesteCielo = '1001734898';
	private $estabChaveTesteCielo = 'e84827130b9837473681c2787007da5914d6359947015a5cdb2b8843db0fa832';

	const ENCODING = 'ISO-8859-1';
	
	public static $lr_array = array('00', '01','04','05','06','07','12','13','14','15','41','51','54','57','58','62','63','76','78','82','91','96','AA','AC','GA','N7');
	
	function __construct($registry) {
		
		$this->registry = $registry;
		$this->config = $registry->get('config');
		//$this->customer = $registry->get('customer');
		$this->session = $registry->get('session');
		$this->cart = $registry->get('cart');
		$this->url = $registry->get('url');
		$this->load = $registry->get('load');
		$this->currency = $registry->get('currency');
		$reg_request = $registry->get('request'); 
		$this->post = $reg_request->post;
	
		$this->settings = $this->config->get('cielo_config');
		
		$this->buyPage = $this->settings['buy_page'];
		
		$this->teste = $this->settings['sandbox'];
		
		if ($this->teste) {
			$this->estabNumero = $this->buyPage == 'cielo' ? $this->estabNumeroTesteCielo : $this->estabNumeroTesteLoja;
			$this->estabChave = $this->buyPage == 'cielo' ? $this->estabChaveTesteCielo : $this->estabChaveTesteLoja;
			$this->endereco = $this->endTestes;
		} else {
			$this->estabNumero = $this->settings['estabelecimento'];
			$this->estabChave = $this->settings['chave'];
			$this->endereco = $this->endProducao;
		}

		$this->logger = new Logger($this->teste);
		
	}
	
	public function get($key) {
		if ($key == 'status') {
			if (isset($this->status)) {
				return $this->status;
			} elseif (isset($this->xmlRecebido)) {
				$XML = simplexml_load_string($this->xmlRecebido, 'SimpleXMLElement', LIBXML_NOCDATA);
				return (isset($XML->status) ? (string)$XML->status : '');
			}
		}
		
		return (isset($this->$key) ? $this->$key : '');
	}
	
	public function set($key, $value) {
		$this->$key = $value;
	}
	
	// Geradores de XML
	private function XMLHeader() {
		return '<?xml version="1.0" encoding="' . self::ENCODING . '" ?>'; 
	}
	
	private function XMLDadosEc() {
		$msg = 	'  <dados-ec>' . "\n" .
				'    <numero>' . $this->estabNumero . '</numero>' . "\n" .
				'    <chave>' . $this->estabChave . '</chave>' . "\n" .
				'  </dados-ec>';

		return $msg;
	}
	
	private function XMLDadosPortador() {
		$msg =  '  <dados-portador>' . "\n" . 
				'    <numero>' . $this->dadosPortadorNumero . '</numero>' . "\n" .
				'    <validade>' . $this->dadosPortadorVal . '</validade>' . "\n" .
				'    <indicador>' . $this->dadosPortadorInd . '</indicador>' . "\n" .
				'    <codigo-seguranca>' . $this->dadosPortadorCodSeg . '</codigo-seguranca>' . "\n";

		// Verifica se Nome do Portador foi informado
		if($this->dadosPortadorNome != null && $this->dadosPortadorNome != '')
			$msg .= '    <nome-portador>' .	$this->dadosPortadorNome . '</nome-portador>' . "\n" ;

		$msg .= '  </dados-portador>';

		return $msg;
	}
	
	private function XMLDadosPedido() {
		
		$this->dadosPedidoData = date("Y-m-d") . "T" . date("H:i:s");
		
		$msg =  '  <dados-pedido>' . "\n" .
				'    <numero>' . $this->dadosPedidoNumero . '</numero>' . "\n" .
				'    <valor>' . $this->dadosPedidoValor . '</valor>' . "\n" .
				'    <moeda>' . $this->dadosPedidoMoeda . '</moeda>' . "\n" .
				'    <data-hora>' .	$this->dadosPedidoData . '</data-hora>' . "\n";

		if($this->dadosPedidoDescricao != null && $this->dadosPedidoDescricao != "") 
			$msg .= '    <descricao>' . $this->dadosPedidoDescricao . '</descricao>' . "\n";

		$msg .= '    <idioma>' . $this->dadosPedidoIdioma . '</idioma>' . "\n";
		
		if($this->dadosSoftDescriptor != null && $this->dadosSoftDescriptor != "") 
			$msg .= '    <soft-descriptor>' . $this->dadosSoftDescriptor . '</soft-descriptor>' . "\n";

		if($this->dadosPedidoTaxaEmbarque != null && $this->dadosPedidoTaxaEmbarque != "") 
			$msg .= '    <taxa-embarque>' . $this->dadosSoftDescriptor . '</taxa-embarque>' . "\n";
		
		$msg .= '  </dados-pedido>';

		return $msg;
	}
	
	private function XMLFormaPagamento() {
		$msg =  '  <forma-pagamento>' . "\n" .
				'    <bandeira>' . $this->formaPagamentoBandeira . '</bandeira>' . "\n" .
				'    <produto>' . $this->formaPagamentoProduto . '</produto>' . "\n" .
				'    <parcelas>' . $this->formaPagamentoParcelas . '</parcelas>' . "\n" .
				'  </forma-pagamento>';

		return $msg;
	}
	 
	private function XMLUrlRetorno() {
		$msg =  '  <url-retorno>' . $this->urlRetorno . '</url-retorno>';
		return $msg;
	}
	
	private function XMLAutorizar() {
		$msg = '  <autorizar>' . $this->autorizar . '</autorizar>';
		return $msg;
	}
	
	private function XMLCapturar() {
		$msg = '  <capturar>' . ($this->capturar ? 'true' : 'false') . '</capturar>';
		return $msg;
	}
	
	private function XMLCampoLivre() {
		$msg = '  <campo-livre>' . $this->campoLivre . '</campo-livre>';
		return $msg;
	}
	
	private function XMLBin() {
		$msg = '  <bin>' . $this->bin . '</bin>';
		return $msg;
	}

	private function XMLGerarToken() {
		$msg = '  <gerar-token>' . $this->gerarToken . '</gerar-token>';
		return $msg;
	}

	private function XMLAVS() {
		$msg = '  <avs>' . "\n" .
			   '    <![CDATA[' . "\n" .
			   '      <dados-avs>' . "\n" .
			   '        <endereco>'. $this->AVSEndereco .'</endereco>' . "\n" .
			   '        <complemento>'. $this->AVSComplemento .'</complemento>' . "\n" .
			   '        <numero>'. $this->AVSNumero .'</numero>' . "\n" .
			   '        <bairro>'. $this->AVSBairro .'</bairro>' . "\n" .
			   '        <cep>'. $this->AVSCEP .'</cep>' . "\n" .
			   '      </dados-avs>' . "\n" .
			   '    ]]>' . "\n" .
			   '  </avs>';
		return $msg;
	}

	
	public function processar() {
	
		$this->transacao = 'transacao';
		
		$this->operacao = $this->settings['operacoes'][$this->post['operacao']];
		
		
		$this->formaPagamentoBandeira = $this->operacao['codigo'];
		if ($this->operacao['tipo'] == 'debito') {
			$this->formaPagamentoProduto = 'A';
			$this->formaPagamentoParcelas = 1;
		} elseif ((int)$this->post['num_parcelas'] == 1) {
			$this->formaPagamentoProduto = '1';
			$this->formaPagamentoParcelas = 1;
		} elseif ((int)$this->post['num_parcelas'] <= $this->operacao['max_parc_sj']) {
			$this->formaPagamentoProduto = '2';
			$this->formaPagamentoParcelas = (int)$this->post['num_parcelas'];
		} else {
			$this->formaPagamentoProduto = (int)$this->post['num_parcelas'] <= $this->operacao['max_parc_jl'] ? '2' : '3';
			$this->formaPagamentoParcelas = (int)$this->post['num_parcelas'];
		}
		
		$this->capturar = $this->operacao['auto_capturar'];
		$this->autorizar = $this->operacao['autorizacao'];
		$this->autenticar = $this->autorizar <= 2 ? true : false;
		
		$this->dadosPortadorNome = isset($this->post['nome_portador']) ? $this->post['nome_portador'] : '';
		$this->dadosPortadorNumero = isset($this->post['numero_cartao']) ? $this->post['numero_cartao'] : '';
		$this->dadosPortadorVal = isset($this->post['validade_cartao']) ? $this->post['validade_cartao'] : '';

		if ($this->post['codigo_ilegivel']) {
			$this->dadosPortadorInd = '2';
		} elseif ($this->post['codigo_inexistente']) {
			$this->dadosPortadorInd = '9';
		} else {
			$this->dadosPortadorInd = ($this->post['codigo_seguranca'] == null || $this->post['codigo_seguranca'] == '') ? '0' : '1';
		}

		$this->dadosPortadorCodSeg = isset($this->post['codigo_seguranca']) ? $this->post['codigo_seguranca'] : '';
		
		$this->dadosPedidoNumero = $this->session->data['order_id'];

		$this->dadosPedidoValor = $this->calcularTotal();
		
		$this->dadosSoftDescriptor = $this->settings['soft_descriptor'] == 'num_pedido' ? sprintf('P%06u', (int)$this->session->data['order_id']) : $this->settings['soft_descriptor'];
		
		$this->urlRetorno = $this->url->link('payment/cielo/retorno', '', 'SSL');

		$this->nomeOperacao = $this->operacao['nome'] . ($this->formaPagamentoParcelas == 1 ? '' : ' ' . $this->formaPagamentoParcelas . 'x');
		
		$xml_resposta = $this->enviarTransacao();
		
		$resposta = simplexml_load_string($xml_resposta, 'SimpleXMLElement', LIBXML_NOCDATA);

		if (!isset($resposta->tid)) return array('tipo' => 'erro', 'codigo' => (string)$resposta->codigo, 'xml' => $resposta);
		
		$this->tid = (string)$resposta->tid;
		$this->pan = (string)$resposta->pan;
		$this->status = (string)$resposta->status;
	
		$this->urlAutenticacao = (string)$resposta->{'url-autenticacao'};
		
		if (isset($resposta->autenticacao)) $this->autenticacao = (string)$resposta->autenticacao;
		
		return array('tipo' => 'transacao', 'codigo' => (string)$resposta->status, 'xml' => $resposta);
			
	}
	
	private function calcularTotal() {
		
		$op = $this->operacao;
		
		$p = $this->formaPagamentoParcelas;

		$this->load->model('checkout/order');
		$this->model_checkout_order = $this->registry->get('model_checkout_order');
		
		$order_data = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
		$total = $order_data['total'];
		
		$total_cart = $this->cart->getTotal();
	
		if ($this->config->get('config_currency') != 'BRL') {
			$total = $this->currency->convert($total, $this->config->get('config_currency'), 'BRL');
			$total_cart = $this->currency->convert($total_cart, $this->config->get('config_currency'), 'BRL');
		}

		$desc = $total_cart * $op['desconto'] * 0.01;
		
		$total_desc = max(0, $total - $desc);
		
		if ($p == 1) {
			$valor = $total_desc;
			$this->desconto = -$desc;
		} elseif ($p <= $op['max_parc_sj']) {
			$valor = $total;
		} elseif ($op['juros_loja'] != 0 && $p <= $op['max_parc_jl']) {
			$valor = $p * $total * $op['juros_loja'] * 0.01 / (1 - 1/pow(1 + $op['juros_loja'] * 0.01, $p));
			$this->juros = $valor - $total;
		} else {
			$valor = $total;
		}
		
		return (int)($valor * 100);
	}
	
	
	// Envia Requisição
	public function enviar($post, $transacao) {
		$this->logger->write('ENVIO: ' . $post, $transacao);
		$this->xmlEnviado = preg_replace('/ISO-8859-1/', 'UTF-8', $post);
		$this->xmlEnviado = preg_replace('/<codigo-seguranca>[0-9]+</', '<codigo-seguranca>XXX<', $this->xmlEnviado);
		
		$post = utf8_decode($post);

		// ENVIA REQUISIÇÃO SITE CIELO
		$resposta = utf8_encode($this->httprequest($this->endereco, 'mensagem=' . $post));
		$this->logger->write('RESPOSTA: ' . $resposta, $transacao);
		$this->xmlRecebido = preg_replace('/ISO-8859-1/', 'UTF-8', $resposta);
		$this->xmlRecebido = preg_replace('/<codigo-seguranca>[0-9]+</', '<codigo-seguranca>XXX<', $this->xmlRecebido);

		return $resposta;
	}
	
	// Envia requisição
	private function httprequest($endereco, $post) {
		
		$sessao_curl = curl_init();

		curl_setopt($sessao_curl, CURLOPT_URL, $endereco);
		curl_setopt($sessao_curl, CURLOPT_FAILONERROR, true);
		
		//  CURLOPT_SSL_VERIFYPEER
		//  verifica a validade do certificado
		curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYPEER, true);
		//  CURLOPPT_SSL_VERIFYHOST
		//  verifica se a identidade do servidor bate com aquela informada no certificado
		curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYHOST, 2);
		
		//  CURLOPT_SSL_CAINFO
		//  informa a localização do certificado para verificação com o peer
		curl_setopt($sessao_curl, CURLOPT_CAINFO, DIR_SYSTEM .
			'library/Cielo/ssl/VeriSignClass3PublicPrimaryCertificationAuthority-G5.crt');
		curl_setopt($sessao_curl, CURLOPT_SSLVERSION, 3);
		
		//  CURLOPT_CONNECTTIMEOUT
		//  o tempo em segundos de espera para obter uma conexão
		curl_setopt($sessao_curl, CURLOPT_CONNECTTIMEOUT, 10);
		
		//  CURLOPT_TIMEOUT
		//  o tempo máximo em segundos de espera para a execução da requisição (curl_exec)
		curl_setopt($sessao_curl, CURLOPT_TIMEOUT, 40);
		
		//  CURLOPT_RETURNTRANSFER
		//  TRUE para curl_exec retornar uma string de resultado em caso de sucesso, ao
		//  invés de imprimir o resultado na tela. Retorna FALSE se há problemas na requisição
		curl_setopt($sessao_curl, CURLOPT_RETURNTRANSFER, true);
		
		curl_setopt($sessao_curl, CURLOPT_POST, true);
		curl_setopt($sessao_curl, CURLOPT_POSTFIELDS, $post );
		
		$resultado = curl_exec($sessao_curl);
				
		if ($resultado) {
			$return = $resultado;
		} else {
			$return = '<?xml version="1.0" encoding="UTF-8" ?><erro><codigo>curl_error</codigo><mensagem>' . curl_error($sessao_curl) . '</mensagem></erro>';
		}
		
		curl_close($sessao_curl);
		
		return $return;
	}
	
	
	// Requisições
	private function enviarTransacao() {
						
		$msg =  $this->XMLHeader() . "\n" .
			    '<requisicao-transacao id="' . md5(date("YmdHisu")) . '" versao="' . $this->versao . '">' . "\n" .
				$this->XMLDadosEc() . "\n" .
				($this->buyPage == 'loja' ? $this->XMLDadosPortador() . "\n" : '') .
				$this->XMLDadosPedido() . "\n" .
				$this->XMLFormaPagamento() . "\n" .
				($this->buyPage == 'cielo' || $this->autenticar ? $this->XMLUrlRetorno() . "\n" : '') .
				$this->XMLAutorizar() . "\n" .
				$this->XMLCapturar() . "\n" .
				$this->XMLCampoLivre() . "\n" .
				($this->gerarToken ? $this->XMLGerarToken() . "\n" : '') .
				($this->AVS ? $this->XMLAVS() . "\n" : '') .
				'</requisicao-transacao>';
		
		$xml_resposta = $this->enviar($msg, 'Transacao');
		return $xml_resposta;
	}
	
	public function autorizarTID($TID) {
		
		$this->transacao = 'autorizar_tid';
		
		$this->tid = $TID;
		
		$msg =  $this->XMLHeader() . "\n" .
				'<requisicao-autorizacao-tid id="' . md5(date("YmdHisu")) . '" versao="' . $this->versao . '">' . "\n" .
				'  <tid>' . $TID . '</tid>' . "\n" .
				$this->XMLDadosEc() . "\n" .
				'</requisicao-autorizacao-tid>';
				
		$xml_resposta = $this->enviar($msg, "Autorizacao Tid");
		
		$resposta = simplexml_load_string($xml_resposta, 'SimpleXMLElement', LIBXML_NOCDATA);
		
		return array('tipo' => 'autorização TID', 'xml' => $resposta);
	}
	
	public function capturar($TID, $valor = '', $anexo = '') {
		
		$this->transacao = 'capturar';
		
		$this->tid = $TID;
		$this->dadosPedidoValor = $valor;
				
		$msg = 	$this->XMLHeader() . "\n" .
				'<requisicao-captura id="' . md5(date("YmdHisu")) . '" versao="' . $this->versao . '">' . "\n" .
				'  <tid>' . $this->tid . '</tid>' . "\n" .
				$this->XMLDadosEc() . "\n" .
				($valor ? '  <valor>' . $valor . '</valor>' . "\n" : '') .
				($anexo ? '  <anexo>' . $anexo . '</anexo>' . "\n" : '') .
				'</requisicao-captura>';
		
		$xml_resposta = $this->enviar($msg, "Captura");
		
		$resposta = simplexml_load_string($xml_resposta, 'SimpleXMLElement', LIBXML_NOCDATA);
		
		return array('tipo' => 'captura', 'xml' => $resposta);
	}
	
	public function cancelar($TID, $valor = '') {

		$this->transacao = 'cancelar';
		
		$this->tid = $TID;
		$this->dadosPedidoValor = $valor;
		
		$msg = 	$this->XMLHeader() . "\n" . 
				'<requisicao-cancelamento id="' . md5(date("YmdHisu")) . '" versao="' . $this->versao . '">' . "\n" .
				'  <tid>' . $TID . '</tid>' . "\n" .
				$this->XMLDadosEc() . "\n" .
				($valor ? '  <valor>' . $valor . '</valor>' . "\n" : '') .
				'</requisicao-cancelamento>';
		
		$xml_resposta = $this->enviar($msg, 'Cancelamento');
		
		$resposta = simplexml_load_string($xml_resposta, 'SimpleXMLElement', LIBXML_NOCDATA);

		return array('tipo' => 'cancelamento', 'xml' => $resposta);
	}
	
	public function consultar($TID) {
		
		$this->transacao = 'consultar';
		
		$this->tid = $TID;
		
		$msg =  $this->XMLHeader() . "\n" .
				'<requisicao-consulta id="' . md5(date("YmdHisu")) . '" versao="' . $this->versao . '">' . "\n" .
				'  <tid>' . $TID . '</tid>' . "\n" .
				$this->XMLDadosEc() . "\n" .
				'</requisicao-consulta>';
		
		$xml_resposta = $this->enviar($msg, 'Consulta');
		
		$resposta = simplexml_load_string($xml_resposta, 'SimpleXMLElement', LIBXML_NOCDATA);
		
		return array('tipo' => 'consulta', 'xml' => $resposta);
	}
	
	public function toString() {
		$msg =  $this->XMLHeader() .
				'<objeto-pedido>' .
				'<tid>' . $this->tid . '</tid>' .
				'<status>' . $this->status . '</status>' .
				$this->XMLDadosEc() .
				$this->XMLDadosPedido() .
				$this->XMLFormaPagamento() .
				'</objeto-pedido>';
				
		return $msg;
	}
	
	public function fromString($str) {
		$dadosEc = 'dados-ec';
		$dadosPedido = 'dados-pedido';
		$dataHora = 'data-hora';
		$formaPagamento = 'forma-pagamento';
		
		$XML = simplexml_load_string($str, 'SimpleXMLElement', LIBXML_NOCDATA);
		
		$this->tid = $XML->tid;
		$this->status = $XML->status;
		$this->estabChave = $XML->$dadosEc->chave;
		$this->estabNumero = $XML->$dadosEc->numero;
		$this->dadosPedidoNumero = $XML->$dadosPedido->numero;
		$this->dadosPedidoData = $XML->$dadosPedido->$dataHora;
		$this->dadosPedidoValor = $XML->$dadosPedido->valor;
		$this->formaPagamentoProduto = $XML->$formaPagamento->produto;
		$this->formaPagamentoParcelas = $XML->$formaPagamento->parcelas;
	}
	
	public function getStatus() {
		$status;
		
		switch($this->status) {
			case "0": $status = "Criada";
				break;
			case "1": $status = "Em andamento";
				break;
			case "2": $status = "Autenticada";
				break;
			case "3": $status = "Não autenticada";
				break;
			case "4": $status = "Autorizada";
				break;
			case "5": $status = "Não autorizada";
				break;
			case "6": $status = "Capturada";
				break;
			case "8": $status = "Não capturada";
				break;
			case "9": $status = "Cancelada";
				break;
			case "10": $status = "Em autenticação";
				break;
			default: $status = "n/a";
				break;
		}
		
		return $status;
	}
	
}
	
?>