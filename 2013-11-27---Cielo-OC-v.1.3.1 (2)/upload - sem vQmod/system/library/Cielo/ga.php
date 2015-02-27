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

use UnitedPrototype\GoogleAnalytics;

class GA extends Controller {

	public function __construct() {
		
		parent::__construct($GLOBALS['registry']);
		
		if(!isset($this->session->data['GA']['db_ok'])) {
			$db_check = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "ga_data'");
			$this->session->data['GA']['db_ok'] = ($db_check->num_rows != 0) ? true : false;
		}
		
		if (!$this->session->data['GA']['db_ok']) return;
		
		$this->load->library('GA/autoload');
		
		if(isset($this->session->data['GA']['visitor'])) {
			$visitor = unserialize($this->session->data['GA']['visitor']);
		} elseif(isset($this->request->cookie['ga_id'])) {
			$obj = $this->db->query("SELECT obj FROM " . DB_PREFIX . "ga_data WHERE ga_id = '" . $this->db->escape($this->request->cookie['ga_id']) . "'");
			$visitor = $obj->num_rows ? unserialize($obj->row['obj']) : new GoogleAnalytics\Visitor();
		} else {
			$visitor = new GoogleAnalytics\Visitor();
		}
		
		// if (!headers_sent()) setcookie('ga_id', (string)$visitor->getUniqueId(), time()+60*60*24*365);
		try {
			@setcookie('ga_id', (string)$visitor->getUniqueId(), time()+60*60*24*365);
		} catch(Exception $e) {
			// Ignoring cookie errors
			// TODO logger de erros do GA
		}
		
		$object = $this;
		
		register_shutdown_function(function() use($visitor, $object) {

			$u = $object->session->data['GA']['cielo']['user'] . '/' . $object->request->get['route'];
			$t = 'Cielo - ' . $u;
			
			$page = array('url' => '/' . $u, 'title' => $t);
			
			$events = array();

			if(isset($object->session->data['GA']['cielo']['ev'])) {
				foreach($object->session->data['GA']['cielo']['ev'] as $ev) {
					$events[] = array('category' => $object->session->data['GA']['cielo']['user'],
									  'action' => $ev,
									  'label' => HTTP_SERVER);
				}
			}

			$visitor->fromServerVar($_SERVER);
			
			$config = new GoogleAnalytics\Config(array('sendOnShutdown' => true, 'fireAndForget' => true, 'ErrorSeverity' => 2));
			$tracker = new GoogleAnalytics\Tracker('UA-26208201-5', HTTP_SERVER, $config);

			$session = isset($object->session->data['GA']['session']) ? unserialize($object->session->data['GA']['session']) : new GoogleAnalytics\Session();

			$visitor->addSession($session);

			$file = new GoogleAnalytics\Page($page['url']);
			$file->setTitle($page['title']);

			if(isset($object->session->data['GA']['cielo']['var'])) {
				$i = 1;
				foreach ($object->session->data['GA']['cielo']['var'] as $custom) {
					$custom_var = new GoogleAnalytics\CustomVariable($i, $custom['name'], sprintf('%01.2f', $custom['value']), 3);
					$tracker->addCustomVariable($custom_var);
					if ($i >= 5) break;
					$i++;
				}
			}

			try {
				@$tracker->trackPageview($file, $session, $visitor);
			} catch (Exception $e) {
				// Ignoring all errors
				// TODO logger de erros do GA
			}

			if($events) {
				foreach ($events as $event) {
					$event_var = new GoogleAnalytics\Event($event['category'], $event['action'], $event['label']);
					try {
						@$tracker->trackEvent($event_var, $session, $visitor);
					} catch (Exception $e) {
						// Ignoring all errors
						// TODO logger de erros do GA
					}
				}
			}
			
			$object->session->data['GA']['visitor'] = serialize($visitor);
			$object->session->data['GA']['session'] = serialize($session);
			
			try {
				$obj = @$object->db->query("SELECT obj FROM " . DB_PREFIX . "ga_data WHERE ga_id = '" . $object->db->escape($visitor->getUniqueId()) . "'");
				
				if($obj->num_rows) {
					@$object->db->query("UPDATE " . DB_PREFIX . "ga_data SET obj = '" . $object->db->escape($object->session->data['GA']['visitor']) . "' WHERE ga_id = '" . $object->db->escape($visitor->getUniqueId()) . "'");
				} else {
					@$object->db->query("INSERT INTO " . DB_PREFIX . "ga_data SET obj = '" . $object->db->escape($object->session->data['GA']['visitor']) . "', ga_id = '" . $object->db->escape($visitor->getUniqueId()) . "'");
				}
			} catch(Exception $e) {
				// Ignoring all DB errors
				// TODO logger de erros do GA
			}
			
			unset($object->session->data['GA']['cielo']);

		});

	}
	
}

$ga = new GA();
?>
