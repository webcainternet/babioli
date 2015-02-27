<?php
/**
 * Módulo Cielo para OpenCart 1.5.3.1 a 1.5.6
 * Integração direta com a Cielo,
 * sem utilização de Gateways de pagamento
 * 
 * Esta classe foi adaptada da classe Logger fornecida
 * pela Cielo no kit de integração.
 * 
 * A classe original é de propriedade da Cielo.
 * Esta adaptação é de uso restrito ao módulo deste pacote.
 * 
 * @author  Victor Schröder <domains@egeeks.com.br>
 * @copyright  Copyright (c) 2012, Victor Schröder. All rights reserved. Must buy a Commercial Licence (per store).
 * @link  http://www.opencart.com/index.php?route=extension/extension/info&extension_id=8855
 */

class Logger {
	
	private $log_file;
	private $teste;
	
	function __construct($teste = true) {
		$this->log_file = DIR_LOGS . 'cielo_xml.log';
		$this->teste = $teste;
	}
	
	private function fileOpen() {
		$this->fp = fopen($this->log_file, 'a');
	}
	 
	public function write($xml, $transacao) {
		
		if (!$this->teste) return;
		
		$txt =  '***********************************************' . "\n" .
				date("Y-m-d H:i:s:u (T)") . "\n" .
				'ORIGEM: ' . $_SERVER['REQUEST_URI'] . "\n" .
				'OPERAÇÃO: ' . $transacao . "\n" .
				$xml . "\n\n";

		$handle = fopen($this->log_file, 'a+');
		fwrite($handle, $txt);
		fclose($handle);
	}
}
?>