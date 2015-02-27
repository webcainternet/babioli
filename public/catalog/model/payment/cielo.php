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

class ModelPaymentCielo extends Model {
    
    public function getMethod() {

		$this->load->language('payment/cielo');
		
		$cielo_config = $this->config->get('cielo_config');
		
		foreach($cielo_config['operacoes'] as $operacao) {
			if($operacao['ativo']) $cartoes[] = $operacao['nome'];
			if($operacao['ativo'] && $operacao['codigo'] == 'visa' && $operacao['tipo'] == 'debito') $codigo_cartoes[] = 'visa_electron';
			elseif($operacao['ativo'] && $operacao['codigo'] == 'mastercard' && $operacao['tipo'] == 'debito') $codigo_cartoes[] = 'redeshop';
			elseif($operacao['ativo']) $codigo_cartoes[] = $operacao['codigo'];
		}
		
		$msg_texto = $this->language->get('text_title') . ' (' . implode(', ', $cartoes) . ')';

		$imgs = '';

		foreach ($codigo_cartoes as $codigo_cartao) {
			$imgs .= '<img style="vertical-align:middle;margin:0px 5px 0px 5px;" src="image/cielo/' . $codigo_cartao . '.png" />';
		}

		$msg_img = $this->language->get('text_title') . ' (' . $imgs . ')';

		$msg = $cielo_config['exibicao_checkout'] == 'img' ? $msg_img : $msg_texto;

		$method_data = array(
			'code'			=> 'cielo',
			'title'			=> $msg,
			'sort_order'	=> $this->config->get('cielo_sort_order')
			);
		
    	return $method_data;
    }
	
	public function add($Cielo) {
		
		$operacao = $Cielo->get('operacao');
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "order_cielo SET " .
						 "order_id = '" . (int)$this->db->escape($Cielo->get('dadosPedidoNumero')) . "', " .
						 "transacao = '" . $Cielo->get('transacao') . "', " . 
						 "tid = '" . $this->db->escape($Cielo->get('tid')) . "', " . 
						 "buy_page = '" . $Cielo->get('buyPage') . "', " . 
						 "operacao = '" . $Cielo->get('nomeOperacao') . "', " .
						 "status = '" . $this->db->escape($Cielo->get('status')) . "', " . 
						 "valor = '" . (int)$Cielo->get('dadosPedidoValor') . "', " . 
						 "parcelas = '" . (int)$Cielo->get('formaPagamentoParcelas') . "', " .
						 "teste = '" . ($Cielo->get('teste') ? 'y' : 'n') . "', " .
						 "xml_enviado = '" . $this->db->escape((string)$Cielo->get('xmlEnviado')) . "', " .
						 "xml_recebido = '" . $this->db->escape((string)$Cielo->get('xmlRecebido')) . "', " . 
						 "date_added = NOW()");
	
	}
	
	public function confirm($order_id, $Cielo) {
		
		$order_id = (int)$order_id;
		
		$this->load->language('payment/cielo');
		
		$this->load->model('checkout/order');
		
		$total = ((float)$Cielo->get('dadosPedidoValor'))/100;
		$desc = (float)$Cielo->get('desconto');
		$juros = (float)$Cielo->get('juros');
		$this->session->data['GA']['cielo']['var'][] = array('name' => 'buy', 'value' => $total);
		
		if ($this->config->get('config_currency') != 'BRL') {
			$total = $this->currency->convert($total, 'BRL', $this->config->get('config_currency'));
			$desc = $this->currency->convert($desc, 'BRL', $this->config->get('config_currency'));
			$juros = $this->currency->convert($juros, 'BRL', $this->config->get('config_currency'));
		}
		
		$fdesc = $this->currency->format($desc);
		$fjuros = $this->currency->format($juros);
			
		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET total = '" . $total . "', payment_method = '" . $this->db->escape($Cielo->get('nomeOperacao')) . "' WHERE order_id = '" . $order_id . "'");
		
		if ($Cielo->get('desconto')) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . $order_id . "', code = 'cielo_desc', title = '" . $this->db->escape($this->language->get('text_total_cielo_desc')) . "', text = '" . $this->db->escape($fdesc) . "', `value` = '" . $desc . "', sort_order = '2'");
		}
		
		if ($Cielo->get('juros')) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . $order_id . "', code = 'cielo_juros', title = '" . $this->db->escape($this->language->get('text_total_cielo_juros')) . "', text = '" . $this->db->escape($fjuros) . "', `value` = '" . $juros . "', sort_order = '2'");
		}
		
		
	}
	
}

 ?>