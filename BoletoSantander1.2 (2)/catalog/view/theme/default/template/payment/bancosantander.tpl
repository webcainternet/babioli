<div class="buttons">
  <div class="right">
    <a class="button" target="_blank" href="<?php echo $url_boleto;?>" id="button-confirm">Confirmar e Gerar Boleto</a>
  </div>
  
</div>
<script type="text/javascript">
<!--
$('#button-confirm').bind('click', function() {
	$.ajax({ 
		type: 'get',
			url: 'index.php?route=payment/bancosantander/confirm',
		success: function() {
			location = '<?php echo $continue; ?>';
		}		
	});
});
//-->
</script> 
