<?php

class ControllerMercadolivreMercadolivre extends Controller {

	public function index() {
  
		  $this->language->load('module/mercadolivre');
	      $this->data['breadcrumbs'] = array();
		
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home'),
				'separator' => false
			);
		
	
      		$this->data['breadcrumbs'][] = array(
        		'text'      => $this->language->get('text_title'),
				'href'      => $this->url->link('mercadolivre/mercadolivre'),
        		'separator' => $this->language->get('text_separator')
      		);
				
	  		$this->document->setTitle($this->language->get('text_title'));
			
      		$this->data['heading_title'] = $this->language->get('text_title');
			$this->data['text_intro'] = $this->language->get('text_intro');
			$this->data['text_auth'] = $this->language->get('text_auth');
			$this->data['text_auth_done'] = $this->language->get('text_auth_done');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = $this->url->link('common/home');
			
			$this->data['error']='';
			if(isset($this->request->get['error']))
			{
			    $this->data['error']='Error: '.$this->request->get['error'].(($this->request->get['error_description'])?' - '.$this->request->get['error_description']:'');
			}
			
			if(isset($this->request->get['code']))
			{
			    $this->data['error']=$this->mercadolivre->getAccessToken($this->request->get['code']);
			}
			
			
			
			$this->data['auth_done']=''; 
			if($this->mercadolivre->getAccess())
			{
			   $this->data['auth_done']='1'; 
			   $this->data['text_auth'] = $this->language->get('text_reauth');
			}
		    
			$this->data['login_url']=$this->mercadolivre->getLoginUrl();
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mercadolivre/auth.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/mercadolivre/auth.tpl';
			} else {
				$this->template = 'default/template/mercadolivre/auth.tpl';
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
	
   public function syncat()
   {
     
     $this->mercadolivre->updateCategory();
     $this->mercadolivre->updateListingType();
     
     echo 'Done.';
   }
   
    public function testUser()
    {
      $this->mercadolivre->createTestUser();
    }
	

	public function callback() {
	 
	    $data = file_get_contents('php://input');
		$data=json_decode($data, true);
		
		if($data['topic']=='items')
		{
			$itemId=str_replace('/items/','',$data['resource']);
			$itemId=trim($itemId);
			$this->mercadolivre->updateOpencartProduct($itemId);
		}
		if($data['topic']=='orders')
		{
			$orderId=str_replace('/orders/','',$data['resource']);
			$orderId=trim($orderId);
			$this->mercadolivre->addAPICall($orderId,'order');
			
		}
		
		if($this->config->get('mercadolivre_debug')){
		  $this->log->write('MERCADOLIVRE callback - Type ='.$data['topic'].' Response='.print_r($data,true));
		}
		ob_start();
		header($_SERVER["SERVER_PROTOCOL"]." 200 OK");
		ob_end_flush();
		if(headers_sent()){
			echo "Header Sent to ML";
		}
		else{
		   echo "Header Not Sent  to ML";
		}
		exit;	
	}


}

?>