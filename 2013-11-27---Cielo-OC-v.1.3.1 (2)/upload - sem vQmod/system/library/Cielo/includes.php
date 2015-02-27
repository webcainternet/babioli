<?php
/**
 * Mуdulo Cielo para OpenCart 1.5.3.1 a 1.5.6
 * Integraзгo direta com a Cielo,
 * sem utilizaзгo de Gateways de pagamento
 * 
 * Este й um arquivo de requires.
 * Em versхes futuras do mуdulo este arquivo
 * poderб sofrer adiзгo de funcionalidades.
 * 
 * @author  Victor Schrцder <domains@egeeks.com.br>
 * @copyright  Copyright (c) 2012, Victor Schrцder. All rights reserved. Must buy a Commercial Licence (per store).
 * @link  http://www.opencart.com/index.php?route=extension/extension/info&extension_id=8855
 */
require_once('cielo.php');
require_once('logger.php');
if (version_compare(phpversion(), '5.3.0', '>=') == true) require_once('ga.php');
?>