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
if($operacoes_erro) {
	echo '<div class="warning">' . $erro_sem_operacoes . '</div>';
} else { ?>
	<div>
		<script type="text/javascript" src="catalog/view/javascript/jquery/cluetip/jquery.cluetip.js"></script>
		<link type="text/css" rel="stylesheet" href="catalog/view/javascript/jquery/cluetip/jquery.cluetip.css" />
		<?php if ('1.5.5' == VERSION || '1.5.5.1' == VERSION || '1.5.6' == VERSION) { ?>
			<script type="text/javascript" src="catalog/view/javascript/jquery/tabs.js"></script>
		<?php } ?>
		<?php if (isset($cielo_warning)) { ?>
			<div class="warning"><?php echo $cielo_warning; ?></div>
		<?php } ?>
		<form action="" method="post" id="form-cielo">
			
			<?php if ($buy_page == 'cielo') {
				echo $cielo_buy_page_info; ?>
				<input type="hidden" name="buy_page" value="cielo" />
			<?php } else { 
				echo $loja_buy_page_info; ?>
				<input type="hidden" name="buy_page" value="loja" />
				<table style="margin-left:245px;">
					<tr><td><?php echo $entry_nome_portador; ?></td><td><input type="text" name="nome_portador" value="" /></td></tr>
					<tr><td><?php echo $entry_numero_cartao; ?></td><td><input type="text" name="numero_cartao" value="" /></td></tr>
					<tr><td><?php echo $entry_validade_cartao; ?></td><td><input type="text" name="val_mes" value="" size="2"/>&nbsp;/&nbsp;<input type="text" name="val_ano" value="" size="4"/></td></tr>
					<tr><td><?php echo $entry_codigo_seguranca; ?></td><td><input type="text" name="codigo_seguranca" value="" />&nbsp;&nbsp;<img src="image/cielo/help.png" class="cvvtip" rel="#cvv" /></td></tr>
					<tr><td>&nbsp;</td><td><input type="checkbox" name="codigo_inexistente"><?php echo $text_codigo_inexistente; ?>&nbsp;<input type="checkbox" name="codigo_ilegivel"><?php echo $text_codigo_ilegivel; ?></td></tr>
				</table>
			<?php } ?>
			<br /><br />
			<div class="vtabs">
				<?php foreach($operacoes as $operacao) { ?>
					<a href="#tab-<?php echo $operacao['key']; ?>" onclick="$('#<?php echo $operacao['key']; ?>-parc-1').attr('checked', 'checked');$('#<?php echo $operacao['key']; ?>').attr('checked', 'checked');"><span style="position:relative;top:-8px;"><?php echo $operacao['nome']; ?>&nbsp;&nbsp;</span><img src="image/cielo/<?php echo $operacao['key']; ?>.png" /></a>
				<?php } ?>
			</div>
			<?php foreach($operacoes as $operacao) { ?>
				<div id="tab-<?php echo $operacao['key']; ?>" class="vtabs-content">
					<input type="radio" name="operacao" value="<?php echo $operacao['key']; ?>" id="<?php echo $operacao['key']; ?>" style="display:none;" /><b><?php echo $operacao['nome']; ?></b><br />
					<ul>
						<?php foreach($operacao['parcelas'] as $n => $parcela) { ?>
							<li class="parcelas">
								<input type="radio" name="num_parcelas" id="<?php echo $operacao['key']; ?>-parc-<?php echo $n; ?>" value="<?php echo $n; ?>" onclick="$('#<?php echo $operacao['key']; ?>').attr('checked', 'checked');" />
								<?php if ($n == 1) {
									echo sprintf($form_1_parcela, $n, $parcela['valor_parc']) . ($parcela['desconto'] ? sprintf($form_1_parcela_desconto, $parcela['desconto']) : '.');
									continue;
								} elseif (!$parcela['juros']) {
									echo sprintf($form_parcelas_sem_juros, $n, $parcela['valor_parc']);
									continue;
								} elseif (!is_bool($parcela['juros']) && $parcela['juros'] > 0) {
									echo sprintf($form_parcelas_com_juros, $n, $parcela['valor_parc'], $parcela['juros']);
									continue;
								} else {
									echo sprintf($form_parcelas_juros_adm, $n);
								} ?>
							</li>
						<?php } ?>
					</ul><br />
				</div>
			<?php } ?>
			<div class="buttons">
				<div class="right"><a id="button-confirm" class="button" onclick="cielo_confirm();"><span><?php echo $button_confirm; ?></span></a></div>   
			</div>
			<div id="cielo-popin" style="display:none;"></div>
			<div id="cvv" style="display:none;">
				<img src="image/cielo/cvv.png" style="vertical-align:top;position:relative;top:30px" /><span style="display:inline-block;width:205px;padding-left:5px;"><?php echo $cielo_instrucoes_cvv; ?></span>
			</div>
		</form>
		<script type="text/javascript"><!--
			var cielo_confirm = function() {
				$.ajax({
					url: 'index.php?route=payment/cielo/confirm',
					type: 'post',
					data: $('#form-cielo input[name=\'buy_page\'], #form-cielo input[name=\'nome_portador\'], #form-cielo input[name=\'numero_cartao\'], #form-cielo input[name=\'val_mes\'], #form-cielo input[name=\'val_ano\'], #form-cielo input[name=\'codigo_seguranca\'], #form-cielo input[type=\'checkbox\']:checked, #form-cielo input[type=\'radio\']:checked'),
					dataType: 'json',
					timeout: 40000,
					beforeSend: function() {
						$('#button-confirm').attr('disabled', true);
						$('#cielo-popin')
							.empty()
							.append('<p><?php echo $text_script_nao_feche; ?></p><div class="wait" style="text-align:center;"><img src="catalog/view/theme/default/image/loading.gif" alt="" /></div>')
							.dialog({height: 200, width: 400, modal: true,  buttons: {}, title: '<?php echo $text_script_title; ?>'});
						$('.ui-icon-closethick').parent().css({'display':'none'});
					},
					complete: function() {
						$('#cielo-popin > .wait').remove();
					},
					success: function(json) {
						if (json['error'] && json['error']['code'] == 'XX') {
							$('#cielo-popin')
							.empty()
							.append('<p class="warning" style="display: none;"><?php echo $text_script_erro_preenchimento; ?> ' + json['error']['code'] + '.<br />' + json['error']['message'] + '</p>')
							.dialog({height: 300, buttons:[
								{	text: '<?php echo $text_script_botao_retornar; ?>',
									click: function() {
										$('#button-confirm').attr('disabled', false);
										$('#cielo-popin').empty().dialog('close');}
								}
							]});
							$('.warning').fadeIn('slow');
						} else if (json['error'] && json['error']['retry'] == 'yes') {
							$('#cielo-popin')
								.empty()
								.append('<p class="warning" style="display: none;"><?php echo $text_script_falha_comunicacao; ?> ' + json['error']['code'] + '. ' + json['error']['message'] + '</p>')
								.dialog({height: 300, buttons:[
									{	text: '<?php echo $text_script_botao_retry; ?>',
										click: function() {
											$('#button-confirm').attr('disabled', false);
											$('#cielo-popin').empty().dialog('close');
											cielo_confirm();}
									},
									{	text: '<?php echo $text_script_botao_retornar; ?>',
										click: function() {
											$('#button-confirm').attr('disabled', false);
											$('#cielo-popin').empty().dialog('close');}
									}
									]});
							$('.warning').fadeIn('slow');
						} else if (json['error'] && json['error']['retry'] == 'no') {
							$('#cielo-popin')
								.empty()
								.append('<p class="warning" style="display: none;"><?php echo $text_script_ocorreu_um_erro; ?> ' + json['error']['code'] + '. ' + json['error']['message'] + '</p>')
								.dialog({height: 300, buttons:[
									{	text: '<?php echo $text_script_botao_retornar; ?>',
										click: function() {
											$('#button-confirm').attr('disabled', false);
											$('#cielo-popin').empty().dialog('close');}
									}
									]});
							$('.warning').fadeIn('slow');
						} else if (json['redirect']) {
							$('#cielo-popin')
								.empty()
								.append('<p class="success" style="display: none;"><?php echo $text_script_redirecionando; ?></p>')
								.dialog({buttons:[
									{	text: '<?php echo $text_script_botao_redirecionar; ?>',
										click: function() {
											location = json['redirect'];}
									}
									]});
							$('.success').fadeIn('slow');
							location = json['redirect'];
						} else if (json['success']) {
							$('#cielo-popin')
								.empty()
								.append('<p class="success" style="display: none;"><?php echo $text_script_pedido_aprovado; ?></p>')
								.dialog({buttons:[
									{	text: '<?php echo $text_script_botao_finalizar; ?>',
										click: function() {
											location = json['final_url'];}
									}
									]});
							$('.success').fadeIn('slow');
						} else {
							$('#cielo-popin')
								.empty()
								.append('<p class="warning" style="display: none;"><?php echo $text_script_erro_inesperado; ?></p>')
								.dialog({height: 300, buttons:[
									{	text: '<?php echo $text_script_botao_contato; ?>',
										click: enviar_info
									}
									]});
								$('.warning').fadeIn('slow');
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						if (ajaxOptions === 'timeout') {
							$('#cielo-popin')
								.empty()
								.append('<p class="warning" style="display:none;"><?php echo $text_script_erro_timeout; ?> ' + thrownError + ' - ' + xhr.statusText + ' - ' + xhr.responseText + '</p>')
								.dialog({height: 300, buttons:[
									{	text: '<?php echo $text_script_botao_contato; ?>',
										click: enviar_info
									}
									]});
							$('.warning').fadeIn('slow');
						} else {
							$('#cielo-popin')
								.empty()
								.append('<p class="warning" style="display:none;"><?php echo $text_script_erro_tecnico; ?> ' + thrownError + ' - ' + xhr.statusText + ' - ' + xhr.responseText + '</p>')
								.dialog({height: 300, buttons:[
									{	text: '<?php echo $text_script_botao_contato; ?>',
										click: enviar_info
									}
									]});
							$('.warning').fadeIn('slow');
						}
					}
				});
			};
			var enviar_info = function() {
				auto_form  = '<form action="index.php?route=information/contact" method="post" enctype="multipart/form-data" id="auto_form">';
				auto_form += '<input type="hidden" name="name" value="<?php echo $customer_name; ?>" />';
				auto_form += '<input type="hidden" name="email" value="<?php echo $customer_email; ?>" />';
				auto_form += '<input type="hidden" name="enquiry" value="<?php echo $text_envia_erro; ?>' + $('p.warning').html().replace(/"/g,"'") + '" />';
				auto_form += '<input type="hidden" name="captcha" value="" />';			
				auto_form += '</form>';
				$('body').append(auto_form);
				$('#auto_form').submit();
			}
		//--></script>
		<script type="text/javascript"><!--
			$('.vtabs a').tabs();
			$('img.cvvtip').cluetip({local:true, showTitle:false, width:420});
			$('input[name="numero_cartao"], input[name="val_mes"], input[name="val_ano"], input[name="codigo_seguranca"]')
				.on('keyup focusout', function(event) {
					var $elem = $(this);
					$elem.val($elem.val().replace(/[^\d]/g, ''));
					if ($elem.attr('name') == 'numero_cartao' && $elem.val().length >= 16) $('input[name="val_mes"]').focus();
					if ($elem.attr('name') == 'val_mes' && $elem.val().length >= 2) $('input[name="val_ano"]').focus();
					if ($elem.attr('name') == 'val_ano' && $elem.val().length >= 4) $('input[name="codigo_seguranca"]').focus();
					if ($elem.attr('name') == 'codigo_seguranca' && $elem.val().length > 0) $('input[name="codigo_inexistente"], input[name="codigo_ilegivel"]').attr('checked', false);
				});
			$('input[name="codigo_inexistente"], input[name="codigo_ilegivel"]')
				.on('click', function(event) {
					var a = $(this).attr('checked');
					$('input[name="codigo_inexistente"], input[name="codigo_ilegivel"]').attr('checked', false);
					$('input[name="codigo_seguranca"]').val('');
					$(this).attr('checked', a);
				});
		//--></script>
		<style>
			.vtabs {width:230px;padding:10px 0px;min-height:200px;float:left;display:block;border-right:1px solid #DDDDDD;vertical-align:center;}
			.vtabs a {display:block;float:left;width:200px;margin-bottom:5px;clear:both;border-top:1px solid #DDDDDD;border-left:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;background:#F7F7F7;padding:6px 14px 7px 15px;font-family:Arial, Helvetica, sans-serif;font-size:13px;font-weight:bold;text-align:right;text-decoration:none;color:#000000;}
			.vtabs a.selected {padding-right:15px;background:#FFFFFF;}
			.vtabs a img {position:relative;top:3px;cursor:pointer;}
			.vtabs-content {margin-left:245px;}
		</style>
	</div>
<?php } ?>