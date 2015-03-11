<?php echo $header; ?> 

<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
       <div id="tabs" class="htabs"><a href="#tab-setting"><?php echo $tab_setting; ?></a><a href="#tab-listing"><?php echo $tab_listing; ?></a><a href="#tab-order"><?php echo $tab_order; ?></a><a href="#tab-feedback">Feedback Setting</a><a href="#tab-shipping"><?php echo $tab_shipping; ?></a><a href="#tab-template"><?php echo $tab_template; ?></a></div>  
       <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
	   <div id="tab-setting">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $text_app_id; ?></td>
            <td><input type="text" name="mercadolivre_app_id" value="<?php echo $mercadolivre_app_id; ?>" />
              <?php if ($error_app_id) { ?>
              <span class="error"><?php echo $error_app_id; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $text_app_secret; ?></td>
            <td><input type="text" name="mercadolivre_app_secret" value="<?php echo $mercadolivre_app_secret; ?>" />
              <?php if ($error_app_secret) { ?>
              <span class="error"><?php echo $error_app_secret; ?></span>
              <?php } ?></td>
          </tr>
         <tr>
            <td><?php echo $debug_status; ?></td>
            <td><select name="mercadolivre_debug">
                <?php if ($mercadolivre_debug) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $text_status; ?></td>
            <td><select name="mercadolivre_status">
                <?php if ($mercadolivre_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
        </table>
		</div>
		<div id="tab-listing">
		<p><?php echo $listing_default;?><p/>
                <table class="form">
						 <tr>
							 <td><?php echo $entry_mercadolivre_category; ?><br /><?php echo $ml_text_category_hint;?></td>
							  <td>
							   <input type="hidden" name="mercadolivre_category_tree" value="<?php echo $mercadolivre_category_tree?>" id="mercadolivre_category_tree" />
							   <input type="hidden" name="mercadolivre_mercaId" value="<?php echo $mercadolivre_mercaId?>" id="mercadolivre_mercaId" />
							   <span id="category_tree_span" class="category_ok">
							     <?php echo html_entity_decode($mercadolivre_category_tree)?>
							   </span>
								<select name="mercadolivre_cat_selection[]" class="mercadolivre_cat_selection">
								   <option value="">-Select-</option>
									<?php echo $mercadolivre_cats?>
								</select>
							  </td>
						  </tr>
						 <tr>
							 <td><?php echo $entry_mercadolivre_currency; ?></td>
							  <td>
								<select name="mercadolivre_mercaCurrency" id="mercadolivre_mercaCurrency">
									<?php foreach ($mercadolivre_currency as $mercadolivre_cur) { $chk=''; if($mercadolivre_mercaCurrency==$mercadolivre_cur['value']) $chk='selected'; ?>
									  <option value="<?php echo $mercadolivre_cur['value']?>" <?php echo $chk; ?> ><?php echo $mercadolivre_cur['name']?></option>
									<?php } ?>
								</select>
							  </td>
						  </tr>
						  <tr>
							 <td><?php echo $entry_mercadolivre_buying_mode; ?></td>
							  <td>
								<select name="mercadolivre_mercaBuyMode" id="mercadolivre_mercaBuyMode">
									<?php foreach ($mercadolivre_modes as $mercadolivre_mode) { $chk=''; if($mercadolivre_mercaBuyMode==$mercadolivre_mode['value']) $chk='selected'; ?>
									  <option value="<?php echo $mercadolivre_mode['value']?>" <?php echo $chk; ?> ><?php echo $mercadolivre_mode['name']?></option>
									<?php } ?>
								</select>
							  </td>
						  </tr>
						  <tr>
							 <td><?php echo $entry_mercadolivre_listing_type; ?></td>
							  <td>
								<select name="mercadolivre_mercaListType" id="mercadolivre_mercaListType">
									<?php foreach ($mercadolivre_types as $mercadolivre_type) { $chk=''; if($mercadolivre_mercaListType==$mercadolivre_type['value']) $chk='selected'; ?>
									  <option value="<?php echo $mercadolivre_type['value']?>" <?php echo $chk; ?> ><?php echo $mercadolivre_type['name']?></option>
									<?php } ?>
								</select>
							  </td>
						  </tr>
						  <tr>
							 <td><?php echo $entry_mercadolivre_condition; ?></td>
							  <td>
								<select name="mercadolivre_mercaCondition" id="mercadolivre_mercaCondition">
									<?php foreach ($mercadolivre_conditions as $mercadolivre_cond) { $chk=''; if($mercadolivre_mercaCondition==$mercadolivre_cond['value']) $chk='selected'; ?>
									  <option value="<?php echo $mercadolivre_cond['value']?>" <?php echo $chk; ?> ><?php echo $mercadolivre_cond['name']?></option>
									<?php } ?>
								</select>
							  </td>
						  </tr>
						  <tr>
							 <td><?php echo $entry_mercadolivre_price_adjustment; ?></td>
							  <td>
								 <input type="text" name="mercadolivre_mercaPrice" value="<?php echo $mercadolivre_mercaPrice; ?>" size="15" />
							  </td>
						  </tr>
						  <tr>
							 <td><?php echo $entry_mercadolivre_warranty ?></td>
							  <td>
								 <input type="text" name="mercadolivre_mercaWarranty" value="<?php echo $mercadolivre_mercaWarranty; ?>" size="30" />
							  </td>
						  </tr>
                           <tr>
                        <td><?php echo $text_add_images_in_desc; ?></td>
                        <td><select name="mercadolivre_image_in_desc">
                            <?php if ($mercadolivre_image_in_desc) { ?>
                            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                            <option value="0"><?php echo $text_no; ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $text_yes; ?></option>
                            <option value="0" selected="selected"><?php echo $text_no; ?></option>
                            <?php } ?>
                          </select></td>
                      </tr>
					  </table>	
				</div>
				<div id="tab-order">
                 <p><?php echo $order_status_hints;?></p>
                <table class="list list-tbl">
                     <thead>
						 <tr>
							 <td><?php echo $text_ml_status; ?></td>
							  <td align="left">
								<?php echo $text_oc_status; ?>
							  </td>
						  </tr>
                      </thead>       
						  <?php foreach($merca_statuses as $status=>$oc_status){?>
						  <tr>
							 <td><?php echo array_key_exists($status,$ml_order_status)?$ml_order_status[$status]:$status; ?><input type="hidden" name="merca_status[]" value="<?php echo $status; ?>" /></td>
							  <td>
								<select name="oc_status[]">
									<?php foreach ($order_statuses as $order_status) { ?>
										<?php if ($order_status['order_status_id'] == $oc_status) { ?>
										<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
										<?php } ?>
										<?php } ?>
								</select>
							  </td>
						  </tr>
						  <?php } ?>
						 
					  </table>	 
                      <table class="form">
                     <tr>
                        <td><?php echo $lang_new_user; ?></td>
                        <td><select name="mercadolivre_new_customer">
                            <?php if ($mercadolivre_new_customer) { ?>
                            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                            <option value="0"><?php echo $text_no; ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $text_yes; ?></option>
                            <option value="0" selected="selected"><?php echo $text_no; ?></option>
                            <?php } ?>
                          </select></td>
                      </tr>
                      <tr>
                        <td><?php echo $text_shipping_method; ?></td>
                        <td><select name="mercadolivre_shipping">
                            <?php foreach($shipping_mods as $code=>$title){ 
                               $selected=($code==$mercadolivre_shipping)?'selected="selected"':'';
                            ?>
                              <option value="<?php echo $code;?>" <?php echo $selected;?> ><?php echo $title; ?></option>
                            <?php } ?>
                          </select></td>
                      </tr>
                      <tr>
                        <td><?php echo $text_payment_method; ?></td>
                        <td><select name="mercadolivre_payment">
                            <?php foreach($payment_mods as $code=>$title){ 
                               $selected=($code==$mercadolivre_payment)?'selected="selected"':'';
                            ?>
                              <option value="<?php echo $code;?>" <?php echo $selected;?> ><?php echo $title; ?></option>
                            <?php } ?>
                          </select></td>
                      </tr>
                     </table>	 
				</div>
				<div id="tab-feedback">
                <table class="form">
						<tr>
                         <td><?php echo $lang_auto_feedback?></td>
                          <td><select name="mercadolivre_feedback">
                            <?php if ($mercadolivre_feedback) { ?>
                            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                            <option value="0"><?php echo $text_disabled; ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $text_enabled; ?></option>
                            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                           <?php } ?>
                        </select></td>
                   </tr>
                   <tr>
                         <td><?php echo $lang_auto_feedback_status?></td>
                          <td>
                           
                          <select name="mercadolivre_feedback_order">
                          <?php foreach($merca_statuses as $status=>$oc_status){?>
                                 <?php if ($mercadolivre_feedback_order == $status) { ?>
										<option value="<?php echo $status; ?>" selected="selected"><?php echo array_key_exists($status,$ml_order_status)?$ml_order_status[$status]:$status; ?></option>
										<?php } else { ?>
										<option value="<?php echo $status; ?>"><?php echo array_key_exists($status,$ml_order_status)?$ml_order_status[$status]:$status; ?></option>
										<?php } ?>
                           <?php } ?>
                        </select></td>
                   </tr>
                   <tr>
                         <td><?php echo $lang_feedback_rating?></td>
                          <td>
                           
                          <select name="mercadolivre_feedback_rating">
                              <option value="positive" <?php if(isset($mercadolivre_feedback_rating) && $mercadolivre_feedback_rating=='positive') {?> selected="selected" <?php }?>>Positive</option>
                              <option value="negative" <?php if(isset($mercadolivre_feedback_rating) && $mercadolivre_feedback_rating=='negative') {?> selected="selected" <?php }?>>Negative</option>
                              <option value="neutral" <?php if(isset($mercadolivre_feedback_rating) && $mercadolivre_feedback_rating=='neutral') {?> selected="selected" <?php }?>>Neutral</option>
                        </select></td>
                   </tr>
                   <tr>
                         <td><?php echo $lang_feedback_message?></td>
                          <td>
                           <textarea id="mercadolivre_feedback_message" name="mercadolivre_feedback_message" cols="80" rows="8"><?php echo isset($mercadolivre_feedback_message) ? $mercadolivre_feedback_message : ''; ?></textarea></td>
                   </tr>
                  
					  </table>	
				</div>
				<div id="tab-shipping">
				<table class="list"> 
				  <thead>
				    <tr>
				      <td class="left"><?php echo $lang_shipping_name?></td>
				      <td class="left"><?php echo $lang_shipping_cost?></td>
				    </tr>
				  </thead>
				  <tbody>
				    <?php
				     for($i=1;$i<=5;$i++){
		           ?>
				         <tr>
							 <td class="left"> <input type="text" name="mercadolivre_shipping_name<?php echo $i;?>" value="<?php echo ${'mercadolivre_shipping_name'.$i}; ?>" size="30" /></td>
				             <td class="left"> <input type="text" name="mercadolivre_shipping_cost<?php echo $i;?>" value="<?php echo ${'mercadolivre_shipping_cost'.$i}; ?>" size="30" /></td>
						  </tr>
					  <?php } ?>	  
					</tbody>	  
				    </table>		  
				</div>
				<div id="tab-template">
				<table class="form"> 
				   <tr>
							 <td><?php echo $entry_mercadolivre_template; ?></td>
							  <td>
								 <textarea id="mercadolivre_template" name="mercadolivre_template" cols="40" rows="5"><?php echo isset($mercadolivre_template) ? $mercadolivre_template : ''; ?></textarea>
							  </td>
						  </tr>
				    </table>		  
				</div>
         </form>
           
        </div>
  </div>
</div>
<style type="text/css">
#category_tree_span{
  
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
}
.category_ok{color:green;}
.category_nok{color:red;}
.list-tbl td{padding-top:6px !important;padding-bottom:6px !important;}
</style>
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#languages a').tabs(); 
$('#vtab-option a').tabs();

$('.mercadolivre_cat_selection').live('change',function(){

    var $this=$(this);
	if($this.val()=='') return false;
	
	$('#mercadolivre_mercaId').val($this.val());
	
	$.ajax({
			url: 'index.php?route=module/mercadolivre/category&token=<?php echo $token; ?>',
			dataType: 'json',
			data:{catId:$this.val()},
			beforeSend:function()
			{
			  $('body').css('cursor','wait');
			},
			success: function(result) {
			  $('body').css('cursor','default');
			  $this.nextAll("select.mercadolivre_cat_selection").remove();
			  if(result.categories.length>0)
			  {
			    var html='&nbsp;<select name="mercadolivre_cat_selection[]" class="mercadolivre_cat_selection"><option value="">-Select-</option>';
				for(i=0;i<result.categories.length;i++)
				{
				   html+='<option value="'+result.categories[i].id+'">'+result.categories[i].name+'</option>';   
				}
				html+='</select>';
				$this.after(html);
			  }
			  getCategoryTree();
			  
			  if(result.allowed=='1'){
				 $('#category_tree_span').removeClass('category_nok');
				 $('#category_tree_span').addClass('category_ok');
			 }else{
				 $('#category_tree_span').removeClass('category_ok');
				 $('#category_tree_span').addClass('category_nok');
				 }
			  
			}
		});
	
});

function getCategoryTree()
{
   var tree='';
   $('select.mercadolivre_cat_selection option:selected').each(function(){
      if($(this).val()!=''){
		  if(tree=='')tree+=$(this).text();
		  else tree+=' &raquo; '+$(this).text();
	  }
   });
   
   $('#mercadolivre_category_tree').val(tree); 
   $('#category_tree_span').html(tree); 
}
//--></script>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
CKEDITOR.replace('mercadolivre_template', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
//--></script> 
<?php echo $footer; ?>