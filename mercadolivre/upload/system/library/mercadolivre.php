<?php

final class Mercadolivre {

    private $registry;
	
	private static $API_DOMAIN = 'https://api.mercadolibre.com';

	private $appId;
	private $appSecret;
	private $accessToken = null;
	private $refreshToken;
	private $tokenExpire;

	public $error='';
	public $dump=false;
	
    public function __construct($registry) {
        $this->registry = $registry;
		
    if($this->config->get('mercadolivre_access_token') && $this->config->get('mercadolivre_token_expire'))
		{
			$this->accessToken=trim($this->config->get('mercadolivre_access_token'));
			$this->refreshToken=trim($this->config->get('mercadolivre_refresh_token'));
			$this->tokenExpire=trim($this->config->get('mercadolivre_token_expire'));
		}
		
		if($this->config->get('mercadolivre_app_id'))
		{
		    $this->appId=trim($this->config->get('mercadolivre_app_id'));
		}
		
		if($this->config->get('mercadolivre_app_secret'))
		{
		    $this->appSecret=trim($this->config->get('mercadolivre_app_secret'));
		}
		
    }

    public function __get($name) {
        return $this->registry->get($name);
    }
	
	public function getAppUser()
	{
	     $this->getAccess();
		 $param=array();
		 $url=self::$API_DOMAIN.'/users/me?access_token='.$this->accessToken; 
	     $app_user=$this->callAPI($url,'GET',$param); 
	     if($this->error){
	       return false;
	     } else {
	       return $app_user->id; 
	     }
	}
	
	public function getAccess() {
        
		
		if($this->accessToken && $this->refreshToken)
		{
            if($this->tokenExpire < time() + 1)
			{
			   $this->refreshToken(); 
			}
			return true;
		}
       else {
            return false;
        }

    }
	
	public function setAccess($accessToken,$refreshToken,$tokenExpire) {
	
		$data=array();
		$data['mercadolivre_access_token']=$accessToken;
		$data['mercadolivre_refresh_token']=$refreshToken;
		$data['mercadolivre_token_expire']=time()+$tokenExpire;
		$data['mercadolivre_app_id']=$this->config->get('mercadolivre_app_id');
		$data['mercadolivre_app_secret']=$this->config->get('mercadolivre_app_secret');
		$data['mercadolivre_debug']=$this->config->get('mercadolivre_debug');
		$data['mercadolivre_status']=$this->config->get('mercadolivre_status');
		$data['mercadolivre_mercaId']=$this->config->get('mercadolivre_mercaId');
		$data['mercadolivre_mercaCurrency']=$this->config->get('mercadolivre_mercaCurrency');
		$data['mercadolivre_mercaBuyMode']=$this->config->get('mercadolivre_mercaBuyMode');
		$data['mercadolivre_mercaListType']=$this->config->get('mercadolivre_mercaListType');
		$data['mercadolivre_mercaCondition']=$this->config->get('mercadolivre_mercaCondition');
		$data['mercadolivre_category_tree']=$this->config->get('mercadolivre_category_tree');
		$data['mercadolivre_mercaPrice']=$this->config->get('mercadolivre_mercaPrice');
		$data['mercadolivre_mercaWarranty']=$this->config->get('mercadolivre_mercaWarranty');
		$data['mercadolivre_image_in_desc']=$this->config->get('mercadolivre_image_in_desc');
		$data['mercadolivre_new_customer']=$this->config->get('mercadolivre_new_customer');
		$data['mercadolivre_shipping']=$this->config->get('mercadolivre_shipping');
		$data['mercadolivre_payment']=$this->config->get('mercadolivre_payment');
		
		$data['mercadolivre_feedback']=$this->config->get('mercadolivre_feedback');
		$data['mercadolivre_feedback_order']=$this->config->get('mercadolivre_feedback_order');
		$data['mercadolivre_feedback_rating']=$this->config->get('mercadolivre_feedback_rating');
		$data['mercadolivre_feedback_message']=$this->config->get('mercadolivre_feedback_message');
		$data['mercadolivre_shipping_name1']=$this->config->get('mercadolivre_shipping_name1');
		$data['mercadolivre_shipping_name2']=$this->config->get('mercadolivre_shipping_name2');
		$data['mercadolivre_shipping_name3']=$this->config->get('mercadolivre_shipping_name3');
		$data['mercadolivre_shipping_name4']=$this->config->get('mercadolivre_shipping_name4');
		$data['mercadolivre_shipping_name5']=$this->config->get('mercadolivre_shipping_name5');
		
		$data['mercadolivre_shipping_cost1']=$this->config->get('mercadolivre_shipping_cost1');
		$data['mercadolivre_shipping_cost2']=$this->config->get('mercadolivre_shipping_cost2');
		$data['mercadolivre_shipping_cost3']=$this->config->get('mercadolivre_shipping_cost3');
		$data['mercadolivre_shipping_cost4']=$this->config->get('mercadolivre_shipping_cost4');
		$data['mercadolivre_shipping_cost5']=$this->config->get('mercadolivre_shipping_cost5');
		$data['mercadolivre_template']=$this->config->get('mercadolivre_template');
	
		
		$this->editSetting('mercadolivre', $data);
        
	    $this->accessToken=$accessToken;
		$this->refreshToken=$refreshToken;
		$this->tokenExpire=$tokenExpire;
    }
	
	public function getAccessToken($code)
	{
	  $url=self::$API_DOMAIN.'/oauth/token';  
	  
	  $param = array(
				 "client_id" => $this->appId,
				 "client_secret" => $this->appSecret,
				 "redirect_uri" => HTTP_SERVER.'mercadolivre_auth',
				 "code" => $code,
				 "grant_type" => "authorization_code"
			);
		
		$data=$this->callAPI($url,'POST',$param);
		if($this->error){
		  return '<strong>Error:</strong> Failed to get access code. Please check your application setting. <br> <strong>Message from Mercadolivre:</strong>'.$this->error;
		}else{
			if(is_object($data) && property_exists($data,'access_token')){	
			  $accessToken = $data->access_token;
			  $tokenExpire = $data->expires_in;
			  $refreshToken = $data->refresh_token;
			  $this->setAccess($accessToken,$refreshToken,$tokenExpire);
			}
		  return '';
		}
		
	}
	
	
	public function refreshToken()
	{
	  
	  $url=self::$API_DOMAIN.'/oauth/token';   
	  $param = array(
				 "client_id" => $this->appId,
				 "client_secret" => $this->appSecret,
				 "refresh_token" => $this->refreshToken,
				 "grant_type" => "refresh_token"
			);
		
		$data=$this->callAPI($url,'POST',$param);
		
	    if(is_object($data) && property_exists($data,'access_token')){		
			  $accessToken = $data->access_token;
			  $tokenExpire = $data->expires_in;
			  $refreshToken = $data->refresh_token;
			  $this->setAccess($accessToken,$refreshToken,$tokenExpire);
		 }
		
	}
	
	public function getLoginUrl()
	{
	  //self::$API_DOMAIN
	  $url='https://auth.mercadolibre.com.ar/authorization?client_id='.$this->appId.'&response_type=code&redirect_uri='.HTTP_SERVER.'mercadolivre_auth';  
	  return $url;
	}
	
	public function getLogoutUrl()
	{
	
	}
	

   public function createTestUser()
   {
     $this->getAccess();
	 
	 /*getting site Id*/
	 $url=self::$API_DOMAIN.'/applications/'.$this->appId;   
     $param = array();
     $data=$this->callAPI($url,'GET',$param); 
     $site_id=$data->site_id;
	 
	 
	 
	 $url=self::$API_DOMAIN.'/users/test_user?access_token='.$this->accessToken; 
	 $param=array();
	 $param['site_id']=$site_id;
	 $param = json_encode($param);     
	 $header= array(                                                                          
       'Content-Type: application/json',                                                                                
       'Content-Length: ' . strlen($param)                                                                       
     );  
	 $data=$this->callAPI($url,'POST',$param,$header);
	 echo 'id: '.$data->id; echo '<br>';
	 echo 'nickname: '.$data->nickname; echo '<br>';
	 echo 'password: '.$data->password; echo '<br>';
	 echo 'email: '.$data->email; echo '<br>';
   }
	
	public function addProduct($param)
	{
	   
	   
	    if($this->validateItem($param)){
		
		$this->getAccess();
		
		$url=self::$API_DOMAIN.'/items?access_token='.$this->accessToken; 
	
		 $param = json_encode($param);     
		 $header= array(                                                                          
		   'Content-Type: application/json',                                                                                
		   'Content-Length: ' . strlen($param)                                                                       
		 );  
		
		
		$data=$this->callAPI($url,'POST',$param,$header);
		$itemId='';
		
		
		if($this->error=='')
		{
		  $itemId=$data->id;
		}  
		 
		return $itemId;
	  }
	  
	  return false;
	  	
	}
	
	public function updateProduct($param,$itemId)
	{
	    $this->getAccess();
		
		$url=self::$API_DOMAIN.'/items/'.$itemId.'?access_token='.$this->accessToken; 
		
		$param = json_encode($param);  
	
		$header= array(                                                                          
		   'Content-Type: application/json',                                                                                
		   'Content-Length: ' . strlen($param)                                                                       
		 ); 
		
	    $data=$this->callAPI($url,'PUT',$param,$header);
		
	}
	
	public function isShippingAllowed($category_id){
	    
	     $this->getAccess();
	     $user_id=$this->getAppUser();
		 $param=array();
		 $url=self::$API_DOMAIN.'/users/'.$user_id.'/shipping_modes?category_id='.$category_id; 
	     $category_shipping=$this->callAPI($url,'GET',$param); 
	     if($this->error){
	       return true;
	     }
	     
	     if(is_array($category_shipping)){
	       foreach($category_shipping as $avail_method){
	         if ($avail_method->mode=='custom') {
	          return true;
	        }
	       }
	     }
	  return false;  
	     
	}
	
	public function validateItem($param)
	{
	     $this->getAccess();
		
		 $url=self::$API_DOMAIN.'/items/validate?access_token='.$this->accessToken; 
		 $param = json_encode($param);     
		 $header= array(                                                                          
		   'Content-Type: application/json',                                                                                
		   'Content-Length: ' . strlen($param)                                                                       
		 );  
		
	   $this->callAPI($url,'POST',$param,$header); 
	   
	   if($this->error=='') return true;
	   else return false;
	}
	
	function updateOpencartProduct($itemId)
	{
	    $this->getAccess();
		$merca_product=$this->db->query("SELECT * FROM `".DB_PREFIX."mercadolivre_product` WHERE `mercaId` = '" . $itemId . "'")->row; 
		
		if($merca_product)  
		{
			$param=array();
			$url=self::$API_DOMAIN.'/items/'.$itemId.'?access_token='.$this->accessToken; 
			$product_data=$this->callAPI($url,'GET',$param);
			
			
			$product_id=$merca_product['product_id'];
		
		    //Dont need to update here as it is creating problem due to mupltile api calling
			//$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$product_data->available_quantity . "' WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("UPDATE " . DB_PREFIX . "mercadolivre_product SET status = '" . $this->db->escape($product_data->status) . "', substatus = '', url = '" . $this->db->escape($product_data->permalink) . "' WHERE mercaId = '" .$itemId . "'");
			
	    }		
	}
	
	public function processAPIOrder(){
	   $this->db->query("DELETE FROM `" . DB_PREFIX . "mercadolivre_api_call` WHERE done =1");
	   $api_orders=$this->db->query("SELECT * FROM `".DB_PREFIX."mercadolivre_api_call` WHERE callType='order' and `done` = '0'")->rows;	
	   if($api_orders){
		    foreach($api_orders as $api_order){
				$mercaOrderId=$api_order['callId'];
				if($mercaOrderId){
			      $this->mercadolivre->createOpencartOrder($mercaOrderId);
				  $this->db->query("UPDATE `" . DB_PREFIX . "mercadolivre_api_call` SET done = '1' WHERE callId = '" . $mercaOrderId . "'");
				}
		    }   
		}
    }
	
	public function createOpencartOrder($mercaOrderId)
	{
	    $this->getAccess();
		
		$merca_order=$this->db->query("SELECT * FROM `".DB_PREFIX."mercadolivre_order` WHERE `mercaOrderId` = '" . $mercaOrderId . "'")->row;
		
		if(!$merca_order)  /* Only work if this order already not inserted */
		{
			$param=array();
			$url=self::$API_DOMAIN.'/orders/'.$mercaOrderId.'?access_token='.$this->accessToken; 
			
			$order_data=$this->callAPI($url,'GET',$param);
			
			if($this->error)
			{
			  $this->log->write('MERCADOLIVRE Order API Error: '.$this->error);
			}
			else
			{
					
			$data=array();
			$data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$data['store_id'] = $this->config->get('config_store_id');
			$data['store_name'] = $this->config->get('config_name');
			
			if ($data['store_id']) {
					$data['store_url'] = $this->config->get('config_url');		
				} else {
					$data['store_url'] = HTTP_SERVER;	
			 }
			 
			 /* Collect Customer Address if avaiable*/
			 $param=array();
			 $url=self::$API_DOMAIN.'/users/'.$order_data->buyer->id.'/addresses?access_token='.$this->accessToken; 
			
			 $customer_data=$this->callAPI($url,'GET',$param);
			 $customer_data=is_array($customer_data)?array_pop($customer_data):array();
			
			 $address_1=(is_object($customer_data) && property_exists($customer_data,'address_line'))?$customer_data->address_line:'Mercadolivre';
			 
			 $address_2='';
			 $address_2 .=(is_object($customer_data) && property_exists($customer_data,'floor'))?' '.$customer_data->floor:'';
			 $address_2 .=(is_object($customer_data) && property_exists($customer_data,'apartment'))?' '.$customer_data->apartment:'';
			 $address_2 .=(is_object($customer_data) && property_exists($customer_data,'street_number'))?' '.$customer_data->street_number:'';
			 $address_2 .=(is_object($customer_data) && property_exists($customer_data,'street_name'))?' '.$customer_data->street_name:'';
			$address_2=trim($address_2);
			
			$city=(is_object($customer_data) && property_exists($customer_data,'city'))?$customer_data->city->name:'ML'; 
			
			$state_code=(is_object($customer_data) && property_exists($customer_data,'state'))?$customer_data->state->id:'';
			
			$postcode=(is_object($customer_data) && property_exists($customer_data,'zip_code'))?$customer_data->zip_code:'';
			$customer_phone=(is_object($customer_data) && property_exists($customer_data,'phone'))?$customer_data->phone:'';
			
			
			$country_code='';
			if ($state_code) list($country_code,$state_code)=explode('-',$state_code);
		    
			$coutryRow=$this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE `iso_code_2` = '" . $country_code. "'")->row;
			if($coutryRow) {
			  $zoneRow=$this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE `code` = '" . $state_code. "' and country_id='".$coutryRow['country_id']."'")->row;	
			} 
		  
			/*  End of customer*/
			
			 
			 $phone='';
			 if(property_exists($order_data->buyer,'phone')){
			   $phone.=(property_exists($order_data->buyer->phone,'area_code')?$order_data->buyer->phone->area_code:'');
			   $phone.=(property_exists($order_data->buyer->phone,'number')?' '.$order_data->buyer->phone->number:'');
			   $phone.=(property_exists($order_data->buyer->phone,'extension')?' '.$order_data->buyer->phone->extension:'');
			 }
			 
			 $cpf=property_exists($order_data->buyer->billing_info,'doc_number')?$order_data->buyer->billing_info->doc_type.': '.$order_data->buyer->billing_info->doc_number:'';
			 
			 $customerInfo=$this->db->query("SELECT * FROM `" . DB_PREFIX . "customer` WHERE `email` = '" . $order_data->buyer->email. "'")->row;
			 
			 
			 if($customerInfo){
				 $data['customer_id'] = $customerInfo['customer_id'];
				 $data['customer_group_id'] = ($customerInfo['customer_group_id'])?$customerInfo['customer_group_id']:0;
			 }else{
				 
				 if($this->config->get('mercadolivre_new_customer')){
					 $customer_data=array();
					 $customer_data['customer_group_id']=1;
					 $customer_data['email']=$order_data->buyer->email;
					 $customer_data['firstname']=$order_data->buyer->first_name;
					 $customer_data['lastname']=$order_data->buyer->last_name;
					 $customer_data['telephone']=($phone)?$phone:$customer_phone;
					 $customer_data['ip']=$this->request->server['REMOTE_ADDR'];
					 $customer_data['address_1']=$address_1;
					 $customer_data['address_2']=$address_2;
					 $customer_data['city']=$city;
					 $customer_data['zone_id']=(isset($zoneRow) && $zoneRow)?$zoneRow['zone_id']:$this->config->get('config_zone_id');
					 $customer_data['postcode']=$postcode;
					 $customer_data['country_id']=(isset($coutryRow) && $coutryRow)?$coutryRow['country_id']:$this->config->get('config_country_id');
					 $data['customer_id']=$this->createOCCustomer($customer_data); 
				 }else{
				    $data['customer_id'] = 0;	 
				 }
				 $data['customer_group_id'] = 1; 
			 }
			 $data['firstname'] = $order_data->buyer->first_name;
			 $data['lastname'] = $order_data->buyer->last_name.'(Nick: '.$order_data->buyer->nickname.')';
			 $data['email'] = $order_data->buyer->email;
			 $data['telephone'] = ($phone)?$phone:$customer_phone;
			 $data['fax'] = '';
			 
			 $countryInfo = $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE country_id = '" . $this->config->get('config_country_id'). "'")->row;
			 
			 $data['payment_firstname'] = $order_data->buyer->first_name;
			 $data['payment_lastname'] = $order_data->buyer->last_name;
			 $data['payment_company'] = $cpf; 
			 $data['payment_company_id'] = '';	
			 $data['payment_tax_id'] = '';
			 $data['payment_address_1'] = $address_1;
			 $data['payment_address_2'] = $address_2;
			 $data['payment_city'] = $city;
			 $data['payment_postcode'] = $postcode;
			 $data['payment_zone'] = (isset($zoneRow) && $zoneRow)?$zoneRow['name']:$state_code; 
			 $data['payment_zone_id'] = (isset($zoneRow) && $zoneRow)?$zoneRow['zone_id']:$this->config->get('config_zone_id');
			 $data['payment_country'] = (isset($coutryRow) && $coutryRow)?$coutryRow['name']:$countryInfo['name'];
			 $data['payment_country_id'] = (isset($coutryRow) && $coutryRow)?$coutryRow['country_id']:$this->config->get('config_country_id');
			 $data['payment_address_format'] ='';
			 $data['payment_method'] = $this->getModuleName($this->config->get('mercadolivre_payment'),'payment'); 
			 $data['payment_code'] = $this->config->get('mercadolivre_payment');
			 
			 $data['shipping_firstname'] = $order_data->buyer->first_name;
			 $data['shipping_lastname'] = $order_data->buyer->last_name;
			 $data['shipping_company'] = '';	
			 $data['shipping_address_1'] = $address_1;
			 $data['shipping_address_2'] = $address_2;
			 $data['shipping_city'] = $city;
			 $data['shipping_postcode'] = $postcode;
			 $data['shipping_zone'] = $state_code;
			 $data['shipping_zone_id'] = (isset($zoneRow) && $zoneRow)?$zoneRow['zone_id']:$this->config->get('config_zone_id');
			 $data['shipping_country'] = ($country_code)?$country_code:$countryInfo['name'];
			 $data['shipping_country_id'] = (isset($coutryRow) && $coutryRow)?$coutryRow['country_id']:$this->config->get('config_country_id');
			 $data['shipping_address_format'] = '';
			 $data['shipping_method'] = $this->getModuleName($this->config->get('mercadolivre_shipping'),'shipping'); 
			 $data['shipping_code'] = $this->config->get('mercadolivre_shipping');
			 
			 $product_data = array();
			 
			 $lang_code=$this->config->get('config_language');
	         $language_id=$this->db->query("select language_id from `".DB_PREFIX."language` where code='$lang_code'")->row['language_id'];
			
			 $oc_currency_info=$this->db->query("SELECT * FROM `" . DB_PREFIX . "currency` WHERE `code` = '" . $order_data->currency_id. "'")->row;
			 if($oc_currency_info){
			  $data['currency_id'] = $oc_currency_info['currency_id'];
			  $data['currency_code'] = $oc_currency_info['code'];
			  $data['currency_value'] = $oc_currency_info['value'];
			}else{
			  $data['currency_id'] = $this->currency->getId();
			  $data['currency_code'] = $this->currency->getCode();
			  $data['currency_value'] = $this->currency->getValue($this->currency->getCode());
			}
			
			$currency_code=$data['currency_code'];
			
			 $sub_total=0;
			foreach ($order_data->order_items as $product) {
			
				$item_id=$product->item->id;
				$oc_product=$this->db->query("SELECT * FROM `".DB_PREFIX."mercadolivre_product` WHERE `mercaId` = '" . $item_id . "'")->row;
				$option_data = array();
				$product_total=(float)$product->unit_price*(float)$product->quantity;
				$sub_total+=$product_total;
				
				$variation_attributes=(property_exists($product->item,'variation_attributes')?$product->item->variation_attributes:array());
				
				foreach($variation_attributes as $attribute){
					$option_data[] = array(
						'product_option_id'       => 0,
						'product_option_value_id' => 0,
						'option_id'               => 0,
						'option_value_id'         => 0,								   
						'name'                    => $attribute->name,
						'value'                   => $attribute->value_name,
						'type'                    => 'text'
					 );	
			    }
				
				if($oc_product)
				{
				  
				  $product_info=$this->db->query("SELECT DISTINCT *, pd.name AS name FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$oc_product['product_id'] . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'")->row;
				  
				  // Downloads		
					$download_data = array();     		

					$download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int)$oc_product['product_id'] . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

					foreach ($download_query->rows as $download) {
						$download_data[] = array(
							'download_id' => $download['download_id'],
							'name'        => $download['name'],
							'filename'    => $download['filename'],
							'mask'        => $download['mask'],
							'remaining'   => $download['remaining']
						);
					}
				  
				  $product_data[] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name'],
					'model'      => $product_info['model'],
					'option'     => $option_data,
					'download'   => $download_data,
					'quantity'   => $product->quantity,
					'subtract'   => $product_info['subtract'],
					'price'      => $product->unit_price,
					'total'      => $product_total,
					'tax'        => 0,
					'reward'     => 0
				  ); 
				}
				else  // if bough product does not have in opencart
				{
				  $product_data[] = array(
					'product_id' => 0,
					'name'       => $product->item->title,
					'model'      => '',
					'option'     => $option_data,
					'download'   => array(),
					'quantity'   => $product->quantity,
					'subtract'   => 0,
					'price'      => $product->unit_price,
					'total'      => $product_total,
					'tax'        => 0,
					'reward'     => 0
				  );    
				
				}
				
			}
		
		
			$total_data=array();
			$this->language->load('total/sub_total');
			$total_data[]=array( 
				'code'       => 'sub_total',
				'title'      => $this->language->get('heading_title'),
				'text'       => $this->currency->format($sub_total,$currency_code),
				'value'      => (float)$sub_total,
				'sort_order' => $this->config->get('sub_total_sort_order')
			);
			
			if(isset($order_data->shipping->cost) && !empty($order_data->shipping->cost)){
			 $method_title=$this->getModuleName($this->config->get('mercadolivre_shipping'),'shipping');	
			 $total_data[] = array( 
					'code'       => 'shipping',
					'title'      => ($method_title)?$method_title:$order_data->shipping->shipment_type,
					'text'       => $this->currency->format((float)$order_data->shipping->cost,$currency_code),
					'value'      => (float)$order_data->shipping->cost,
					'sort_order' => $this->config->get('shipping_sort_order')
				);
			}	
			
			
			$this->language->load('total/total');
			$total_data[] = array(
				'code'       => 'total',
				'title'      => $this->language->get('heading_title'),
				'text'       => $this->currency->format((float)$order_data->total_amount,$currency_code),
				'value'      =>(float)$order_data->total_amount,
				'sort_order' => $this->config->get('total_sort_order')
			);	
			
			
			/* If brazial fields module found */
			if($this->config->get('fields_register_brazil_status')){
				$data['cpf'] = $cpf;
				$data['cnpj'] = '';
				$data['razao_social'] = '';
				$data['inscricao_estadual'] = '';
				$data['data_nascimento'] = '';
				$data['sexo'] = '';
				$data['payment_apelido'] = '';
				$data['payment_numero'] = '';
				$data['payment_complemento'] = '';
				$data['shipping_apelido'] = '';
				$data['shipping_numero'] = '';
				$data['shipping_complemento'] = '';
			}
			/* End of brazial fields*/
			
			$data['products'] = $product_data;
			$data['vouchers'] = array();
			$data['totals'] = $total_data;
			$data['comment'] = '';
			$data['total'] = (float)$order_data->total_amount;
			
			$data['language_id'] = $language_id;
			
		
			$data['ip'] = $this->request->server['REMOTE_ADDR'];
			$data['affiliate_id'] = 0;
			$data['commission'] = 0;
			
			if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
				$data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];	
			} elseif(!empty($this->request->server['HTTP_CLIENT_IP'])) {
				$data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];	
			} else {
				$data['forwarded_ip'] = '';
			}
			
			if (isset($this->request->server['HTTP_USER_AGENT'])) {
				$data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];	
			} else {
				$data['user_agent'] = '';
			}
			
			if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
				$data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];	
			} else {
				$data['accept_language'] = '';
			}
			 
			 
			
			$order_id = $this->addOrder($data);
			
			$order_status_id=$this->getOCStatus($order_data->status);
			
			if(empty($order_status_id))
			$order_status_id = $this->config->get('config_order_status_id');
			
			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
	
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '1', comment = 'Mercadolibre order ( Order # ".$mercaOrderId.")', date_added = NOW()");
			
			
			
			/* Update shipping info */
			$param=array();
			$url=self::$API_DOMAIN.'/orders/'.$mercaOrderId.'/shipments?access_token='.$this->accessToken; 
			$shipping_data=$this->callAPI($url,'GET',$param);
			$shipping_address_1='';
			$shipping_city='';
			$shipping_postcode='';
			$shipping_country='';
			$shipping_zone='';
			$shipping_method='';
			$shipping_cost=0;
			if(is_object($shipping_data) && property_exists($shipping_data,'receiver_address')){
			  $shipping_address_1 = property_exists($shipping_data->receiver_address,'address_line')?$shipping_data->receiver_address->address_line:'';
			  $shipping_city = property_exists($shipping_data->receiver_address,'city')?$shipping_data->receiver_address->city->name:'';
			  $shipping_postcode = property_exists($shipping_data->receiver_address,'zip_code')?$shipping_data->receiver_address->zip_code:'';
			  $shipping_country = property_exists($shipping_data->receiver_address,'country')?$shipping_data->receiver_address->country->name:'';
			  $shipping_zone = property_exists($shipping_data->receiver_address,'state')?$shipping_data->receiver_address->state->name:'';
			}
			if(is_object($shipping_data) && property_exists($shipping_data,'shipping_option')){
			 $shipping_method = property_exists($shipping_data->shipping_option,'name')?$shipping_data->shipping_option->name:'';
			 $shipping_cost = property_exists($shipping_data->shipping_option,'cost')?$shipping_data->shipping_option->cost:'';
			}
			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET shipping_address_1 = '" . $this->db->escape($shipping_address_1) . "', shipping_city = '" . $this->db->escape($shipping_city) . "', shipping_postcode = '" . $this->db->escape($shipping_postcode) . "', shipping_country = '" . $this->db->escape($shipping_country) . "', shipping_zone = '" . $this->db->escape($shipping_zone) . "',  shipping_method = '" . $this->db->escape($shipping_method) . "' WHERE order_id = '" . (int)$order_id . "'");
			
			if($shipping_cost){
			   $oc_shipping_info=$this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE code='shipping' and `order_id` = '" . (int)$order_id. "'")->row;
			   if($oc_shipping_info){
					 $title = $shipping_method;
					 $text = $this->currency->format((float)$shipping_cost,$currency_code);
					 $value = (float)$shipping_cost;
					 $this->db->query("UPDATE `" . DB_PREFIX . "order_total` SET title = '" . $this->db->escape($title) . "', text = '" . $this->db->escape($text) . "', value = '" . $value . "' WHERE code='shipping' and `order_id` = '" . (int)$order_id. "'");
					 
			   }else{
			   
					 $title = $shipping_method;
					 $text = $this->currency->format((float)$shipping_cost,$currency_code);
					 $value = (float)$shipping_cost;
					 $sort_order = $this->config->get('shipping_sort_order'); 
					 $this->db->query("INSERT INTO `" . DB_PREFIX . "order_total` SET code='shipping', title = '" . $this->db->escape($title) . "', text = '" . $this->db->escape($text) . "', value = '" . $value . "', sort_order='" . $sort_order . "', `order_id` = '" . (int)$order_id. "'");
			   }
			}
			/*End Shipping info*/
			
			
			//updating stock
			$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
				
			foreach ($order_product_query->rows as $order_product) {
					$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "' AND subtract = '1'");
					
					$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product['order_product_id'] . "'");
				
					foreach ($order_option_query->rows as $option) {
						$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
					}
					
				  /* Update Merca Option stock*/
				   $mercaInfo=$this->getMercadolivreIDs($order_product['product_id']);
			      if ($mercaInfo)
					{
				     $this->updateMLAttributeIDs($mercaInfo['mercaId'],$order_product['product_id']);
					}
					/* End of stock update*/
				}
			
		  /*Update Marca order table*/
		  $this->db->query("INSERT INTO " . DB_PREFIX . "mercadolivre_order SET order_id = '" . (int) $order_id. "', `mercaOrderId` = '" . $this->db->escape($mercaOrderId) . "'"); 
		 }  	   	
	  } 
	
    }
	
	protected function updateOpencartOrder($mercaOrderId,$order_id)
	{
	    $this->getAccess();
		
	   if($mercaOrderId && $order_id) 
	     {
	        $param=array();
			 $url=self::$API_DOMAIN.'/orders/'.$mercaOrderId.'?access_token='.$this->accessToken; 
			 $order_data=$this->callAPI($url,'GET',$param);
		
	        $order_status_id=$this->getOCStatus($order_data->status);
	        
	        $oc_order_info=$this->db->query("SELECT order_status_id FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "'")->row;
			
			$oc_currency_info=$this->db->query("SELECT * FROM `" . DB_PREFIX . "currency` WHERE `code` = '" . $order_data->currency_id. "'")->row;
			if($oc_currency_info){
			  $currency_code = $oc_currency_info['code'];
			}else{
			  $currency_code = $this->currency->getCode();
			}
			
			
			if(!empty($order_status_id) && !empty($order_id))
			{
				$stopSync=$this->db->query("SELECT stopSync FROM `".DB_PREFIX."mercadolivre_order` WHERE `order_id` = '" . (int)$order_id . "'")->row['stopSync'];
				
				if($stopSync!=1){
				   
				   if($oc_order_info['order_status_id']!=$order_status_id){
					 
					 $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '1', comment = '', date_added = NOW()");
					 }
				  
				   $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', total='".(float)$order_data->total_amount."', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
				}
			} 
			
			
			/* Update shipping info */
			$param=array();
			$url=self::$API_DOMAIN.'/orders/'.$mercaOrderId.'/shipments?access_token='.$this->accessToken; 
			$shipping_data=$this->callAPI($url,'GET',$param);
			
			$shipping_address_1='';
			$shipping_city='';
			$shipping_postcode='';
			$shipping_country='';
			$shipping_zone='';
			$shipping_method='';
			$shipping_cost=0;
			if(is_object($shipping_data) && property_exists($shipping_data,'receiver_address')){
			  $shipping_address_1 = property_exists($shipping_data->receiver_address,'address_line')?$shipping_data->receiver_address->address_line:'';
			  $shipping_city = property_exists($shipping_data->receiver_address,'city')?$shipping_data->receiver_address->city->name:'';
			  $shipping_postcode = property_exists($shipping_data->receiver_address,'zip_code')?$shipping_data->receiver_address->zip_code:'';
			  $shipping_country = property_exists($shipping_data->receiver_address,'country')?$shipping_data->receiver_address->country->name:'';
			  $shipping_zone = property_exists($shipping_data->receiver_address,'state')?$shipping_data->receiver_address->state->name:'';
			}
			if(is_object($shipping_data) && property_exists($shipping_data,'shipping_option')){
			 $shipping_method = property_exists($shipping_data->shipping_option,'name')?$shipping_data->shipping_option->name:'';
			 $shipping_cost = property_exists($shipping_data->shipping_option,'cost')?$shipping_data->shipping_option->cost:'';
			}
			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET shipping_address_1 = '" . $this->db->escape($shipping_address_1) . "', shipping_city = '" . $this->db->escape($shipping_city) . "', shipping_postcode = '" . $this->db->escape($shipping_postcode) . "', shipping_country = '" . $this->db->escape($shipping_country) . "', shipping_zone = '" . $this->db->escape($shipping_zone) . "',  shipping_method = '" . $this->db->escape($shipping_method) . "' WHERE order_id = '" . (int)$order_id . "'");
			
			if($shipping_cost){
			   $oc_shipping_info=$this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE code='shipping' and `order_id` = '" . (int)$order_id. "'")->row;
			   if($oc_shipping_info){
					 $title = $shipping_method;
					 $text = $this->currency->format((float)$shipping_cost,$currency_code);
					 $value = (float)$shipping_cost;
					 $this->db->query("UPDATE `" . DB_PREFIX . "order_total` SET title = '" . $this->db->escape($title) . "', text = '" . $this->db->escape($text) . "', value = '" . $value . "' WHERE code='shipping' and `order_id` = '" . (int)$order_id. "'");
					 
			   }else{
			   
					 $title = $shipping_method;
					 $text = $this->currency->format((float)$shipping_cost,$currency_code);
					 $value = (float)$shipping_cost;
					 $sort_order = $this->config->get('shipping_sort_order'); 
					 $this->db->query("INSERT INTO `" . DB_PREFIX . "order_total` SET code='shipping', title = '" . $this->db->escape($title) . "', text = '" . $this->db->escape($text) . "', value = '" . $value . "', sort_order='" . $sort_order . "', `order_id` = '" . (int)$order_id. "'");
			   }
			}
			
			/*Update order total in order total in update mode in case total affected by shipping amount*/
			   $text = $this->currency->format((float)$order_data->total_amount,$currency_code);
			   $value =(float)$order_data->total_amount;
			   $this->db->query("UPDATE `" . DB_PREFIX . "order_total` SET text = '" . $this->db->escape($text) . "', value = '" . $value . "' WHERE code='total' and `order_id` = '" . (int)$order_id. "'");
			 /*End Shipping info*/
			
			
		   // auto feedback send
	      if(is_object($order_data) && property_exists($order_data,'status') && $order_data->status==$this->config->get('mercadolivre_feedback_order')){
	         $this->sendFeedback($mercaOrderId);
	       }
		   	 
	    }
    		
	}
	
	
	function updateListingType()
	{
	   $this->getAccess();
	   $url=self::$API_DOMAIN.'/applications/'.$this->appId;   
	   $param = array();
	   $data=$this->callAPI($url,'GET',$param); 
	   $site_id=$data->site_id; 
	  
	   //getting categories
	   $url=self::$API_DOMAIN.'/sites/'.$site_id.'/listing_types'; 
	   $param = array();   
	   $data=$this->callAPI($url,'GET',$param);  
	  
	   if(empty($data))$data=array();
	   
	   $this->db->query("delete from " . DB_PREFIX . "mercadolivre_listing_type where 1");
	   foreach($data as $single)
	   {
	  
	       if(!empty($single->name))
		   {
		     $this->db->query("INSERT INTO " . DB_PREFIX . "mercadolivre_listing_type SET code = '" . $this->db->escape($single->id) . "', `name` = '" . $this->db->escape($single->name) . "'");  
		   }
	   }
	  
	}
	
	function updateCategory()
	{
	   $this->getAccess();
	   $url=self::$API_DOMAIN.'/applications/'.$this->appId;   
	   $param = array();
	   $data=$this->callAPI($url,'GET',$param); 
	   $site_id=$data->site_id; 
	  
	   //getting categories
	   $url=self::$API_DOMAIN.'/sites/'.$site_id.'/categories'; 
	   $param = array();   
	   $data=$this->callAPI($url,'GET',$param);  
	  
	   if(empty($data))$data=array();
	   
	   $this->db->query("delete from " . DB_PREFIX . "mercadolivre_category where 1");
	   foreach($data as $single)
	   {
	  
	       if(!empty($single->name))
		   {
		     $this->db->query("INSERT INTO " . DB_PREFIX . "mercadolivre_category SET mercaId = '" . $this->db->escape($single->id) . "', `name` = '" . $this->db->escape($single->name) . "'");  
		   }
	   }
	  
	}
	
	public function getCategory($catId)
	{
	     $this->getAccess();
		 $url=self::$API_DOMAIN.'/categories/'.$catId; 
		 $param = array();   
		 $cat_data=$this->callAPI($url,'GET',$param);  
		 $return=array();
		 foreach($cat_data->children_categories as $cat)
			{
			  $return[]=array('id'=>$cat->id,'name'=>$cat->name);	
			} 
			
		 $attribute_types=($cat_data->attribute_types=='variations')?1:0;	
		 $allowed=($cat_data->settings->listing_allowed)?1:0;
		 
		 /*find listing type of the selected category*/
		 
		 $this->load->language('module/mercadolivre-extra');
	     $ml_text_select = $this->language->get('ml_text_select');
		 
		 $url=self::$API_DOMAIN.'/categories/'.$catId.'/listing_types'; 
		 $listing_type_data=$this->callAPI($url,'GET',$param);
		 
		 
		 $current_listtype=isset($this->request->get['listingType'])?$this->request->get['listingType']:'';
		 
		 $listing_type_html='';
		 if($listing_type_data){
			   $listing_type_html.='<option value="">'.$ml_text_select.'</option>';
			   foreach($listing_type_data as $listing_type){
			      $selected=($current_listtype==$listing_type->id)?'selected':'';
			      $listing_type_html.='<option '.$selected.' value="'.$listing_type->id.'">'.$listing_type->name.'</option>';
			   }
			   $listing_type_html.='</select>';
		  }  
		 
	     return array('categories'=>$return,'attribute_types'=>$attribute_types,'allowed'=>$allowed,'listing_type'=>$listing_type_html);	
	}
	
	public function getAttributes($catId){
	   
	     $this->getAccess();
		 $url=self::$API_DOMAIN.'/categories/'.$catId.'/attributes'; 
		 $param = array();   
		 $attr_data=$this->callAPI($url,'GET',$param);  
		 $return=array();
		 
		 
		 
		 if(!is_array($attr_data))$attr_data=array();
		 
		 foreach($attr_data as $single)
			{
			  $return[]=$this->parseAttr($single);
			}  
		 
	     return $return; 
	   
	}
	
	private function parseAttr($attr){
	   
	    if(!is_object($attr)) return false;
	    if(!property_exists($attr->tags,'allow_variations')) return false;
	   
	    
	    $return =array();
	    $return['id']=$attr->id;
	    $return['name']=$attr->name;
	    $return['type']=$attr->value_type;
	    $return['required']=(property_exists($attr->tags,'required')?1:0);
	    
	    $option_values=array();
	    if(isset($attr->values) && is_array($attr->values)){
	          foreach($attr->values as $value){
	             $option_values[$value->id]=$value->name;
	          }
	        }
	   $return['options']=$option_values;
	   
	   return $return;
	    
	}
	
	public function renderAttributes($attrs){
	   if(!$attrs) return '';
	   
	   $this->load->language('module/mercadolivre-extra');
	   $ml_text_select = $this->language->get('ml_text_select');
	   
	   $return='<table class="list" id="ml_attribute">
                <thead>
                  <tr>';
       foreach($attrs as $attr){  
         $req=($attr['required'])?'<span style="color:red;font-size:14px;"> *</span>':'';          
         $return.='<td class="left">'.$attr['name'].$req.'</td>';
          }
      
       $return.='<td class="left">'.$this->language->get('ml_text_quantity').'</td>
                    <td class="left">'.$this->language->get('ml_text_price').'</td>
                    <td>'.$this->language->get('ml_text_picture').'</td>
                    <td>&nbsp;</td>
                 </tr>
               </thead>
               <tbody>';
                       
       $row_html='<tr id="ml_attr_row__AINDEX__" class="ml_attr_row">';
       
       $this->load->model('tool/image');
                
	   foreach($attrs as $attr){

		  $row_html.='<td class="left">';
		  
		  if($attr['type']=='list' || $attr['type']=='boolean'){
		    $row_html.='<select name=ml_attr[name]['.$attr['id'].'][]>';
		    $row_html.='<option value="">'.$ml_text_select.'</option>';
		    foreach($attr['options'] as $value=>$text){
		      $row_html.='<option value="'.$value.'~'.$text.'">'.$text.'</option>';
		    }
		    $row_html.='</select>';
		  }
		  if($attr['type']=='string' || $attr['type']=='number'){
		    $row_html.='<input name=ml_attr[name]['.$attr['id'].'][] value="" type="text" size="22" />';
		  }
		  
		  $row_html.='</td>';
	   }
	   
	   $no_thumb = $this->model_tool_image->resize('no_image.jpg', 100, 100);
	   $row_html.='<td class="left"><input name=ml_attr[quantity][] value="" type="text" size="8" /></td>
                    <td class="left"><input name=ml_attr[price][] value="" type="text" size="8" /></td>
                    <td>
                         <div class="image">
                           <img src="'.$no_thumb.'" alt="" id="ml_thumb__AINDEX__" /><br />
                           <input name=ml_attr[picture][] value="" id="ml_pic__AINDEX__" type="hidden" />
                           <a onclick="image_upload(\'ml_pic__AINDEX__\', \'ml_thumb__AINDEX__\');">'.$this->language->get('ml_text_browse').'</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$(\'#ml_thumb__AINDEX__\').attr(\'src\', \''.$no_thumb.'\'); $(\'#ml_pic__AINDEX__\').attr(\'value\', \'\');">'.$this->language->get('ml_text_clear').'</a>
                           </div>
                    </td>
                    <td><input name=ml_attr[combinationId][] value="" type="hidden" /><a class="button" onclick="removeMLAttribute(__AINDEX__);">'.$this->language->get('ml_text_remove').'</a></td>
            </tr>';
	   
	    $product_id=isset($this->request->get['product_id'])?$this->request->get['product_id']:0;
	    $row_counter=1;
	    
	    if($product_id){
	      $combinations=$this->getMLProductAttribute($product_id,'value');
	      if($combinations){
			  
	           foreach($combinations as $index=>$combination){
	               
				    $quantity=$combination['quantity']; 
	               $picture=$combination['picture'];
				    $price=$combination['price'];   
	               
	               if ($picture && file_exists(DIR_IMAGE . $picture)) {
		        	  $thumb = $this->model_tool_image->resize($picture, 100, 100);
		           } else {
			          $thumb = $this->model_tool_image->resize('no_image.jpg', 100, 100);
			          $picture='';
		           }
		           
		           $return.='<tr id="ml_attr_row'.$row_counter.'" class="ml_attr_row">';      
	              
				  
				   
	              foreach($attrs as $attr){
					      $attr_value=(isset($combination['attributes'][$attr['id']]) && $combination['attributes'][$attr['id']])?$combination['attributes'][$attr['id']]:'';
                        $return.='<td class="left">';
						   $return.='<input name=ml_attr[name]['.$attr['id'].'][] value="'.$attr_value.'" type="hidden" size="22" />'.ucfirst($attr_value);
		                 $return.='</td>';
	                }
					

	                
		            $return.='<td class="left"><input name=ml_attr[quantity][] value="'.$quantity.'" type="text" size="8" /></td>
                    <td class="left"><input name=ml_attr[price][] value="'.$price.'" type="text" size="8" /></td>
                    <td>
                         <div class="image">
                           <img src="'.$thumb.'" alt="" id="ml_thumb'.$row_counter.'" /><br />
                           <input name=ml_attr[picture][] value="'.$picture.'" id="ml_pic'.$row_counter.'" type="hidden" />
                           <a onclick="image_upload(\'ml_pic'.$row_counter.'\', \'ml_thumb'.$row_counter.'\');">'.$this->language->get('ml_text_browse').'</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$(\'#ml_thumb'.$row_counter.'\').attr(\'src\', \''.$no_thumb.'\'); $(\'#ml_pic'.$row_counter.'\').attr(\'value\', \'\');">'.$this->language->get('ml_text_clear').'</a>
                           </div>
                    </td>
                      <td><input name=ml_attr[combinationId][] value="'.$combination['id'].'" type="hidden" /><a class="button" onclick="removeMLAttribute('.$row_counter.');">'.$this->language->get('ml_text_remove').'</a></td>
                    </tr>';
	                
	           $row_counter++;
	           }
	        }
	       
	      }
	    
                          
       $return.='</tbody>';            
       $return.='<tfoot><tr>
                   <td colspan="'.((count($attrs)+3)).'"></td>
                   <td class="left"><a class="button" onclick="addMLAttribute();">'.$this->language->get('ml_text_add_attribute').'</a></td>
                 </tr></tfoot>';          
	   $return.='</table>'; 
	   
	   return array('html'=>$return,'row'=>$row_html);
	}
	
	public function editSetting($group, $data, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");

		foreach ($data as $key => $value) {
			if (!is_array($value)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1'");
			}
		}
	}
	
  public function addAPICall($callId,$callType){
	   
	   $dateTime=date('Y-m-d H:i:s');
	   $this->db->query("INSERT INTO " . DB_PREFIX . "mercadolivre_api_call SET `callId` = '" . $this->db->escape($callId) . "', `callType` = '" . $this->db->escape($callType) . "', `dateTime` = '" . $this->db->escape($dateTime) . "', done=0"); 
	   
	   if($callType=='order'){
		   $merca_order=$this->db->query("SELECT * FROM `".DB_PREFIX."mercadolivre_order` WHERE `mercaOrderId` = '" . $callId . "'")->row;
		   if($merca_order){
		       $order_id=$merca_order['order_id']; 
	           $this->updateOpencartOrder($callId,$order_id);
			    $this->db->query("DELETE FROM `" . DB_PREFIX . "mercadolivre_api_call` WHERE callId = '" . $callId . "'");
		   }
	   }
	    
	   return true;
  }	

  public function getOCStatus($merca_status)
  {
      $row=$this->db->query("SELECT * FROM `".DB_PREFIX."mercadolivre_status` WHERE merca_status='$merca_status'")->row;
	  if($row) return $row['oc_status'];
	  else return '';
  } 	
	
  
  public function callAPI($url,$method='GET', $data = false,$header=array())
	{
		 if($this->dump===true)
		 {
		     echo 'URL='.$url; 
		     echo 'Method='.$method;
		     print_r($data);
			 exit;
		 }
		 $curl = curl_init();
	
		 switch ($method)
		 {
			  case "POST":
			         
			         if (is_array($data)) {
					    curl_setopt($curl, CURLOPT_POST, 1);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
					 } else {
						
						curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
						curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
					}
						 
						 
					break;
			  case "PUT":
			  
					curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');					
					if (is_array($data)) {
                        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
					 } else {
						curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
					}
				
					break;
					
			  case "DELETE":
					curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
					break;	
						
			  default:
					if ($data)
						 $url = sprintf("%s?%s", $url, http_build_query($data));
		 }
	
	
		 curl_setopt($curl, CURLOPT_URL, $url);
		 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
         curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
         curl_setopt($curl, CURLOPT_SSLVERSION, 3);
		 
		 if(is_array($header) && !empty($header))
		 {
		   curl_setopt($curl, CURLOPT_HTTPHEADER, $header); 
		 }
	     $this->error='';
		 $content= curl_exec($curl);
		 $information = curl_getinfo($curl);
		 
		
		 $data = json_decode($content);
		 curl_setopt($curl, CURLOPT_HEADER, true);
		 $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		 if($httpcode == 0){
		   $this->error=' Connection Error: - '.curl_error($curl);
		 }
		 elseif($httpcode == 400 || $httpcode == 401 || $httpcode == 403  || $httpcode == 404 || $httpcode == 405 || $httpcode == 406 || $httpcode == 407 || $httpcode == 409 || $httpcode == 410 || $httpcode == 500 || $httpcode == 501 || $httpcode == 502)
		 {

		    $this->error=(property_exists($data,'error'))?$data->error:'';
		     
			if(property_exists($data,'cause') && isset($data->cause[0]) && property_exists($data->cause[0],'code')) {
			 
			   $this->error=$data->cause[0]->code.' - '.$data->cause[0]->message;
			 }
			elseif(property_exists($data,'cause') && isset($data->cause[0])) {
			   $this->error.=' - '.$data->cause[0];
			 }
			 elseif(property_exists($data,'message')){
			   $this->error.=' - '.$data->message;
			 }  
			 else {
			   if(strpos($url,'items/validate')!==false)
			   {
			     $this->error.=' - Validation failed.';
			   }
			 }
			 
			 return false;   
		 }
		 else
		 {
			 return $data;
		 }

	}
	
	
	/* Auto feedback to ML*/
	public function sendFeedback($mercaOrderId)
	{
	    $this->getAccess();
	    
	    if(!$mercaOrderId) return false;
	    
	    if($this->config->get('mercadolivre_feedback') && $this->config->get('mercadolivre_feedback_message')){
	    
	        $merca_order=$this->db->query("SELECT * FROM `".DB_PREFIX."mercadolivre_order` WHERE `mercaOrderId` = '" . $mercaOrderId . "'")->row;
	        if($merca_order && !$merca_order['feedback']){
		
				 $order_id=$merca_order['order_id'];
				 
				 $param=array();
	       		 $param['rating']=$this->config->get('mercadolivre_feedback_rating');
	        	 $param['fulfilled']=true;
	        	 $param['message']=$this->config->get('mercadolivre_feedback_message');
	        
	        	 $param = json_encode($param);     
		    	 $header= array(                                                                          
		           'Content-Type: application/json',                                                                                
		          'Content-Length: ' . strlen($param)                                                                       
		         ); 
	 
			    $url=self::$API_DOMAIN.'/orders/'.$mercaOrderId.'/feedback/?access_token='.$this->accessToken; 
			    $feedback_data=$this->callAPI($url,'POST',$param,$header);
			
			    if($this->error=='')
		         {
		           $this->db->query("UPDATE `" . DB_PREFIX . "mercadolivre_order` SET `feedback` = '1' WHERE `order_id` = '" . (int)$order_id. "'");
		         }
		       else{
		           $this->log->write('MERCADOLIVRE Feedback API Error: '.$this->error);
		           return false;
		        }
		     } 
	     }
		
	}
	
	
	

    public function orderNew($order_id) {
        /**
         * Once an order in opencart and update stock in  Mercadolivre
         */
		 
	  $order_qry = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_product` WHERE `order_id` = '" . (int)$order_id . "'");
      foreach ($order_qry->rows as $product){
	      
		  $product_id=$product['product_id'];
		  
		  $mercaInfo=$this->getMercadolivreIDs($product_id);
		  if(!$mercaInfo) continue;
		
		  $order_product_options = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_option` WHERE `order_product_id` = '" . (int)$product['order_product_id'] . "'")->rows;
		  
		  $oc_options=array();
		  if($order_product_options){
			 foreach($order_product_options as $order_product_option){
				  $oc_options[]=strtolower(trim($order_product_option['value'])); 
		     }  
		  }
		  
		  $oc_combinations=$this->getMLProductAttribute($product_id,'value');
		  
		 
		  
		  if($oc_combinations){
			  $isFound=false;
			  foreach($oc_combinations as $oc_combination){
	
					if(!array_diff($oc_combination['attributes'],$oc_options)){
						 $this->db->query("UPDATE " . DB_PREFIX . "mercadolivre_attr_combination SET quantity=(quantity-".(int)$product['quantity'].") WHERE id='".(int)$oc_combination['id']."'");
						 $isFound=true;
					}
		       }  
			 
			  if($isFound){  //if found, then update ML using API too
				   $product_attributes=array();
				   $combinations=$this->mercadolivre->getMLProductAttribute($product_id); //get updated combinations
				   foreach($combinations as $index=>$combination){
					   
						    $product_attributes[]=array(
							   'id'=>(float)$combination['mercaId'],
							   'available_quantity'=>(int)$combination['quantity']
							  );  
				    }
					
					$param=array();
					$param['variations']=$product_attributes;
					$this->mercadolivre->updateProduct($param,$mercaInfo['mercaId']);
			   } 
 
		   } 
		    else {
		  
			  $quantity=$this->db->query("SELECT * FROM `".DB_PREFIX."product` WHERE `product_id` = '" . (int)$product_id . "'")->row['quantity'];
			  $option='';
			  if($mercaInfo){
				$this->mercadolivreStockUpdate($mercaInfo['mercaId'],$quantity);
			  }
		   }
      } // end of foreach  

    }
	
	public function mercadolivreStockUpdate($itemId,$quantity)
	{
		if($quantity==0){
	     $this->delete($itemId);
	     return true;
	    }
		
	   $param=array();
	   $param['available_quantity']=$quantity;
	   $this->updateProduct($param,$itemId);    
	}

   
	
	public function getMercadolivreIDs($productId, $option='') {
	
        $sql="SELECT * FROM `" . DB_PREFIX . "mercadolivre_product` WHERE `product_id` = '" . (int)$productId . "'";
		if($option!='')$sql.=" AND `option` = '" . $option . "'";
		$result=$this->db->query($sql);
		//if(count($result->rows)==1) return $result->row;
		//else return $result->rows;
		return $result->row;
     }
	 
	 public function getMercadolivreStatus($productId) {
	
        $is_listed=$this->getMercadolivreIDs($productId);
		$this->load->language('module/mercadolivre-extra');
		if(count($is_listed)>0) return $this->language->get('lang_listed');
		else return $this->language->get('lang_not_listed');
     }
	 
	 public function getMercadolivreData($productId,$type) {
	
        $listed_info=$this->getMercadolivreIDs($productId);
		if($listed_info)
		{
		
		  if($type=='status') return 'Item Status: <a target="_blank" href="'.$listed_info['url'].'">'.$listed_info['status'].'</a>';
		  if($type=='url') return 'Item Status: '.$listed_info['url'];
		}  
		else return '';
     }
	 
	 private function createOCCustomer($data) {
		 
		$this->db->query("
			INSERT INTO " . DB_PREFIX . "customer SET
			status =1,
			approved = 1,
			newsletter = 0,
			customer_group_id = " . (int)$data['customer_group_id'] . ",
			email = '" . $this->db->escape($data['email']) . "',
			firstname = '" . $this->db->escape($data['firstname']) . "',
			lastname = '" . $this->db->escape($data['lastname']) . "',
			telephone = '" . $this->db->escape($data['telephone']) . "',
			ip = '" . $this->db->escape($data['ip']) . "',
			password = '" . $this->db->escape(md5(rand())) . "',
			date_added = NOW()
		");
		
		$customer_id = $this->db->getLastId();
		
		$this->db->query("
			INSERT INTO " . DB_PREFIX . "address SET
			customer_id = " . (int)$customer_id . ",
			firstname = '" . $this->db->escape($data['firstname']) . "',
			lastname = '" . $this->db->escape($data['lastname']) . "',
			address_1 = '" . $this->db->escape($data['address_1']) . "',
			address_2 = '" . $this->db->escape($data['address_2']) . "',
			city = '" . $this->db->escape($data['city']) . "',
			zone_id = " . (int)$data['zone_id'] . ",
			postcode = '" . $this->db->escape($data['postcode']) . "',
			country_id = " . (int)$data['country_id'] . "
		");
		
		$address_id = $this->db->getLastId();
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = " . (int)$address_id . " WHERE customer_id = " . (int)$customer_id);
		
		/* Send email to cusotmer*/
		$this->load->model('account/customer_group');
		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($data['customer_group_id']);
		
		$this->language->load('mail/customer');

		$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));

		$message = sprintf($this->language->get('text_welcome'), $this->config->get('config_name')) . "\n\n";

		if (!$customer_group_info['approval']) {
			$message .= $this->language->get('text_login') . "\n";
		} else {
			$message .= $this->language->get('text_approval') . "\n";
		}

		$message .= $this->url->link('account/login', '', 'SSL') . "\n\n";
		$message .= $this->language->get('text_services') . "\n\n";
		$message .= $this->language->get('text_thanks') . "\n";
		$message .= $this->config->get('config_name');

		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');				
		$mail->setTo($data['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
		$mail->send();

		// Send to main admin email if new account email is enabled
		if ($this->config->get('config_account_mail')) {
			$message  = $this->language->get('text_signup') . "\n\n";
			$message .= $this->language->get('text_website') . ' ' . $this->config->get('config_name') . "\n";
			$message .= $this->language->get('text_firstname') . ' ' . $data['firstname'] . "\n";
			$message .= $this->language->get('text_lastname') . ' ' . $data['lastname'] . "\n";
			$message .= $this->language->get('text_customer_group') . ' ' . $customer_group_info['name'] . "\n";

			$message .= $this->language->get('text_email') . ' '  .  $data['email'] . "\n";
			$message .= $this->language->get('text_telephone') . ' ' . $data['telephone'] . "\n";

			$mail->setTo($this->config->get('config_email'));
			$mail->setSubject(html_entity_decode($this->language->get('text_new_customer'), ENT_QUOTES, 'UTF-8'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();

			// Send to additional alert emails if new account email is enabled
			$emails = explode(',', $this->config->get('config_alert_emails'));

			foreach ($emails as $email) {
				if (strlen($email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
		}
		
		return $customer_id;

	}
	 
	 
	 
	 public function getMercadolivreOrderID($order_id) {
	
        $sql="SELECT `mercaOrderId` FROM `" . DB_PREFIX . "mercadolivre_order` WHERE `order_id` = '" . (int)$order_id . "'";
		$result=$this->db->query($sql);
		if($result->row) return 'Yes';
		else return 'No';
     }



    public function newOrderAdminNotify($order_id, $order_status_id){

        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($order_id);
		

        $language = new Language($order_info['language_directory']);
        $language->load($order_info['language_filename']);
        $language->load('mail/order');

        $order_status = $this->db->query("SELECT `name` FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "' LIMIT 1")->row['name'];

        // Order Totals
        $order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE `order_id` = '" . (int)$order_id . "' ORDER BY `sort_order` ASC");

        //Order contents
        $order_product_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_product` WHERE `order_id` = '" . (int)$order_id . "'");

        $subject = sprintf($language->get('text_new_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $order_id);

        // Text
        $text  = $language->get('text_new_received') . "\n\n";
        $text .= $language->get('text_new_order_id') . ' ' . $order_info['order_id'] . "\n";
        $text .= $language->get('text_new_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
        $text .= $language->get('text_new_order_status') . ' ' . $order_status . "\n\n";
        $text .= $language->get('text_new_products') . "\n";

        foreach ($order_product_query->rows as $product) {
            $text .= $product['quantity'] . 'x ' . $product['name'] . ' (' . $product['model'] . ') ' . html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";

            $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $product['order_product_id'] . "'");

            foreach ($order_option_query->rows as $option) {
                if ($option['type'] != 'file') {
                    $value = $option['value'];
                } else {
                    $value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
                }

                $text .= chr(9) . '-' . $option['name'] . ' ' . (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value) . "\n";
            }
        }

        if(isset($order_voucher_query) && is_array($order_voucher_query)){
            foreach ($order_voucher_query->rows as $voucher) {
                $text .= '1x ' . $voucher['description'] . ' ' . $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']);
            }
        }

        $text .= "\n";
        $text .= $language->get('text_new_order_total') . "\n";

        foreach ($order_total_query->rows as $total) {
            $text .= $total['title'] . ': ' . html_entity_decode($total['text'], ENT_NOQUOTES, 'UTF-8') . "\n";
        }

        $text .= "\n";

        if ($order_info['comment']) {
            $text .= $language->get('text_new_comment') . "\n\n";
            $text .= $order_info['comment'] . "\n\n";
        }

        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');
        $mail->setTo($this->config->get('config_email'));
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender($order_info['store_name']);
        $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
        $mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
        $mail->send();

        // Send to additional alert emails
        $emails = explode(',', $this->config->get('config_alert_emails'));

        foreach ($emails as $email) {
            if ($email && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
                $mail->setTo($email);
                $mail->send();
            }
        }
    }
	
	private function getModuleName($code,$type)
	{
	   if(!$code) return '';
	   
	   $this->language->load($type.'/'.$code);
	   return $this->language->get('heading_title');
	} 

    public function delete($itemId){
       /* To do*/
	   $param=array();
	   $param['status']="closed";
	   $this->updateProduct($param,$itemId);   
	   
    }
	
	
	public function updateMLAttributeIDs($itemId,$product_id){
	      $param=array();
		  $url=self::$API_DOMAIN.'/items/'.$itemId.'?access_token='.$this->accessToken; 
		  $product_data=$this->callAPI($url,'GET',$param);
	  
		  $ml_variation_id=array();
		  $ml_combinations=array();
		  $ml_stock=array();
		  
		  
		  $variations=(property_exists($product_data,'variations')?$product_data->variations:array());
		  
		 
		  if($variations){	
		  
			  foreach($variations as $variation){
				   $combinations=(property_exists($variation,'attribute_combinations')?$variation->attribute_combinations:array());	
				   $resultant=array();
				   foreach($combinations as $combination){
					  $resultant[$combination->id]= $combination->value_id;
				   }
				   
				   $ml_variation_id[]=$variation->id;
				   $ml_combinations[]=$resultant;
				   $ml_stock[]=$variation->available_quantity;
				   
				   
			   }
			   
		  }
		 
		  $oc_combinations=$this->getMLProductAttribute($product_id);
  
		  foreach($oc_combinations as $oc_combination){
			 
			   foreach($ml_combinations as $index=>$ml_combination){
				    if(!array_diff_assoc($oc_combination['attributes'],$ml_combination)){
						 $quantity=(int)$ml_stock[$index];
						 $mercaId= $ml_variation_id[$index];
					    $this->db->query("UPDATE " . DB_PREFIX . "mercadolivre_attr_combination SET mercaId = '" . $this->db->escape($mercaId) . "', quantity='".$quantity."' WHERE id='".(int)$oc_combination['id']."'");	
				    }
			   }
			   
		  }
		  
    }
	
	public function getMLProductAttribute($product_id,$type='id'){
	   
	   $combinations=$this->db->query("SELECT * FROM " . DB_PREFIX . "mercadolivre_attr_combination WHERE product_id = '" . (int)$product_id . "'")->rows;
	   if($combinations){
		   foreach($combinations as $index=>$combination){
			  $attributes_rows= $this->db->query("SELECT * FROM " . DB_PREFIX . "mercadolivre_attribute WHERE combinationId = '" . (int)$combination['id'] . "'")->rows;
			  $attributes=array();
			  if($attributes_rows){
				  foreach($attributes_rows as $attributes_row){
					  
					  $attributes[$attributes_row['attributeId']]= ($type=='id')?$attributes_row['attributeValueId']:trim(strtolower($attributes_row['attributeValue']));
				  }  
			  }
			  
			  $combinations[$index]['attributes']=$attributes;
		   }   
		}
		
		if(!is_array($combinations))$combinations=array();
		
		return $combinations;
	   	
    }
	
	public function updateProductMLData($data,$product_id){
	   
	   $this->db->query("UPDATE " . DB_PREFIX . "product SET mercaId = '" . $this->db->escape($data['mercaId']) . "', mercaTree = '" . $this->db->escape($data['mercaTree']) . "', mercaCurrency = '" . $this->db->escape($data['mercaCurrency']) . "', mercaBuyMode = '" . $this->db->escape($data['mercaBuyMode']) . "', mercaListType = '" . $this->db->escape($data['mercaListType']) . "', mercaCondition = '" . $this->db->escape($data['mercaCondition']) . "', mercaWarranty = '" . $this->db->escape($data['mercaWarranty']) . "', mercaVideoId = '" . $this->db->escape($data['mercaVideoId']) . "' WHERE product_id = '" . (int)$product_id . "'");
	   	
	}
	public function addMLProductAttribute($attributes,$product_id){
	   $insertedId=array(); 
	  
	    if(is_array($attributes)){
		     $attributes['quantity']=(isset($attributes['quantity']) && is_array($attributes['quantity']))?$attributes['quantity']:array();
		     foreach($attributes['quantity'] as $index=>$quantity){
	               $attr_image=array();
	               
				    $price=$attributes['price'][$index]; 
	               $picture=$attributes['picture'][$index];
				    $combinationId=$attributes['combinationId'][$index];
				   
				    if($combinationId){
					  
					  $this->db->query("UPDATE " . DB_PREFIX . "mercadolivre_attr_combination SET product_id = '" . (int)$product_id . "', quantity = '" . (int)$quantity . "', picture = '" . $this->db->escape($picture) . "', price = '" . (float)$price . "' WHERE id='".(int)$combinationId."'");
					  $insertedId[]=$combinationId;
					  continue;
					  	
				    }else{ 
					  $this->db->query("INSERT INTO " . DB_PREFIX . "mercadolivre_attr_combination SET product_id = '" . (int)$product_id . "', quantity = '" . (int)$quantity . "', picture = '" . $this->db->escape($picture) . "', price = '" . (float)$price . "'");
					  }

			         $combinationId = $this->db->getLastId();
					  $insertedId[]=$combinationId;
	               
	                foreach($attributes['name'] as $attributeId=>$attr_values){ 
					   
					   $attributeValueId=$attr_values[$index];
					   
					   if(strpos($attributeValueId,'~')===false){ /* If it is string or number type, then both id and value same*/
						   $attributeValue=$attributeValueId; 
						}else {
					      list($attributeValueId,$attributeValue)=explode('~',$attributeValueId);
						}
					   
	                  if($attributeId && $attributeValueId && $attributeValue){
						   $this->db->query("INSERT INTO " . DB_PREFIX . "mercadolivre_attribute SET combinationId = '" . (int)$combinationId . "', attributeId = '" . $this->db->escape($attributeId) . "', attributeValueId = '" . $this->db->escape($attributeValueId) . "', attributeValue = '" . $this->db->escape($attributeValue) . "'");  
						}
	               }
	        }   
	   }
	   
	  
	   if($insertedId){
          $this->db->query("DELETE FROM " . DB_PREFIX . "mercadolivre_attr_combination WHERE product_id='".(int)$product_id."' and id NOT IN (".implode(',',$insertedId).")");
       }else{
		   /* $insertedId is blank means there is no option there */
		  $this->db->query("DELETE FROM " . DB_PREFIX . "mercadolivre_attr_combination WHERE product_id='".(int)$product_id."'");   
	   }          
	   
	   
    }
	
	/* Opencart Add Order Funciton from catalog/checkout/order.php. Simply copy from there. Actually We don't want to call model here*/
	protected function addOrder($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "', store_url = '" . $this->db->escape($data['store_url']) . "', customer_id = '" . (int)$data['customer_id'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', payment_company_id = '" . $this->db->escape($data['payment_company_id']) . "', payment_tax_id = '" . $this->db->escape($data['payment_tax_id']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($data['payment_country']) . "', payment_country_id = '" . (int)$data['payment_country_id'] . "', payment_zone = '" . $this->db->escape($data['payment_zone']) . "', payment_zone_id = '" . (int)$data['payment_zone_id'] . "', payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', payment_code = '" . $this->db->escape($data['payment_code']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($data['shipping_country']) . "', shipping_country_id = '" . (int)$data['shipping_country_id'] . "', shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "', shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', shipping_method = '" . $this->db->escape($data['shipping_method']) . "', shipping_code = '" . $this->db->escape($data['shipping_code']) . "', comment = '" . $this->db->escape($data['comment']) . "', total = '" . (float)$data['total'] . "', affiliate_id = '" . (int)$data['affiliate_id'] . "', commission = '" . (float)$data['commission'] . "', language_id = '" . (int)$data['language_id'] . "', currency_id = '" . (int)$data['currency_id'] . "', currency_code = '" . $this->db->escape($data['currency_code']) . "', currency_value = '" . (float)$data['currency_value'] . "', ip = '" . $this->db->escape($data['ip']) . "', forwarded_ip = '" .  $this->db->escape($data['forwarded_ip']) . "', user_agent = '" . $this->db->escape($data['user_agent']) . "', accept_language = '" . $this->db->escape($data['accept_language']) . "', date_added = NOW(), date_modified = NOW()");

		$order_id = $this->db->getLastId();

		foreach ($data['products'] as $product) { 
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax'] . "', reward = '" . (int)$product['reward'] . "'");

			$order_product_id = $this->db->getLastId();

			foreach ($product['option'] as $option) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");
			}

			foreach ($product['download'] as $download) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_download SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', name = '" . $this->db->escape($download['name']) . "', filename = '" . $this->db->escape($download['filename']) . "', mask = '" . $this->db->escape($download['mask']) . "', remaining = '" . (int)($download['remaining'] * $product['quantity']) . "'");
			}	
		}

		foreach ($data['vouchers'] as $voucher) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_voucher SET order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($voucher['description']) . "', code = '" . $this->db->escape($voucher['code']) . "', from_name = '" . $this->db->escape($voucher['from_name']) . "', from_email = '" . $this->db->escape($voucher['from_email']) . "', to_name = '" . $this->db->escape($voucher['to_name']) . "', to_email = '" . $this->db->escape($voucher['to_email']) . "', voucher_theme_id = '" . (int)$voucher['voucher_theme_id'] . "', message = '" . $this->db->escape($voucher['message']) . "', amount = '" . (float)$voucher['amount'] . "'");
		}

		foreach ($data['totals'] as $total) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', text = '" . $this->db->escape($total['text']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
		}	

		return $order_id;
	}
	
	
	
}