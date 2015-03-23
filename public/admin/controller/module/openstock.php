<?php  
/**
 * OpenStock controller class
 * Created by James Allsup / Welford Media
 * http://www.welfordmedia.co.uk / http://help.welfordmedia.co.uk
 */
class ControllerModuleOpenstock extends Controller {
    private $error = array();
    
    public function index(){
        $this->load->model('openstock/openstock');
        $this->load->model('setting/setting');

        $this->data = array_merge($this->data, $this->load->language('module/openstock'));

        $this->document->setTitle($this->data['heading_title']);
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('openstock', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
        
        if (isset($this->session->data['error'])) {
            $this->data['error'] = $this->session->data['error'];
            unset($this->session->data['error']);
        } else {
            $this->data['error'] = '';
        }

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }
        
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
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('module/openstock', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['token']          = $this->session->data['token'];
        $this->data['cancel']         = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['export']         = $this->url->link('module/openstock/export', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['import']         = $this->url->link('module/openstock/import', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['optionLink']     = $this->url->link('catalog/option', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['token']          = $this->session->data['token'];
        $this->data['optionTest']     = $this->model_openstock_openstock->checkOptionOrders();
        $this->data['knowledge_base'] = 'http://help.welfordmedia.co.uk/kb/openstock';
        
        $this->data['action'] = $this->url->link('module/openstock', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['openstock_show_default_price'] = $this->config->get('openstock_show_default_price');
        $this->data['openstock_show_special_tab']   = $this->config->get('openstock_show_special_tab');
        
		if (isset($this->request->post['openstock_default_stock'])) {
			$this->data['openstock_default_stock'] = $this->request->post['openstock_default_stock'];
		} elseif ($this->config->get('openstock_default_stock')) {
			$this->data['openstock_default_stock'] = $this->config->get('openstock_default_stock');
		} else {
            $this->data['openstock_default_stock'] = '0';
        }
        
		if (isset($this->request->post['openstock_default_subtract'])) {
      		$this->data['openstock_default_subtract'] = $this->request->post['openstock_default_subtract'];
    	} else {
      		$this->data['openstock_default_subtract'] = $this->config->get('openstock_default_subtract');
    	}
        
		if (isset($this->request->post['openstock_default_active'])) {
      		$this->data['openstock_default_active'] = $this->request->post['openstock_default_active'];
    	} else {
      		$this->data['openstock_default_active'] = $this->config->get('openstock_default_active');
    	}
        
        $this->data['openstock_bulk_stock'] = sprintf($this->language->get('openstock_bulk_stock'), $this->config->get('openstock_default_stock'));
        
        if ($this->config->get('openstock_default_subtract') == '0') {
            $this->data['openstock_bulk_subtract'] = sprintf($this->language->get('openstock_bulk_subtract'), $this->language->get('text_no'));
        } else {
            $this->data['openstock_bulk_subtract'] = sprintf($this->language->get('openstock_bulk_subtract'), $this->language->get('text_yes'));
        }
        
        if ($this->config->get('openstock_default_active') == '0') {
            $this->data['openstock_bulk_active'] = sprintf($this->language->get('openstock_bulk_active'), $this->language->get('text_no'));
        } else {
            $this->data['openstock_bulk_active'] = sprintf($this->language->get('openstock_bulk_active'), $this->language->get('text_yes'));
        }

        $this->template = 'module/openstock.tpl';
        $this->children = array(
                'common/header',
                'common/footer'
        );
        $this->response->setOutput($this->render());
    }
    
    public function install(){
        $this->load->model('openstock/openstock');
        $this->load->model('setting/setting');
        
        $this->model_openstock_openstock->install();
        
        $this->model_setting_setting->editSetting('openstock', array(
            'openstock_show_default_price' => '0',
            'openstock_show_special_tab'   => '0',
            'openstock_default_stock'      => '0',
            'openstock_default_subtract'   => '1',
            'openstock_default_active'     => '1'
        ));
    }
    
    public function uninstall(){        
        $this->load->model('openstock/openstock');
        
        $this->model_openstock_openstock->uninstall();
    }

    public function repair(){
        $this->load->model('openstock/openstock');

        $this->model_openstock_openstock->repair();
    }
    
    public function export(){
		header('Content-Type: text/html; charset=utf-8');
	
        $this->load->model('openstock/openstock');
        $this->load->model('openstock/csv');
        
        $this->model_openstock_csv->init();
        
        $this->model_openstock_csv->setHeading('VID #','SKU','Product name','Variant name','Stock','Weight','Price','Status');
        
        $products = $this->model_openstock_openstock->getProductsWithOptions();
        
        if($products != false){
            foreach($products as $product){
                foreach($product['options'] as $option){
                    $this->model_openstock_csv->addLine(
                        $option['id'],
                        $option['sku'],
                        html_entity_decode($product['name']),
                        html_entity_decode($option['combi']),
                        $option['stock'], 
                        $option['weight'],
                        $option['price'], 
                        $option['active']
                    );
                }
            }

            $this->model_openstock_csv->output("D","OpenStock_export.csv");
            
            $this->model_openstock_csv->clear();
			
			die();
        }
    }
    
    public function import(){
        $this->load->language('module/openstock');
        
        if($this->request->server['REQUEST_METHOD'] != 'POST'){
            $this->session->data['error'] = $this->language->get('notice_error_nofile');
        }else{
            if($fp = fopen($_FILES['uploadFile']['tmp_name'],'r')){
                $c = 0;
                while($csv_line = fgetcsv($fp,1024)){
                    if($c != 0){
                        $this->db->query("
                            UPDATE `" . DB_PREFIX . "product_option_relation` 
                            SET 
                                `sku` = '".$this->db->escape($csv_line['1'])."',
                                `stock` = '".(int)$csv_line['4']."',
                                `weight` = " . (double) $csv_line['5'] . ",
                                `price` = '".(double)$csv_line['6']."',
                                `active` = '".(int)$csv_line['7']."' 
                            WHERE `id` = '".(int)$csv_line['0']."' 
                            LIMIT 1
                        ");
                    }
                    
                    $c++;
                }
                
                $this->session->data['success'] = $this->language->get('notice_success');
            }else{
                $this->session->data['error'] = $this->language->get('notice_error_fail');
            }
        }
        
        $this->redirect($this->url->link('module/openstock', 'token=' . $this->session->data['token'], 'SSL'));
    }
    
    public function bulk() {
        $this->data = array_merge($this->data, $this->load->language('module/openstock'));
        
        $data = array();
        if ($this->validate()) {
            $start = microtime(true);
            $data['products'] = array();

            $this->load->model('openstock/openstock');

            //Get products with options which has_options = 0
            $products = $this->db->query("
                SELECT `p`.`product_id` FROM `" . DB_PREFIX . "product` p
                RIGHT JOIN `" . DB_PREFIX . "product_option` po ON (p.product_id = po.product_id)
                WHERE `p`.`has_option` = '0'
                GROUP BY `p`.`product_id`
                ");

            $created = 0;
            foreach ($products->rows as $product) {
                $optionsStockCalcs = (array)$this->model_openstock_openstock->calcOptions((int)$product['product_id']);

                if ($optionsStockCalcs) {
                    $this->db->query("UPDATE " . DB_PREFIX . "product SET has_option = '1' WHERE product_id = '" . (int)$product['product_id'] . "'");
                    rsort($optionsStockCalcs);

                    foreach($optionsStockCalcs as $i => $newOption) {
                        $this->db->query("
                            INSERT INTO " . DB_PREFIX . "product_option_relation
                            SET
                                `product_id`    = '" . (int)$product['product_id'] . "',
                                `var`           = '" . $newOption . "',
                                `sku`           = '',
                                `stock`         = '" . (int)$this->config->get('openstock_default_stock') . "',
                                `active`        = '" . (int)$this->config->get('openstock_default_active') . "',
                                `subtract`      = '" . (int)$this->config->get('openstock_default_subtract') . "',
                                `price`         = '',
                                `image`         = '',
                                `weight`        = ''
                        ");

                        $created++;
                    }
                }
            }

            $finish = microtime(true);

            $data['success'] = true;
            $data['created'] = $created;
            $data['time_taken'] = round($finish - $start, 3);
        } else {
            $data['success'] = false;
            $data['error'] = $this->language->get('error_permission');
        }
        
        $this->response->setOutput(json_encode($data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'module/openstock')) {
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