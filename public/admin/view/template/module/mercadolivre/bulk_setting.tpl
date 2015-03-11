<div id="content">
 <div class="box">
    <div class="heading">
      <div class="buttons"><a onclick="$('#form_ml').submit();" class="button"><?php echo $button_save; ?></a><a href="javascript:$.colorbox.close();" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content"> 
       <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form_ml">
	  
              <table class="form">
                     <tr>
                     <td><?php echo $lang_ml_select_product; ?></td>
                     <td><input type="text" name="ml" value="" /></td>
                 </tr>
                 <tr>
                  <td>&nbsp;</td>
                  <td><div id="product-ml" class="scrollbox">
                        <?php $class = 'odd'; ?>
                          <?php foreach ($products as $product_ml) { ?>
                          <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                          <div id="product_ml<?php echo $product_ml['product_id']; ?>" class="<?php echo $class; ?>"> <?php echo $product_ml['name']; ?><img src="view/image/delete.png" alt="" />
                            <input type="hidden" name="product_ml[]" value="<?php echo $product_ml['product_id']; ?>" />
                          </div>
                          <?php } ?>
                    </div></td>
                   </tr>
						<tr>
							 <td><?php echo $entry_mercadolivre_category; ?><br /><?php echo $ml_text_category_hint;?></td>
							  <td>
								<input type="hidden" name="mercaTree" value="<?php echo $mercaTree?>" id="mercaTree" />
							    <input type="hidden" name="mercaId" value="<?php echo $mercaId?>" id="mercaId" />
							   <span id="category_tree_span" class="category_ok">
							     <?php echo html_entity_decode($mercaTree)?>
							   </span>
								<select name="mercadolivre_cat_selection[]" class="mercadolivre_cat_selection">
								   <option value=""><?php echo $ml_text_select;?></option>
									<?php echo $mercadolivre_cats?>
								</select>
							  </td>
						  </tr>
						   <tr id="ml_attr_row_wrapper" style="display:none">
							 <td colspan="2"></td>
						  </tr> 
						 <tr>
							 <td><?php echo $entry_mercadolivre_currency; ?></td>
							  <td>
								<select name="mercaCurrency" id="mercaCurrency">
								<option value=""><?php echo $ml_text_select;?></option>
									<?php foreach ($mercadolivre_currency as $mercadolivre_cur) { $chk=''; if($mercaCurrency==$mercadolivre_cur['value']) $chk='selected'; ?>
									  <option value="<?php echo $mercadolivre_cur['value']?>" <?php echo $chk; ?> ><?php echo $mercadolivre_cur['name']?></option>
									<?php } ?>
								</select>
							  </td>
						  </tr>
						  <tr>
							 <td><?php echo $entry_mercadolivre_buying_mode; ?></td>
							  <td>
								<select name="mercaBuyMode" id="mercaBuyMode">
								<option value=""><?php echo $ml_text_select;?></option>
									<?php foreach ($mercadolivre_modes as $mercadolivre_mode) { $chk=''; if($mercaBuyMode==$mercadolivre_mode['value']) $chk='selected'; ?>
									  <option value="<?php echo $mercadolivre_mode['value']?>" <?php echo $chk; ?> ><?php echo $mercadolivre_mode['name']?></option>
									<?php } ?>
								</select>
							  </td>
						  </tr>
						  <tr>
							 <td><?php echo $entry_mercadolivre_listing_type; ?></td>
							  <td>
								<select name="mercaListType" id="mercaListType">
								<option value=""><?php echo $ml_text_select;?></option>
									<?php foreach ($mercadolivre_types as $mercadolivre_type) { $chk=''; if($mercaListType==$mercadolivre_type['value']) $chk='selected'; ?>
									  <option value="<?php echo $mercadolivre_type['value']?>" <?php echo $chk; ?> ><?php echo $mercadolivre_type['name']?></option>
									<?php } ?>
								</select>
							  </td>
						  </tr>
						  <tr>
							 <td><?php echo $entry_mercadolivre_condition; ?></td>
							  <td>
								<select name="mercaCondition" id="mercaCondition">
								<option value=""><?php echo $ml_text_select;?></option>
									<?php foreach ($mercadolivre_conditions as $mercadolivre_condition) { $chk=''; if($mercaCondition==$mercadolivre_condition['value']) $chk='selected'; ?>
									  <option value="<?php echo $mercadolivre_condition['value']?>" <?php echo $chk; ?> ><?php echo $mercadolivre_condition['name']?></option>
									<?php } ?>
								</select>
							  </td>
						  </tr>
						  <tr>
							 <td><?php echo $entry_mercadolivre_warranty; ?></td>
							  <td>
								 <input type="text" name="mercaWarranty" value="<?php echo $mercaWarranty; ?>" size="30" />
							  </td>
						  </tr>
						  <tr>
							 <td><?php echo $entry_mercadolivre_video; ?></td>
							  <td>
								 <input type="text" name="mercaVideoId" value="<?php echo $mercaVideoId; ?>" size="30" />
							  </td>
						  </tr>
					  </table>	
       
       
         </form>
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
	#colorbox, #cboxOverlay, #cboxWrapper{z-index:500;}
 </style>
	<script type="text/javascript"><!--
    var ml_attr_row='';
    $('.mercadolivre_cat_selection').live('change',function(){
    
        var $this=$(this);
        if($this.val()=='') return false;
        
        $('#mercaId').val($this.val());
        
        $.ajax({
                url: 'index.php?route=module/mercadolivre/category&token=<?php echo $token; ?>',
                dataType: 'json',
                data:{catId:$this.val(),listingType:$('#mercaListType').val()},
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
                  
                  if(result.listing_type!=''){
                    $('#mercaListType').html(result.listing_type);
                  }
                  
                  if(result.allowed=='1'){
                    $('#category_tree_span').removeClass('category_nok');
                    $('#category_tree_span').addClass('category_ok');
                  }else{
                    $('#category_tree_span').removeClass('category_ok');
                    $('#category_tree_span').addClass('category_nok');
                  }
                  
                  
                  
                  if(result.attribute_types=='1'){
                    getCatAttr($this.val());
                  }else{
                     $('#ml_attr_row_wrapper td').html('');
                     $('#ml_attr_row_wrapper').hide(); 
                   
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
       
       $('#mercaTree').val(tree); 
       $('#category_tree_span').html(tree); 
    }
						
			function getCatAttr(catId)
				{
					 var product_id = '<?php echo isset($product_id)?$product_id:0; ?>';
					 $.ajax({
					 url: 'index.php?route=module/mercadolivre/attribute&token=<?php echo $token; ?>',
					 dataType: 'json',
					 data:{catId:catId,product_id:product_id},
					 beforeSend:function()
						{
							$('body').css('cursor','wait');
						},
					success: function(result) {
						$('body').css('cursor','default');
						ml_attr_row=result.row;
						$('#ml_attr_row_wrapper td').html(result.html);
						if(result.html==''){ 
						  $('#ml_attr_row_wrapper').hide(); 
						}
						else {
						 $('#ml_attr_row_wrapper').show(); 
					   }
				}
			  });
			}
			
			if($('#mercaId').length>0){
			  if($('#mercaId').val()!='') getCatAttr($('#mercaId').val());
			}
			
			function addMLAttribute(){
			   var no_of_ml_attr=$('tr.ml_attr_row').length;
			   no_of_ml_attr=parseInt(no_of_ml_attr)+1;
			   
			   while($('#ml_attr_row'+no_of_ml_attr).length!=0)
				{
				  no_of_ml_attr++; 
				}
				ml_attr_row_html=ml_attr_row;
				ml_attr_row_html=ml_attr_row_html.replace(/__AINDEX__/g, no_of_ml_attr);
				$('#ml_attribute tbody').append(ml_attr_row_html);
			}
			
			function removeMLAttribute(id){
			  $('#ml_attr_row'+id).remove();
			}
			
	
	function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(text) {
						$('#' + thumb).replaceWith('<img src="' + text + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};		
	
	// Related
	$('input[name=\'ml\']').autocomplete({
		delay: 500,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
				dataType: 'json',
				success: function(json) {		
					response($.map(json, function(item) {
						return {
							label: item.name,
							value: item.product_id
						}
					}));
				}
			});
		}, 
		select: function(event, ui) {
			$('#product-ml' + ui.item.value).remove();
			
			$('#product-ml').append('<div id="product-ml' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="product_ml[]" value="' + ui.item.value + '" /></div>');
	
			$('#product-ml div:odd').attr('class', 'odd');
			$('#product-ml div:even').attr('class', 'even');
					
			return false;
		},
		focus: function(event, ui) {
		  return false;
	   }
	});
	
	$('#product-ml div img').live('click', function() {
		$(this).parent().remove();
		
		$('#product-ml div:odd').attr('class', 'odd');
		$('#product-ml div:even').attr('class', 'even');	
	});		
						
//--></script>