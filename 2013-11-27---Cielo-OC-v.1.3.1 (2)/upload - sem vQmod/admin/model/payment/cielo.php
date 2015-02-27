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
	
	public function getTransacoes($order_id) {
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_cielo WHERE order_id = '" . (int)$order_id . "'");
		return $query->rows;
		
	}
	
	public function add($Cielo) {
		
		$operacao = $Cielo->get('operacao');
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "order_cielo SET " .
						 "order_id = '" . (int)$this->db->escape($Cielo->get('dadosPedidoNumero')) . "', " .
						 "transacao = '" . $Cielo->get('transacao') . "', " . 
						 "tid = '" . $this->db->escape($Cielo->get('tid')) . "', " . 
						 "buy_page = 'admin', " . 
						 "status = '" . $this->db->escape($Cielo->get('status')) . "', " . 
						 "valor = '" . (int)$Cielo->get('dadosPedidoValor') . "', " . 
						 "teste = '" . ($Cielo->get('teste') ? 'y' : 'n') . "', " .
						 "xml_enviado = '" . $this->db->escape((string)$Cielo->get('xmlEnviado')) . "', " .
						 "xml_recebido = '" . $this->db->escape((string)$Cielo->get('xmlRecebido')) . "', " . 
						 "date_added = NOW()");
		
	}


	public function normalizeConfig($version) {

		$config = $this->config->get('cielo_config');

		if(!$config) return false;

		if(!isset($config['version']) || version_compare($config['version'], $version, '<')) {

			$config['version'] = $version;
			$config['exibicao_checkout'] = 'img';			
			$config['operacoes']['jcb'] = array(
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
												'autorizacao' => 3
											   );

			$config['operacoes']['aura'] = array(
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
												'autorizacao' => 3
											   );

			if(isset($config['sort_order'])) {
				$cielo_sort_order = $config['sort_order'];
				unset($config['sort_order']);
			}

			$settings_array = array(
									'cielo_config' => $config,
									'cielo_sort_order' => $cielo_sort_order,
									'cielo_status' => $this->config->get('cielo_status')
								   );

			$this->model_setting_setting->editSetting('cielo', $settings_array);
			$this->session->data['GA']['cielo']['ev'][] = 'normalization';
			return true;
		} else {
			return false;
		}

	}

	public function checkUpdate($version) {
		// TODO sistema de checagem de updates
		return false;
	}


	
	public function installCieloTables() {

		$db_check = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "order_cielo'");
	
		if ($db_check->num_rows != 0) return false;
		
		$tables = 	"CREATE TABLE `" . DB_PREFIX . "order_cielo` (" .
					"`id` int(15) NOT NULL AUTO_INCREMENT," . 
					"`order_id` varchar(15) COLLATE utf8_bin NOT NULL DEFAULT ''," . 
					"`transacao` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT ''," . 
					"`tid` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT ''," . 
					"`buy_page` varchar(6) COLLATE utf8_bin NOT NULL DEFAULT ''," . 
					"`operacao` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT ''," . 
					"`status` varchar(2) COLLATE utf8_bin NOT NULL DEFAULT ''," . 
					"`valor` int(12) NOT NULL DEFAULT '0'," .
					"`parcelas` int(2) NOT NULL DEFAULT '0'," .
					"`teste` varchar(2) COLLATE utf8_bin NOT NULL DEFAULT ''," .
					"`xml_enviado` text COLLATE utf8_bin NOT NULL DEFAULT ''," . 
					"`xml_recebido` text COLLATE utf8_bin NOT NULL DEFAULT ''," . 
					"`date_added` datetime NOT NULL," .
					"PRIMARY KEY (`id`)" .
					") ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
					
		$this->db->query($tables);
		return true;
	}
	
	public function installGATables() {
		
		$db_check = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "ga_data'");
		
		if ($db_check->num_rows != 0) return false;
		
		$tables = 	"CREATE TABLE `" . DB_PREFIX . "ga_data` (" .
					"`ga_id` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT ''," .
					"`obj` text COLLATE utf8_bin," .
					"`user` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '0'," .
					"PRIMARY KEY (`ga_id`)" .
					") ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
		
		$this->db->query($tables);
		return true;
	}
	
	public function uninstallCieloTables() {
		
		$this->db->query("DROP TABLE " . DB_PREFIX . "order_cielo");

	}

	public function uninstallGATables() {
		
		$this->db->query("DROP TABLE " . DB_PREFIX . "ga_data");
		
	}
	
}
?>