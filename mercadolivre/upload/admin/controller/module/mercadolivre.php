<?php
class ControllerModuleMercadolivre extends Controller {
    public function index(){
	
        $this->load->language('module/mercadolivre');
		$this->load->model('setting/setting');
		$this->load->model('mercadolivre/mercadolivre');
        
        if(isset($this->session->data['error']))
        {
            $this->data['error'] = $this->session->data['error'];
            unset($this->session->data['error']);
        }else{
            $this->data['error'] = '';
        }
        
        if(isset($this->session->data['success']))
        {
            $this->data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        }else{
            $this->data['success'] = '';
        }
		
		if(!$this->mercadolivre->getAccess())
		{
		  $this->data['error'] = $this->language->get('need_auth');
		}
        
        $this->data['heading_title']        = $this->language->get('heading_title');
        $this->data['text_module']     = $this->language->get('text_module');
		$this->data['button_cancel']        = $this->language->get('button_cancel');
		$this->data['text_setting']        = $this->language->get('text_setting');
		$this->data['text_help']        = $this->language->get('text_help');
		$this->data['text_upgrade']        = $this->language->get('text_upgrade');
        
		$accesToken=$this->config->get('mercadolivre_access_token');
		if(!empty($accesToken))
		{
		   $this->data['text_auth']     = $this->language->get('text_auth_done');
		}
		else
		{
		  $this->data['text_auth']     = $this->language->get('text_auth_pending');
		}
        
        $this->document->setTitle($this->language->get('heading_title'));
        
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
            'href'      => $this->url->link('module/mercadolivre', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        
        $this->data['setting']       = $this->url->link('module/mercadolivre/setting', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['help']       = $this->url->link('module/mercadolivre/help', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['auth']       = HTTP_CATALOG.'mercadolivre_auth';
       // $this->data['import']       = $this->url->link('module/mercadolivre/import', 'token=' . $this->session->data['token'], 'SSL');
       // $this->data['token']        = $this->session->data['token'];
       
       /*For upgrade notice*/
       
       $this->data['upgrade']='';
       if($this->model_mercadolivre_mercadolivre->isDBBUPdateAvail()){
         $this->data['upgrade']=$this->url->link('module/mercadolivre/upgrade', 'token=' . $this->session->data['token'], 'SSL');
       }
	   
	   
        
        $this->template = 'module/mercadolivre/mercadolivre.tpl';
        $this->children = array(
                'common/header',
                'common/footer'
        );
        $this->response->setOutput($this->render());
    }
	
	
	public function help(){
	
        $this->load->language('module/mercadolivre');
		
        $this->data['heading_title']        = $this->language->get('heading_title');
        $this->data['text_instruction']     = $this->language->get('text_instruction');
		
        
        $this->document->setTitle($this->language->get('heading_title'));
        
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
            'href'      => $this->url->link('module/mercadolivre', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        
       $this->data['button_cancel']        = $this->language->get('button_cancel');
		$this->data['cancel'] = $this->url->link('module/mercadolivre', 'token=' . $this->session->data['token'], 'SSL');
    
        
        $this->template = 'module/mercadolivre/help.tpl';
        $this->children = array(
                'common/header',
                'common/footer'
        );
        $this->response->setOutput($this->render());
    }
	
	
	public function bulk_setting(){
	
         $this->load->language('module/mercadolivre');
		  $this->load->language('module/mercadolivre-extra');
		  $this->load->model('mercadolivre/mercadolivre');
		  $this->load->model('catalog/product');
		  
		   if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->request->post['product_ml'] && $this->request->post['mercaId']) {
			   $product_ml=is_array($this->request->post['product_ml'])?$this->request->post['product_ml']:array();
			   $data=$this->request->post;
			   foreach($product_ml as $product_id) {
				   
				   if (!$this->mercadolivre->getMercadolivreIDs($product_id)) { /* Only update if already not synchronized*/
				      if (!isset($data['ml_attr']))$data['ml_attr']=array();
					  $this->mercadolivre->addMLProductAttribute($data['ml_attr'],$product_id);    
				      $this->mercadolivre->updateProductMLData($data,$product_id);
				   }
			   }
			 $this->session->data['success'] = $this->language->get('save_success');
			 $this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL'));
		   }
		 
		  $this->data['entry_mercadolivre_category'] = $this->language->get('entry_mercadolivre_category');
		  $this->data['entry_mercadolivre_currency'] = $this->language->get('entry_mercadolivre_currency');
		  $this->data['entry_mercadolivre_buying_mode'] = $this->language->get('entry_mercadolivre_buying_mode');
		  $this->data['entry_mercadolivre_listing_type'] = $this->language->get('entry_mercadolivre_listing_type');
		  $this->data['entry_mercadolivre_condition'] = $this->language->get('entry_mercadolivre_condition');
		  $this->data['tab_mercadolivre'] = $this->language->get('tab_mercadolivre');
		  $this->data['ml_text_category_hint'] = $this->language->get('ml_text_category_hint');
		  $this->data['ml_text_select'] = $this->language->get('ml_text_select');
		  $this->data['entry_mercadolivre_warranty'] = $this->language->get('entry_mercadolivre_warranty');
		  $this->data['entry_mercadolivre_subtitle'] = $this->language->get('entry_mercadolivre_subtitle');
		  $this->data['entry_mercadolivre_video'] = $this->language->get('entry_mercadolivre_video');
		  $this->data['lang_ml_select_product'] = $this->language->get('lang_ml_select_product');
		  $this->data['text_image_manager'] = $this->language->get('text_image_manager');
		  $this->data['button_save'] = $this->language->get('button_save');
		  $this->data['button_cancel'] = $this->language->get('button_cancel');
		  
		  $this->data['token'] =$this->session->data['token'];
		  $this->data['action'] =$this->url->link('module/mercadolivre/bulk_setting', 'token=' . $this->session->data['token'], 'SSL');
		  
		  $this->data['products']=array();
		  if(isset($this->request->get['pids']) && $this->request->get['pids']){
			$product_ids=explode(',',$this->request->get['pids']); 
			foreach($product_ids as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);
	
				if ($product_info) {
					$this->data['products'][] = array(
						'product_id' => $product_info['product_id'],
						'name'       => $product_info['name']
					);
				 }
			}
		  }
		  
		  
		  $product_info = (isset($product_ids) && count($product_ids)==1)?$this->model_catalog_product->getProduct($product_ids[0]):array();
		   
		  $this->data['mercaId'] = isset($product_info['mercaId'])?$product_info['mercaId']:'';
		  $this->data['mercaTree'] = isset($product_info['mercaTree'])?$product_info['mercaTree']:'';
		  $this->data['mercaCurrency'] = isset($product_info['mercaCurrency'])?$product_info['mercaCurrency']:'';
		  $this->data['mercaBuyMode'] = isset($product_info['mercaBuyMode'])?$product_info['mercaBuyMode']:'';
		  $this->data['mercaListType'] = isset($product_info['mercaListType'])?$product_info['mercaListType']:'';
		  $this->data['mercaCondition'] = isset($product_info['mercaCondition'])?$product_info['mercaCondition']:'';
		  $this->data['mercaWarranty'] = isset($product_info['mercaWarranty'])?$product_info['mercaWarranty']:'';
		  $this->data['mercaVideoId'] = isset($product_info['mercaVideoId'])?$product_info['mercaVideoId']:'';
			
		  if(!$this->data['mercaWarranty'])$this->data['mercaWarranty']=$this->config->get('mercadolivre_mercaWarranty');
		  
		  $this->data['mercadolivre_cats']=$this->model_mercadolivre_mercadolivre->getMercadoCategoryOption($this->data['mercaId']);
		  $this->data['mercadolivre_currency']=$this->model_mercadolivre_mercadolivre->getMercadoCurrency();
		  $this->data['mercadolivre_modes']=$this->model_mercadolivre_mercadolivre->getMercadoMode();
		  $this->data['mercadolivre_types']=$this->model_mercadolivre_mercadolivre->getMercadoType();
		  $this->data['mercadolivre_conditions']=$this->model_mercadolivre_mercadolivre->getMercadoCondition();
		  
		  $this->data['product_id']=(isset($product_ids) && count($product_ids)==1)?$product_ids[0]:0; 
			
		  $this->template = 'module/mercadolivre/bulk_setting.tpl';
         $this->children = array();
         $this->response->setOutput($this->render());
		 
	}
	
	public function setting(){
	
        $this->load->language('module/mercadolivre');
		$this->load->model('mercadolivre/mercadolivre');
		$this->load->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		
		    $this->request->post['mercadolivre_access_token']=$this->config->get('mercadolivre_access_token');  /*I dont want to loss if already  has code in db */
		    $this->request->post['mercadolivre_refresh_token']=$this->config->get('mercadolivre_refresh_token');
		    $this->request->post['mercadolivre_token_expire']=$this->config->get('mercadolivre_token_expire');
			
			$merca_statuses=$this->request->post['merca_status'];
			$oc_statuses=$this->request->post['oc_status'];
		
			
			unset($this->request->post['merca_status']);
			unset($this->request->post['oc_status']);
			unset($this->request->post['mercadolivre_cat_selection']);

			$this->model_setting_setting->editSetting('mercadolivre', $this->request->post);	
			
			/*Update order status*/
			if($merca_statuses)
			{
			  $this->db->query("DELETE FROM `".DB_PREFIX."mercadolivre_status` WHERE 1");
			  foreach($merca_statuses as $i=>$merca_status)
			  {
			    $oc_status= $oc_statuses[$i];
				$this->db->query("INSERT INTO " . DB_PREFIX . "mercadolivre_status SET oc_status = '" . (int) $oc_status. "', `merca_status` = '" . $this->db->escape($merca_status) . "'");       
			  } 
			}
			
						
			$this->session->data['success'] = $this->language->get('update_success');
			$this->redirect($this->url->link('module/mercadolivre', 'token=' . $this->session->data['token'], 'SSL'));

		}
        
        $this->data['heading_title']        = $this->language->get('heading_title');
        $this->data['text_module']     = $this->language->get('text_module');
		 $this->data['text_setting']        = $this->language->get('text_setting');
		 $this->data['text_status'] = $this->language->get('text_status');
		 $this->data['text_enabled'] = $this->language->get('text_enabled');
		 $this->data['text_disabled'] = $this->language->get('text_disabled');
		 $this->data['text_app_id'] = $this->language->get('text_app_id');
		 $this->data['text_app_secret'] = $this->language->get('text_app_secret');
		 $this->data['text_select_category'] = $this->language->get('text_select_category');
		
		$this->data['entry_mercadolivre_category'] = $this->language->get('entry_mercadolivre_category');
		$this->data['entry_mercadolivre_currency'] = $this->language->get('entry_mercadolivre_currency');
		$this->data['entry_mercadolivre_buying_mode'] = $this->language->get('entry_mercadolivre_buying_mode');
		$this->data['entry_mercadolivre_listing_type'] = $this->language->get('entry_mercadolivre_listing_type');
		$this->data['entry_mercadolivre_condition'] = $this->language->get('entry_mercadolivre_condition');
		$this->data['tab_setting'] = $this->language->get('tab_setting');
		$this->data['tab_listing'] = $this->language->get('tab_listing');
		$this->data['text_oc_status'] = $this->language->get('text_oc_status');
		$this->data['text_ml_status'] = $this->language->get('text_ml_status');
		$this->data['listing_default'] = $this->language->get('listing_default');
		$this->data['tab_order'] = $this->language->get('tab_order');
		$this->data['ml_text_category_hint'] = $this->language->get('ml_text_category_hint');
		$this->data['debug_status'] = $this->language->get('debug_status');
		$this->data['entry_mercadolivre_template'] = $this->language->get('entry_mercadolivre_template');
		$this->data['tab_template'] = $this->language->get('tab_template');
		$this->data['entry_mercadolivre_price_adjustment'] = $this->language->get('entry_mercadolivre_price_adjustment');
		$this->data['entry_mercadolivre_warranty'] = $this->language->get('entry_mercadolivre_warranty');
		
		$this->data['lang_auto_feedback'] = $this->language->get('lang_auto_feedback');
		$this->data['lang_auto_feedback_status'] = $this->language->get('lang_auto_feedback_status');
		$this->data['lang_feedback_rating'] = $this->language->get('lang_feedback_rating');
		$this->data['lang_feedback_message'] = $this->language->get('lang_feedback_message');
		
		$this->data['tab_shipping'] = $this->language->get('tab_shipping');
		$this->data['lang_shipping_name'] = $this->language->get('lang_shipping_name');
		$this->data['lang_shipping_cost'] = $this->language->get('lang_shipping_cost');
		$this->data['order_status_hints'] = $this->language->get('order_status_hints');
		$this->data['lang_new_user'] = $this->language->get('lang_new_user');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
		$this->data['text_add_images_in_desc'] = $this->language->get('text_add_images_in_desc');
		$this->data['text_order_status_rule'] = $this->language->get('text_order_status_rule');
		$this->data['text_always_sync'] = $this->language->get('text_always_sync');
		$this->data['ml_order_status']=array('confirmed'=>$this->language->get('lang_order_status1'),
                       'payment_required'=>$this->language->get('lang_order_status2'),
                       'payment_in_process'=>$this->language->get('lang_order_status3'),
                       'paid'=>$this->language->get('lang_order_status4'),
                       'cancelled'=>$this->language->get('lang_order_status5'));
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel']        = $this->language->get('button_cancel');
        
        
        $this->document->setTitle($this->language->get('heading_title'));
        
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
            'href'      => $this->url->link('module/mercadolivre', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
		
		$this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_setting'),
            'href'      => $this->url->link('module/mercadolivre/setting', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
		
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}



 		if (isset($this->error['error_app_id'])) {
			$this->data['error_app_id'] = $this->error['error_app_id'];
		} else {
			$this->data['error_app_id'] = '';
		}



 		if (isset($this->error['error_app_secret'])) {
			$this->data['error_app_secret'] = $this->error['error_app_secret'];
		} else {
			$this->data['error_app_secret'] = '';
		}
		
		
		if (isset($this->request->post['mercadolivre_app_id'])) {
			$this->data['mercadolivre_app_id'] = $this->request->post['mercadolivre_app_id'];
		} else {
			$this->data['mercadolivre_app_id'] = $this->config->get('mercadolivre_app_id');
		}



		if (isset($this->request->post['mercadolivre_app_secret'])) {
			$this->data['mercadolivre_app_secret'] = $this->request->post['mercadolivre_app_secret'];
		} else {
			$this->data['mercadolivre_app_secret'] = $this->config->get('mercadolivre_app_secret');
		}
		
		if (isset($this->request->post['mercadolivre_status'])) {
			$this->data['mercadolivre_status'] = $this->request->post['mercadolivre_status'];
		} else {
			$this->data['mercadolivre_status'] = $this->config->get('mercadolivre_status');
		}
		
		if (isset($this->request->post['mercadolivre_debug'])) {
			$this->data['mercadolivre_debug'] = $this->request->post['mercadolivre_debug'];
		} else {
			$this->data['mercadolivre_debug'] = $this->config->get('mercadolivre_debug');
		}
		
		if (isset($this->request->post['mercadolivre_new_customer'])) {
			$this->data['mercadolivre_new_customer'] = $this->request->post['mercadolivre_new_customer'];
		} else {
			$this->data['mercadolivre_new_customer'] = $this->config->get('mercadolivre_new_customer');
		}
		

		
		if (isset($this->request->post['mercadolivre_shipping'])) {
			$this->data['mercadolivre_shipping'] = $this->request->post['mercadolivre_shipping'];
		} else {
			$this->data['mercadolivre_shipping'] = $this->config->get('mercadolivre_shipping');
		}  
		
		if (isset($this->request->post['mercadolivre_payment'])) {
			$this->data['mercadolivre_payment'] = $this->request->post['mercadolivre_payment'];
		} else {
			$this->data['mercadolivre_payment'] = $this->config->get('mercadolivre_payment');
		}
		
		if (isset($this->request->post['mercadolivre_image_in_desc'])) {
			$this->data['mercadolivre_image_in_desc'] = $this->request->post['mercadolivre_image_in_desc'];
		} else {
			$this->data['mercadolivre_image_in_desc'] = $this->config->get('mercadolivre_image_in_desc');
		}
		   
				
		if (isset($this->request->post['mercadolivre_mercaId'])) {
			$this->data['mercadolivre_mercaId'] = $this->request->post['mercadolivre_mercaId'];
		} else {
			$this->data['mercadolivre_mercaId'] = $this->config->get('mercadolivre_mercaId');
		} 
		if (isset($this->request->post['mercadolivre_mercaCurrency'])) {
			$this->data['mercadolivre_mercaCurrency'] = $this->request->post['mercadolivre_mercaCurrency'];
		} else {
			$this->data['mercadolivre_mercaCurrency'] = $this->config->get('mercadolivre_mercaCurrency');
		}
		
		if (isset($this->request->post['mercadolivre_mercaBuyMode'])) {
			$this->data['mercadolivre_mercaBuyMode'] = $this->request->post['mercadolivre_mercaBuyMode'];
		} else  {
			$this->data['mercadolivre_mercaBuyMode'] =$this->config->get('mercadolivre_mercaBuyMode');
		} 
		
		if (isset($this->request->post['mercadolivre_mercaListType'])) {
			$this->data['mercadolivre_mercaListType'] = $this->request->post['mercadolivre_mercaListType'];
		} else {
			$this->data['mercadolivre_mercaListType'] = $this->config->get('mercadolivre_mercaListType');
		} 
		
		if (isset($this->request->post['mercadolivre_mercaCondition'])) {
			$this->data['mercadolivre_mercaCondition'] = $this->request->post['mercadolivre_mercaCondition'];
		} else {
			$this->data['mercadolivre_mercaCondition'] = $this->config->get('mercadolivre_mercaCondition');
		}
		
		if (isset($this->request->post['mercadolivre_category_tree'])) {
			$this->data['mercadolivre_category_tree'] = $this->request->post['mercadolivre_category_tree'];
		} else {
			$this->data['mercadolivre_category_tree'] = $this->config->get('mercadolivre_category_tree');
		}
		
		if (isset($this->request->post['mercadolivre_template'])) {
			$this->data['mercadolivre_template'] = $this->request->post['mercadolivre_template'];
		} else {
			$this->data['mercadolivre_template'] = $this->config->get('mercadolivre_template');
		}
		
		if (isset($this->request->post['mercadolivre_mercaPrice'])) {
			$this->data['mercadolivre_mercaPrice'] = $this->request->post['mercadolivre_mercaPrice'];
		} else {
			$this->data['mercadolivre_mercaPrice'] = $this->config->get('mercadolivre_mercaPrice');
		}
		
		if (isset($this->request->post['mercadolivre_mercaWarranty'])) {
			$this->data['mercadolivre_mercaWarranty'] = $this->request->post['mercadolivre_mercaWarranty'];
		} else {
			$this->data['mercadolivre_mercaWarranty'] = $this->config->get('mercadolivre_mercaWarranty');
		}
		
		if (isset($this->request->post['mercadolivre_feedback'])) {
			$this->data['mercadolivre_feedback'] = $this->request->post['mercadolivre_feedback'];
		} else {
			$this->data['mercadolivre_feedback'] = $this->config->get('mercadolivre_feedback');
		}
		
		
		if (isset($this->request->post['mercadolivre_feedback_order'])) {
			$this->data['mercadolivre_feedback_order'] = $this->request->post['mercadolivre_feedback_order'];
		} else {
			$this->data['mercadolivre_feedback_order'] = $this->config->get('mercadolivre_feedback_order');
		}
		if (isset($this->request->post['mercadolivre_feedback_rating'])) {
			$this->data['mercadolivre_feedback_rating'] = $this->request->post['mercadolivre_feedback_rating'];
		} else {
			$this->data['mercadolivre_feedback_rating'] = $this->config->get('mercadolivre_feedback_rating');
		}
		if (isset($this->request->post['mercadolivre_feedback_message'])) {
			$this->data['mercadolivre_feedback_message'] = $this->request->post['mercadolivre_feedback_message'];
		} else {
			$this->data['mercadolivre_feedback_message'] = $this->config->get('mercadolivre_feedback_message');
		}
		
		//for custom shipping
		for($i=1;$i<=5;$i++)
		 {
				if (isset($this->request->post['mercadolivre_shipping_name'.$i])) {
					$this->data['mercadolivre_shipping_name'.$i] = $this->request->post['mercadolivre_shipping_name'.$i];
				} else {
					$this->data['mercadolivre_shipping_name'.$i] = $this->config->get('mercadolivre_shipping_name'.$i);
				}
				
				if (isset($this->request->post['mercadolivre_shipping_cost'.$i])) {
					$this->data['mercadolivre_shipping_cost'.$i] = $this->request->post['mercadolivre_shipping_cost'.$i];
				} else {
					$this->data['mercadolivre_shipping_cost'.$i] = $this->config->get('mercadolivre_shipping_cost'.$i);
				}
		}	
		
		$shipping_mods=array();
		$xshipping_installed=false;
		$result=$this->db->query("select * from " . DB_PREFIX . "extension where type='shipping'");
		if($result->rows){
		  foreach($result->rows as $row){
		     $shipping_mods[$row['code']]=$this->getModuleName($row['code'],$row['type']); 
		  }
		}
		
		$this->data['shipping_mods'] = $shipping_mods;	
		
		$payment_mods=array();
		$result=$this->db->query("select * from " . DB_PREFIX . "extension where type='payment'");
		if($result->rows){
		  foreach($result->rows as $row){
		     if($this->config->get($row['code'].'_status')){
		       $payment_mods[$row['code']]=$this->getModuleName($row['code'],$row['type']);  
		     }
		  }
		}
		
		$this->data['payment_mods'] = $payment_mods;	
		
		
		$this->data['token'] =$this->session->data['token'];
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();	
		$this->data['merca_statuses'] = $this->model_mercadolivre_mercadolivre->getMercadoStatus();
		
		$this->data['mercadolivre_cats']=$this->model_mercadolivre_mercadolivre->getMercadoCategoryOption($this->data['mercadolivre_mercaId']);
		$this->data['mercadolivre_currency']=$this->model_mercadolivre_mercadolivre->getMercadoCurrency();
		$this->data['mercadolivre_modes']=$this->model_mercadolivre_mercadolivre->getMercadoMode();
		$this->data['mercadolivre_types']=$this->model_mercadolivre_mercadolivre->getMercadoType();
		$this->data['mercadolivre_conditions']=$this->model_mercadolivre_mercadolivre->getMercadoCondition();


		$this->data['action'] = $this->url->link('module/mercadolivre/setting', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');


		$this->template = 'module/mercadolivre/settting.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);
		$this->response->setOutput($this->render());
    }
	
	public function category(){
	
		if ($this->request->get['catId']) {
		
		  $categories= $this->mercadolivre->getCategory($this->request->get['catId']); 
		  echo json_encode($categories);  
		}		
    }
    
    public function attribute(){
       
       if ($this->request->get['catId']) {
		
		  $attributes= $this->mercadolivre->getAttributes($this->request->get['catId']); 
		  $result=array('html'=>'','row'=>'');
		  if($attributes)$result=$this->mercadolivre->renderAttributes($attributes); 
		  $this->response->setOutput(json_encode(array('html'=>$result['html'],'row'=>$result['row'])));
		}	
    }
	
	public function desynchronize(){
	
		$this->load->model('mercadolivre/mercadolivre');
	    $this->load->language('module/mercadolivre');
		
		if (!empty($this->request->get['product_id'])) {
		
		  $this->model_mercadolivre_mercadolivre->desynchronizeProduct($this->request->get['product_id']);   
		}
		$this->session->data['success'] = $this->language->get('unsyn_done');
		$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL'));
        
    }
	
	public function synchronize(){
	
		$this->load->model('mercadolivre/mercadolivre');
	    $this->load->language('module/mercadolivre');
		
		if (!empty($this->request->get['product_id'])) {
		
		  $this->model_mercadolivre_mercadolivre->synchronizeProduct($this->request->get['product_id']);   
		}
		$this->session->data['success'] = $this->language->get('syn_done');
		$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL'));
        
    }
	
	public function bulkSynchronize(){
	
		$this->load->model('mercadolivre/mercadolivre');
	    $this->load->language('module/mercadolivre');
		
		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_mercadolivre_mercadolivre->synchronizeProduct($product_id);   
	  		}
	   }		
		
		$this->session->data['success'] = $this->language->get('syn_done');
		$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL')); 
    }
    
    public function bulkDesynchronize(){
	
		$this->load->model('mercadolivre/mercadolivre');
	    $this->load->language('module/mercadolivre');
		
		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_mercadolivre_mercadolivre->desynchronizeProduct($product_id);   
	  		}
	   }		
		
		$this->session->data['success'] = $this->language->get('unsyn_done');
		$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL')); 
    }
    
     public function updateSynStatus(){
		  $order_id=$this->request->get['order_id']; 
		  $stopSyncId=$this->request->get['stopSyncId']; 
		  if($order_id){
			 
			 $this->db->query("UPDATE " . DB_PREFIX . "mercadolivre_order SET stopSync = '" . (int)$stopSyncId . "' WHERE order_id = '" .(int)$order_id . "'");  
		 }
		 echo 'Done';
	 }
	
    
    public function install(){
        $this->load->model('mercadolivre/mercadolivre');
        
        $this->model_mercadolivre_mercadolivre->install();
    }
    
    public function uninstall(){        
        $this->load->model('mercadolivre/mercadolivre');
        
        $this->model_mercadolivre_mercadolivre->uninstall();
    }
    
    public function upgrade(){
       $this->load->language('module/mercadolivre');
	   $this->load->model('mercadolivre/mercadolivre');
       $this->model_mercadolivre_mercadolivre->upgrade();
       $this->session->data['success'] = $this->language->get('upgrade_done');
       $this->redirect($this->url->link('module/mercadolivre', 'token=' . $this->session->data['token'], 'SSL'));
	}
	
   protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/mercadolivre')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}


		if (!$this->request->post['mercadolivre_app_id']) {
			$this->error['error_app_id'] = $this->language->get('error_app_id');
		}

		if (!$this->request->post['mercadolivre_app_secret']) {
			$this->error['error_app_secret'] = $this->language->get('error_app_secret');
		}

		if (!$this->error) {
		return true;

		} else {
			return false;
		}	
	}
	
  private function getModuleName($code,$type)
	{
	   if(!$code) return '';
	   
	   $this->language->load($type.'/'.$code);
	   return $this->language->get('heading_title');
	}  
   
}