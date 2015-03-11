<?php
class ModelMercadolivreMercadolivre extends Model
{    
    
    public function getMercadoCategory(){
	   
	   return $this->db->query("SELECT * FROM `".DB_PREFIX."mercadolivre_category` WHERE 1 order by name asc")->rows;
	}
	
	public function getMercadoStatus(){
	   
	    $return =array();
	    $rows=$this->db->query("SELECT * FROM `".DB_PREFIX."mercadolivre_status` WHERE 1 order by id asc")->rows;
		if($rows)
		{
		   foreach($rows as $row)
		   {
		     $return[$row['merca_status']]=$row['oc_status'];
		   }
		}
		else
		{
		    $return =array('confirmed'=>'','payment_required'=>'','payment_in_process'=>'','paid'=>'','cancelled'=>'');   
		}
		
		return $return;
	}
	
	 public function getMercadoCategoryOption($sel=''){
	   
	   $parents=$this->db->query("SELECT * FROM `".DB_PREFIX."mercadolivre_category` WHERE 1 order by name asc")->rows;
	   $option='';
	   foreach($parents as $single)
	   {
	      
			$chk='';
			if($single['mercaId']==$sel)$chk='selected';
			$option.='<option value="'.$single['mercaId'].'" '.$chk.' >'.$single['name'].'</option>';
		
	   }
	  return $option; 
	}
	
	public function getMercadoMode()
	{
	  return array(array('name'=>'Buy it now','value'=>'buy_it_now'),array('name'=>'Classified','value'=>'classified'),array('name'=>'Auction','value'=>'auction'));
	}
	
	public function getMercadoType()
	{
	  
	  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "mercadolivre_listing_type ORDER BY code ASC");
	        $type_data=array();
			foreach ($query->rows as $result) {
      			$type_data[] = array(
        			'name'         => $result['name'],
        			'value'          => $result['code']
      			);
    		}
			
	   return $type_data;	
	}
	
	public function getMercadoCondition()
	{
	  return array(array('name'=>'New','value'=>'new'),array('name'=>'Used','value'=>'used'));
	}
	
	public function getMercadoCurrency()
	{
	      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency ORDER BY title ASC");
	        $currency_data=array();
			foreach ($query->rows as $result) {
      			$currency_data[$result['code']] = array(
        			'name'         => $result['title'],
        			'value'          => $result['code']
      			);
    		}
			
	   return $currency_data;		
	}
	
	
	public function desynchronizeProduct($product_id)
	{
	   $product_info=$this->db->query("SELECT * FROM " . DB_PREFIX . "mercadolivre_product WHERE product_id = '" . (int) $product_id. "'")->row; 
	   
	   if($product_info){
		   $this->mercadolivre->delete($product_info['mercaId']);
	   	   $this->db->query("DELETE FROM " . DB_PREFIX . "mercadolivre_product WHERE product_id = '" . (int) $product_id. "'");
		    
	   }
	   return true; 
	}
	
	public function synchronizeProduct($product_id, $updateOnly=false)
	{
	   if(empty($product_id)) return false;
	   
	   $this->load->model('catalog/product');
	   
	   $product=$this->model_catalog_product->getProduct($product_id); 
	   $product_images = $this->model_catalog_product->getProductImages($product_id); 
	   
	   $lang_code=$this->config->get('config_language');
	   $language_id=$this->db->query("select language_id from `".DB_PREFIX."language` where code='$lang_code'")->row['language_id'];
	   
	  
	   
	   if(empty($product['mercaId']))$product['mercaId']=$this->config->get('mercadolivre_mercaId');
	   if(empty($product['mercaCurrency']))$product['mercaCurrency']=$this->config->get('mercadolivre_mercaCurrency');
	   if(empty($product['mercaBuyMode']))$product['mercaBuyMode']=$this->config->get('mercadolivre_mercaBuyMode');
	   if(empty($product['mercaListType']))$product['mercaListType']=$this->config->get('mercadolivre_mercaListType');
	   if(empty($product['mercaCondition']))$product['mercaCondition']=$this->config->get('mercadolivre_mercaCondition');
	   if(empty($product['mercaWarranty']))$product['mercaWarranty']=$this->config->get('mercadolivre_mercaWarranty');
	   
	   
	   $mercadolivre_template=$this->config->get('mercadolivre_template');
	   $mercadolivre_mercaPrice=$this->config->get('mercadolivre_mercaPrice');
	   
	  
	   $added_images=array();
	   $list_images=array();
	   if ($product['image']) {
	      $list_images[]=array('source'=>$this->url_encode(HTTP_CATALOG.'image/'.$product['image']));
		  $added_images[]=$product['image'];
	   }
	   
	   foreach ($product_images as $product_image) {
		  if(!in_array($product_image['image'],$added_images)){ 
		   $list_images[]=array('source'=>$this->url_encode(HTTP_CATALOG.'image/'.$product_image['image']));
		   $added_images[]=$product_image['image'];
		  }
	   }
	   
	   
	
	   
	   /*fix special price issue*/
	   $customer_group_id = $this->config->get('config_customer_group_id');
	   $special_row=$this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '".$product_id."' AND customer_group_id = '" . (int)$customer_group_id . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1")->row;
	   if ($special_row && (float)$special_row['price']) {
				$product['price'] = $special_row['price'];
	    }
	   
	    /*Adjust price for ML*/
	    if(trim($mercadolivre_mercaPrice)){
	      if(substr(trim($mercadolivre_mercaPrice), -1)=='%'){
				     $percent=rtrim(trim($mercadolivre_mercaPrice),'%'); 
				     $adjust_price=(float)(($percent*$product['price'])/100);
				   }else{
				     $adjust_price=(float)$mercadolivre_mercaPrice;  
		    }
		   if($adjust_price){
		     $product['price']+=$adjust_price;
		   }  
		}   	
		
	  $mercaInfo=$this->mercadolivre->getMercadolivreIDs($product_id);	
	  
	  if($mercaInfo && $mercaInfo['status']=='closed'){
		  return false;  
	  }
		
	  /* Product ML Attributes */
	   $product_attributes=array();
	   
	   $combinations=$this->mercadolivre->getMLProductAttribute($product_id);
	   
	   if(is_array($combinations) && $combinations){
	           
	           foreach($combinations as $index=>$combination){
	               
				    $attr_image=array();
					
				    $quantity=(int)$combination['quantity']; 
	               $picture=$combination['picture'];
				    $price=($combination['price'])?$combination['price']:$product['price'];   
	               
	               if ($picture) {
	                  $attr_image[]=$this->url_encode(HTTP_CATALOG.'image/'.$picture); 
					    
						if(!in_array($picture,$added_images)){ 
						   $list_images[]=array('source'=>$this->url_encode(HTTP_CATALOG.'image/'.$picture));
						   $added_images[]=$picture;
						  }
						
	               }else{
	                  
	                  if ($product['image']) {
	                    $attr_image[]=$this->url_encode(HTTP_CATALOG.'image/'.$product['image']); 
	                  }
	               }
				   
	               $attribute_combinations=array();
	               foreach($combination['attributes'] as $attributeId=>$attributeValueId){ 
				   
	                        if($attributeId && $attributeValueId){
	                          $attribute_combinations[]=array('id'=>(string)$attributeId,'value_id'=>$attributeValueId);
	                        } 
	                }
	                 
	               
	               if($attribute_combinations){
					   
						if($combination['mercaId'] && $mercaInfo){
						  
						  $product_attributes[]=array(
						   'id'=>(float)$combination['mercaId'],
						   'available_quantity'=>(int)$quantity,
						   'price'=>(float)$this->currency->format($price, $product['mercaCurrency'], false, false)
						  );
						  	
					    }else { 
						  $product_attributes[]=array(
						   'attribute_combinations'=>$attribute_combinations,
						   'available_quantity'=>(int)$quantity,
						   'price'=>$this->currency->format($price, $product['mercaCurrency'], false, false),
						   'picture_ids'=>$attr_image
						  );
						}
	               }
	           }
	       }
	   
	  /* end ML attribute*/  
	  
	     /* Add image in proudct description if set to yes*/
		 
		 if($this->config->get('mercadolivre_image_in_desc')){
			  foreach($list_images as $single_img){
				 $product['description'].='<img src="'.$single_img['source'].'" border="0" /><br />';  
			  } 
		 }  
	  
	    /* Product template*/
	    
	    if(strpos($mercadolivre_template,'__CONTENT__')!==false){
	      $product['description']=str_replace('__CONTENT__',$product['description'],$mercadolivre_template);
	    }
	       
	   
	      
		  
		  /* Trim product title if it is greater than 60*/
		  if(strlen($product['name'])>60){
			 $product['name']=substr($product['name'],0,60);  
		  }
		  
		  
		
		  if($mercaInfo)
				{
				     $mercaId=$mercaInfo['mercaId'];
					  $param=array();
				     $param['title']=$product['name'];
					  $param['pictures']=$list_images;
					 
					 if($product_attributes){
				       $param['variations']=$product_attributes;
				     }else{
						 $param['price']=$this->currency->format($product['price'], $product['mercaCurrency'], false, false); 
					     $param['available_quantity']=(int)$product['quantity']; // if attribute exist, then main quantity is not updatable	 
				     }
					 
				    
				    $this->mercadolivre->updateProduct($param,$mercaId);
					if($this->mercadolivre->error==''){
					  $this->mercadolivre->updateMLAttributeIDs($mercaId,$product_id);
					}
				}
				elseif($updateOnly===false)
				{  
				   $param=array();
				   $param['title']=$product['name'];
				   $param['category_id']=$product['mercaId'];
				   $param['price']=$this->currency->format($product['price'], $product['mercaCurrency'], false, false);
				   $param['currency_id']=$product['mercaCurrency'];
				   $param['available_quantity']=(int)$product['quantity'];
				   $param['buying_mode']=$product['mercaBuyMode'];
				   $param['listing_type_id']=$product['mercaListType'];
				   $param['condition']=$product['mercaCondition'];
				   $param['description']=html_entity_decode($product['description']);
				   $param['pictures']=$list_images;
				   if($product_attributes){
				     $param['variations']=$product_attributes;
				   }
				   
				   if($product['mercaWarranty']){
				     $param['warranty']=$product['mercaWarranty'];
				   }
				   
				  if($product['mercaVideoId']){
				     $param['video_id']=$product['mercaVideoId'];
				   }
				   
				   $shipping_costs=$this->getCustomShipping();
				   if($shipping_costs && $this->mercadolivre->isShippingAllowed($product['mercaId'])){
				     $shipping=array();
				     $shipping['mode']='custom';
				     $shipping['methods']=array();
				     $shipping['costs']=$shipping_costs;
				     $param['shipping']=$shipping;
				   }
				   
				   //$this->mercadolivre->dump=true;
				      
				   $mercaId=$this->mercadolivre->addProduct($param);
				  
				   if(!empty($mercaId))
				   {
				     $option='';
				     $this->db->query("INSERT INTO " . DB_PREFIX . "mercadolivre_product SET product_id = '" . (int) $product_id. "', `mercaId` = '" . $this->db->escape($mercaId) . "'");  
					  $this->mercadolivre->updateMLAttributeIDs($mercaId,$product_id);
				   }
				   
			}
	  
	  if($this->mercadolivre->error!='')
	  {
	    $this->session->data['error_warning'] ='API Error:'.$this->mercadolivre->error;
	  }
	   
	}
	
	public function getCustomShipping(){
	   $shipping_costs=array();
	   for($i=1;$i<=5;$i++)
			{
				
				if($this->config->get('mercadolivre_shipping_name'.$i)) {
				   $shipping_costs[]=array('description'=>$this->config->get('mercadolivre_shipping_name'.$i),'cost'=>(float)$this->config->get('mercadolivre_shipping_cost'.$i));
				}
		    }		
	   return $shipping_costs;
	}
	
	public function install(){
        
        $this->log->write('MERCADOLIVRE Module --> Starting install');
		
		$this->db->query("INSERT INTO `".DB_PREFIX."url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'mercadolivre=mercadolivre', 'mercadolivre_auth')");
		$this->db->query("INSERT INTO `".DB_PREFIX."url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'mercadolivre=mercadolivre/callback', 'mercadolivre_callback')");
		
		$this->db->query("ALTER TABLE `".DB_PREFIX."product` ADD `mercaId` varchar(200) NULL, ADD `mercaCurrency` VARCHAR( 50 ) NULL , ADD `mercaBuyMode` VARCHAR( 50 ) NULL , ADD `mercaListType` VARCHAR( 50 ) NULL , ADD `mercaCondition` VARCHAR( 50 ) NULL, ADD `mercaTree` VARCHAR( 240 ) NULL, ADD `mercaWarranty` VARCHAR( 240 ) NULL, ADD `mercaVideoId` VARCHAR( 100 ) NULL, ADD `mercaShipping` TEXT NULL");
        
        $sql = "
            CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mercadolivre_product` (
              `id` bigint(11) NOT NULL AUTO_INCREMENT,
              `product_id` bigint(15) NOT NULL,
			  `mercaId` varchar(240) NOT NULL,
              `option` varchar(240) NULL,
			  `status` varchar(240) NOT NULL,
			  `substatus` varchar(240) NOT NULL,
			  `url` varchar(240) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);
        $this->log->write('MERCADOLIVRE Module --> Created '.DB_PREFIX.'mercadolivre_product table'); 
		
		
		 $sql = "
            CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mercadolivre_category` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
			  `mercaId` varchar(200) NOT NULL,
              `name` varchar(240) NOT NULL,
               PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);
        $this->log->write('MERCADOLIVRE Module --> Created '.DB_PREFIX.'mercadolivre_category table'); 
		
		
		$sql = "
            CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mercadolivre_status` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
			  `merca_status` varchar(200) NULL,
              `oc_status` int(11) NULL,
               PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);
        $this->log->write('MERCADOLIVRE Module --> Created '.DB_PREFIX.'mercadolivre_status table'); 
        
        
        $sql = "
            CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mercadolivre_listing_type` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
			  `code` varchar(100) NULL,
              `name` varchar(100) NULL,
               PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);
        $this->log->write('MERCADOLIVRE Module --> Created '.DB_PREFIX.'mercadolivre_listing_type table'); 
		
		
		$sql = "
            CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mercadolivre_order` (
              `id` bigint(11) NOT NULL AUTO_INCREMENT,
			    `mercaOrderId` varchar(200) NOT NULL,
              `order_id` bigint(11) NOT NULL,
              `feedback` int(1) NOT NULL,
			    `stopSync` int(1) NOT NULL,
               PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);
        $this->log->write('MERCADOLIVRE Module --> Created '.DB_PREFIX.'mercadolivre_order table'); 
		
		$sql = "
            CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mercadolivre_attr_combination` (
              `id` bigint(11) NOT NULL AUTO_INCREMENT,
			    `mercaId` varchar(200) NOT NULL,
				 `product_id` bigint(15) NOT NULL,
               `quantity` int(8) NOT NULL,
               `price` decimal(8,2) NOT NULL,
			    `picture` varchar(200) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);
        $this->log->write('MERCADOLIVRE Module --> Created '.DB_PREFIX.'mercadolivre_attr_combination table');     
		$sql = "
            CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mercadolivre_attribute` (
               `id` bigint(11) NOT NULL AUTO_INCREMENT,
			    `combinationId` int(8) NOT NULL,
			    `attributeId` varchar(200) NOT NULL,
               `attributeValueId` varchar(200) NOT NULL,
			    `attributeValue` varchar(200) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);
        $this->log->write('MERCADOLIVRE Module --> Created '.DB_PREFIX.'mercadolivre_attribute table'); 
		
		$sql = "
            CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mercadolivre_api_call` (
              `id` bigint(11) NOT NULL AUTO_INCREMENT,
			   `callId` varchar(200) NOT NULL,
              `callType` varchar(50) NOT NULL,
			   `dateTime` DATETIME NOT NULL,
			   `done` int(1) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);
        $this->log->write('MERCADOLIVRE Module --> Created '.DB_PREFIX.'mercadolivre_api_call table');
		    
        $this->log->write('MERCADOLIVRE Module --> Completed install');
    }
    
    public function uninstall(){
        
         $this->log->write('MERCADOLIVRE Module --> Starting uninstall');
		 $this->db->query("DELETE FROM `".DB_PREFIX."url_alias` where `query` like 'mercadolivre=%'");
        
         $this->safeColumnDrop('product',array('mercaId','mercaCurrency','mercaBuyMode','mercaListType','mercaCondition','mercaTree','mercaWarranty','mercaVideoId','mercaShipping'));
         $this->log->write('MERCADOLIVRE Module --> Altered '.DB_PREFIX.'product table'); 
        
         $query = $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."mercadolivre_product`");
         $this->log->write('MERCADOLIVRE Module --> Dropped '.DB_PREFIX.'mercadolivre_product table'); 
		 
		 $query = $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."mercadolivre_category`");
         $this->log->write('MERCADOLIVRE Module --> Dropped '.DB_PREFIX.'mercadolivre_category table'); 
		 
		 $query = $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."mercadolivre_order`");
         $this->log->write('MERCADOLIVRE Module --> Dropped '.DB_PREFIX.'mercadolivre_order table'); 
		 
		  $query = $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."mercadolivre_status`");
         $this->log->write('MERCADOLIVRE Module --> Dropped '.DB_PREFIX.'mercadolivre_status table'); 
         
         $query = $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."mercadolivre_listing_type`");
         $this->log->write('MERCADOLIVRE Module --> Dropped '.DB_PREFIX.'mercadolivre_listing_type table');
		 
		  $query = $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."mercadolivre_api_call`");
         $this->log->write('MERCADOLIVRE Module --> Dropped '.DB_PREFIX.'mercadolivre_api_call table');
		 
		 $query = $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."mercadolivre_attr_combination`");
         $this->log->write('MERCADOLIVRE Module --> Dropped '.DB_PREFIX.'mercadolivre_attr_combination table');
		 
		 $query = $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."mercadolivre_attribute`");
         $this->log->write('MERCADOLIVRE Module --> Dropped '.DB_PREFIX.'mercadolivre_attribute table');
 
        $this->log->write('MERCADOLIVRE Module --> Completed uninstall');
    }
    
    public function upgrade(){
       
		$this->safeColumnAdd('product',array(
		                                 array('column'=>'mercaId','extra'=>'varchar(200) NULL'),
									        array('column'=>'mercaCurrency','extra'=>'VARCHAR( 50 ) NULL'),
										    array('column'=>'mercaBuyMode','extra'=>'VARCHAR( 50 ) NULL'),
										    array('column'=>'mercaListType','extra'=>'VARCHAR( 50 ) NULL'),
										    array('column'=>'mercaCondition','extra'=>'varchar(50) NULL'),
										    array('column'=>'mercaTree','extra'=>'varchar(240) NULL'),
										    array('column'=>'mercaWarranty','extra'=>'varchar(240) NULL'),
										    array('column'=>'mercaVideoId','extra'=>'varchar(100) NULL'),
										    array('column'=>'mercaShipping','extra'=>'TEXT NULL')
										  )	
										);
		
        $sql = "
            CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mercadolivre_product` (
              `id` bigint(11) NOT NULL AUTO_INCREMENT,
              `product_id` bigint(15) NOT NULL,
			  `mercaId` varchar(240) NOT NULL,
              `option` varchar(240) NULL,
			  `status` varchar(240) NOT NULL,
			  `substatus` varchar(240) NOT NULL,
			  `url` varchar(240) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);
       
		 $sql = "
            CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mercadolivre_category` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
			  `mercaId` varchar(200) NOT NULL,
              `name` varchar(240) NOT NULL,
               PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);
        
		$sql = "
            CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mercadolivre_status` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
			  `merca_status` varchar(200) NULL,
              `oc_status` int(11) NULL,
               PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);
       
        $sql = "
            CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mercadolivre_listing_type` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
			  `code` varchar(100) NULL,
              `name` varchar(100) NULL,
               PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);
       
		$sql = "
            CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mercadolivre_order` (
              `id` bigint(11) NOT NULL AUTO_INCREMENT,
			  `mercaOrderId` varchar(200) NOT NULL,
              `order_id` bigint(11) NOT NULL,
              `feedback` int(1) NOT NULL,
			   `stopSync` int(1) NOT NULL,
               PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);
		
		$sql = "
            CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mercadolivre_api_call` (
              `id` bigint(11) NOT NULL AUTO_INCREMENT,
			   `callId` varchar(200) NOT NULL,
              `callType` varchar(50) NOT NULL,
			   `dateTime` DATETIME NOT NULL,
			   `done` int(1) NOT NULL,
               PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);
		
		$sql = "
            CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mercadolivre_attr_combination` (
              `id` bigint(11) NOT NULL AUTO_INCREMENT,
			    `mercaId` varchar(200) NOT NULL,
				 `product_id` bigint(15) NOT NULL,
               `quantity` int(8) NOT NULL,
               `price` decimal(8,2) NOT NULL,
			    `picture` varchar(200) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);
        $this->log->write('MERCADOLIVRE Module --> Created '.DB_PREFIX.'mercadolivre_attr_combination table');     
		$sql = "
            CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mercadolivre_attribute` (
              `id` bigint(11) NOT NULL AUTO_INCREMENT,
			    `combinationId` int(8) NOT NULL,
			    `attributeId` varchar(200) NOT NULL,
               `attributeValueId` varchar(200) NOT NULL,
			    `attributeValue` varchar(200) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        $query = $this->db->query($sql);
        $this->log->write('MERCADOLIVRE Module --> Created '.DB_PREFIX.'mercadolivre_attribute table'); 
		
		$this->safeColumnAdd('mercadolivre_order',array(
										    array('column'=>'stopSync','extra'=>'int(1) NOT NULL'),
											array('column'=>'feedback','extra'=>'int(1) NOT NULL')
										  )	
							  );
		
		/* Check seo url . Insert if not found*/
		$url_rows = $this->db->query("SELECT * FROM `".DB_PREFIX."url_alias` WHERE `query` like '%mercadolivre%'")->rows;
		if(!$url_rows){
			$this->db->query("INSERT INTO `".DB_PREFIX."url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'mercadolivre=mercadolivre', 'mercadolivre_auth')");
			$this->db->query("INSERT INTO `".DB_PREFIX."url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'mercadolivre=mercadolivre/callback', 'mercadolivre_callback')");
		}
	
    }
    
	

	public function url_encode($url) {
		$url=str_replace('https','http',$url);
		$reserved = array(
			":" => '!%3A!ui',
			"/" => '!%2F!ui',
			"?" => '!%3F!ui',
			"#" => '!%23!ui',
			"[" => '!%5B!ui',
			"]" => '!%5D!ui',
			"@" => '!%40!ui',
			"!" => '!%21!ui',
			"$" => '!%24!ui',
			"&" => '!%26!ui',
			"'" => '!%27!ui',
			"(" => '!%28!ui',
			")" => '!%29!ui',
			"*" => '!%2A!ui',
			"+" => '!%2B!ui',
			"," => '!%2C!ui',
			";" => '!%3B!ui',
			"=" => '!%3D!ui',
			"%" => '!%25!ui',
		);
	
	   $url = rawurlencode($url);
	   $url = preg_replace(array_values($reserved), array_keys($reserved), $url);
	   return $url;
	}
	
	public function isDBBUPdateAvail(){
		  
	      $tables=array('mercadolivre_product','mercadolivre_category','mercadolivre_status','mercadolivre_listing_type','mercadolivre_order','mercadolivre_api_call','mercadolivre_attr_combination','mercadolivre_attribute');
		  $product_columns=array('mercaId','mercaCurrency','mercaBuyMode','mercaListType','mercaCondition','mercaTree','mercaWarranty','mercaVideoId','mercaShipping');
		  $ml_order_columns=array('stopSync','feedback');
		  
		  foreach($tables as $table){
			  if(!$this->db->query("SELECT * FROM information_schema.tables WHERE table_schema = '".DB_DATABASE."' AND table_name = '".DB_PREFIX.$table."' LIMIT 1")->row){
				   return true;
			  }
		  }
		  
		  foreach($product_columns as $column){
			 if(!$this->db->query("SELECT * FROM information_schema.columns WHERE table_schema = '".DB_DATABASE."' AND table_name = '".DB_PREFIX."product' and column_name='".$column."' LIMIT 1")->row){
				   return true;
			  }
		  }
		  
		  foreach($ml_order_columns as $column){
			 if(!$this->db->query("SELECT * FROM information_schema.columns WHERE table_schema = '".DB_DATABASE."' AND table_name = '".DB_PREFIX."mercadolivre_order' and column_name='".$column."' LIMIT 1")->row){
				   return true;
			  }
		  }
		  
		  return false;
	}
	
	private function safeColumnDrop($table,$columns){
	   if(!is_array($columns))$columns=array();
	   
	   if($table){
	     foreach($columns as $column){
	     	if($this->db->query("SELECT * FROM information_schema.columns WHERE table_schema = '".DB_DATABASE."' AND table_name = '".DB_PREFIX.$table."' and column_name='".$column."' LIMIT 1")->row){
	          $query = $this->db->query("ALTER TABLE `".DB_PREFIX.$table."` DROP `".$column."`"); 
	     	}
	     }
	   }
	}
	
	private function safeColumnAdd($table,$columns){
	   if(!is_array($columns))$columns=array();
	   
	   if($table){
	     foreach($columns as $columnInfo){
			 $column=$columnInfo['column'];
			 $extra=$columnInfo['extra'];
	     	if(!$this->db->query("SELECT * FROM information_schema.columns WHERE table_schema = '".DB_DATABASE."' AND table_name = '".DB_PREFIX.$table."' and column_name='".$column."' LIMIT 1")->row){
	          $query = $this->db->query("ALTER TABLE `".DB_PREFIX.$table."` ADD `".$column."` ".$extra); 
	     	}
	     }
	   }
	}

}