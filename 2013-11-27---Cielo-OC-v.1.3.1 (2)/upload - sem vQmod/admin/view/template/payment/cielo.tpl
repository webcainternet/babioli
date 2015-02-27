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
echo $header; ?>
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
			<h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
			<div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
		</div>
		<div class="content">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<table class="form">
					<tr>
						<td colspan="2"><?php echo $text_description; ?></td>
					</tr>
					<tr>
						<td><?php echo $entry_sandbox_mode; ?></td>
						<td>
							<?php if ($cielo_config['sandbox']) { ?>
								<input type="radio" name="cielo_config[sandbox]" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cielo_config[sandbox]" value="0" /><?php echo $text_no; ?>
								<?php } else { ?>
								<input type="radio" name="cielo_config[sandbox]" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cielo_config[sandbox]" value="0" checked="checked"/><?php echo $text_no; ?>
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_estabelecimento; ?></td>
						<td><input type="text" name="cielo_config[estabelecimento]" value="<?php echo $cielo_config['estabelecimento']; ?>" size="50%" /></td>
					</tr>
					<tr>
						<td><?php echo $entry_chave_seguranca; ?></td>
						<td><input type="text" name="cielo_config[chave]" value="<?php echo $cielo_config['chave']; ?>" size="50%" /></td>
					</tr>
					<tr>
						<td><?php echo $entry_buy_page; ?></td>
						<td>
							<select name="cielo_config[buy_page]">
								<?php if ($cielo_config['buy_page'] == 'cielo') { ?>
									<option value="cielo" selected="selected">Cielo</option>
								<?php } else { ?>
									<option value="cielo">Cielo</option>
								<?php } ?>
								<?php if ($cielo_config['buy_page'] == 'loja') { ?>
									<option value="loja" selected="selected"><?php echo $text_buy_page_loja; ?></option>
								<?php } else { ?>
									<option value="loja"><?php echo $text_buy_page_loja; ?></option>
								<?php } ?>
							</select>
					</tr>
					<tr>
						<td><?php echo $entry_exibicao_checkout; ?></td>
						<td>
							<select name="cielo_config[exibicao_checkout]">
								<?php if ($cielo_config['exibicao_checkout'] == 'img') { ?>
									<option value="img" selected="selected"><?php echo $text_exibicao_checkout_img; ?></option>
								<?php } else { ?>
									<option value="img"><?php echo $text_exibicao_checkout_img; ?></option>
								<?php } ?>
								<?php if ($cielo_config['exibicao_checkout'] == 'text') { ?>
									<option value="text" selected="selected"><?php echo $text_exibicao_checkout_text; ?></option>
								<?php } else { ?>
									<option value="text"><?php echo $text_exibicao_checkout_text; ?></option>
								<?php } ?>
							</select>
					</tr>
					<tr>
						<td><?php echo $entry_soft_descriptor; ?></td>
						<td>
							<?php if ($cielo_config['soft_descriptor'] == '') { ?>
								<input type="radio" name="cielo_config[soft_descriptor]" value="" checked="checked" /><?php echo $text_usar_nenhum; ?>
								<input type="radio" name="cielo_config[soft_descriptor]" value="num_pedido" /><?php echo $text_usar_num_pedido; ?>
								<input type="radio" name="cielo_config[soft_descriptor]" id="soft_descriptor_text" value="<?php echo $cielo_config['soft_descriptor']; ?>" />
								<?php echo $text_usar_outro; ?><input type="text" class="soft_descriptor" name="soft_descriptor" value="<?php echo $cielo_config['soft_descriptor']; ?>" size="50%" />
							<?php } elseif ($cielo_config['soft_descriptor'] == 'num_pedido') { ?>
								<input type="radio" name="cielo_config[soft_descriptor]" value="" /><?php echo $text_usar_nenhum; ?>
								<input type="radio" name="cielo_config[soft_descriptor]" value="num_pedido" checked="checked" /><?php echo $text_usar_num_pedido; ?>
								<input type="radio" name="cielo_config[soft_descriptor]" id="soft_descriptor_text" value="<?php echo $cielo_config['soft_descriptor']; ?>" />
								<?php echo $text_usar_outro; ?><input type="text" class="soft_descriptor" name="soft_descriptor" value="<?php echo $cielo_config['soft_descriptor']; ?>" size="50%" />
							<?php } else { ?>
								<input type="radio" name="cielo_config[soft_descriptor]" value="" /><?php echo $text_usar_nenhum; ?>
								<input type="radio" name="cielo_config[soft_descriptor]" value="num_pedido" /><?php echo $text_usar_num_pedido; ?>
								<input type="radio" name="cielo_config[soft_descriptor]" id="soft_descriptor_text" value="<?php echo $cielo_config['soft_descriptor']; ?>" checked="checked" />
								<?php echo $text_usar_outro; ?><input type="text" class="soft_descriptor" value="<?php echo $cielo_config['soft_descriptor']; ?>" size="50%" />
							<?php } ?>
						</td>
					</tr>
					<?php foreach($cielo_config['operacoes'] as $label => $operacao) { ?>
						<tr>
							<td onclick="$(this).children('.expand, .collapse').toggleClass('inactive active');$(this).next('td').children('table.labels').toggleClass('inactive active');"  style="cursor:pointer;">
								<img src="../image/cielo/<?php echo $label; ?>.png" style="vertical-align:middle;" />&nbsp;&nbsp;<?php echo $entry_operacao[$label]; ?>&nbsp;&nbsp;<img src="view/image/expand.png" class="expand inactive" style="vertical-align:middle;" /><img src="view/image/collapse.png" class="collapse inactive" style="vertical-align:middle;" /><br />								
							</td>
							<td>
								<table id="<?php echo $label; ?>" class="labels inactive">
									<tr>
										<td><?php echo $entry_habilitar_operacao; ?></td>
										<td>
											<?php if ($operacao['ativo']) { ?>
												<input type="radio" name="cielo_config[operacoes][<?php echo $label; ?>][ativo]" value="1" checked="checked" /><?php echo $text_yes; ?>
												<input type="radio" name="cielo_config[operacoes][<?php echo $label; ?>][ativo]" value="0" /><?php echo $text_no; ?>
											<?php } else { ?>
												<input type="radio" name="cielo_config[operacoes][<?php echo $label; ?>][ativo]" value="1" /><?php echo $text_yes; ?>
												<input type="radio" name="cielo_config[operacoes][<?php echo $label; ?>][ativo]" value="0" checked="checked"/><?php echo $text_no; ?>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<td><?php echo $entry_operacao_nome; ?></td>
										<td><input type="text" name="cielo_config[operacoes][<?php echo $label; ?>][nome]" value="<?php echo $operacao['nome']; ?>" /></td>
									</tr>
									<tr class="valor valor-min">
										<td><?php echo $entry_operacao_valor_minimo; ?></td>
										<td><input type="text" name="cielo_config[operacoes][<?php echo $label; ?>][valor_minimo]" value="<?php echo $operacao['valor_minimo']; ?>" /></td>
									</tr>
									<tr class="valor parc-min">
										<td><?php echo $entry_operacao_parc_minima; ?></td>
										<td><input type="text" name="cielo_config[operacoes][<?php echo $label; ?>][parc_minima]" value="<?php echo $operacao['parc_minima']; ?>" /></td>
									</tr>
									<tr class="valor desconto">
										<td><?php echo $entry_operacao_desconto; ?></td>
										<td><input type="text" name="cielo_config[operacoes][<?php echo $label; ?>][desconto]" value="<?php echo $operacao['desconto']; ?>" />&nbsp;%</td>
									</tr>
									<tr class="inteiro max-parc-sj">
										<td><?php echo $entry_operacao_max_parc_sj; ?></td>
										<td><input type="text" name="cielo_config[operacoes][<?php echo $label; ?>][max_parc_sj]" value="<?php echo $operacao['max_parc_sj']; ?>" />&nbsp;&nbsp;<span class="help"></span></td>
									</tr>
									<tr class="inteiro max-parc-jl">
										<td><?php echo $entry_operacao_max_parc_jl; ?></td>
										<td><input type="text" name="cielo_config[operacoes][<?php echo $label; ?>][max_parc_jl]" value="<?php echo $operacao['max_parc_jl']; ?>" />&nbsp;&nbsp;<span class="help"></span></td>
									</tr>
									<tr class="inteiro max-parc">
										<td><?php echo $entry_operacao_max_parc; ?></td>
										<td><input type="text" name="cielo_config[operacoes][<?php echo $label; ?>][max_parc]" value="<?php echo $operacao['max_parc']; ?>" />&nbsp;&nbsp;<span class="help"></span></td>
									</tr>
									<tr class="valor juros-loja">
										<td><?php echo $entry_operacao_juros_loja; ?></td>
										<td><input type="text" name="cielo_config[operacoes][<?php echo $label; ?>][juros_loja]" value="<?php echo $operacao['juros_loja']; ?>" />&nbsp;%</td>
									</tr>
									<tr>
										<td><?php echo $entry_operacao_auto_capturar; ?></td>
										<td>
											<?php if ($operacao['auto_capturar']) { ?>
												<input type="radio" name="cielo_config[operacoes][<?php echo $label; ?>][auto_capturar]" value="1" checked="checked" /><?php echo $text_yes; ?>
												<input type="radio" name="cielo_config[operacoes][<?php echo $label; ?>][auto_capturar]" value="0" /><?php echo $text_no; ?>
											<?php } else { ?>
												<input type="radio" name="cielo_config[operacoes][<?php echo $label; ?>][auto_capturar]" value="1" /><?php echo $text_yes; ?>
												<input type="radio" name="cielo_config[operacoes][<?php echo $label; ?>][auto_capturar]" value="0" checked="checked"/><?php echo $text_no; ?>
											<?php } ?>
										</td>
									</tr>
									<tr class="autorizacao">
										<td><?php echo $entry_operacao_autorizacao; ?></td>
										<td>
											<select name="cielo_config[operacoes][<?php echo $label; ?>][autorizacao]">
												<option value="0"<?php echo ($operacao['autorizacao'] == 0 ? ' selected="selected"' : '') . 'id="aut-option-0-' . $label .'" >' . $text_autorizacao_0; ?></option>
												<option value="1"<?php echo ($operacao['autorizacao'] == 1 ? ' selected="selected"' : '') . 'id="aut-option-1-' . $label .'" >' . $text_autorizacao_1; ?></option>
												<option value="2"<?php echo ($operacao['autorizacao'] == 2 ? ' selected="selected"' : '') . 'id="aut-option-2-' . $label .'" >' . $text_autorizacao_2; ?></option>
												<option value="3"<?php echo ($operacao['autorizacao'] == 3 ? ' selected="selected"' : '') . 'id="aut-option-3-' . $label .'" >' . $text_autorizacao_3; ?></option>
												<option value="4"<?php echo ($operacao['autorizacao'] == 4 ? ' selected="selected"' : '') . 'id="aut-option-4-' . $label .'" >' . $text_autorizacao_4; ?></option>
											</select>
										</td>
									</tr>									
								</table>
							</td>
						</tr>
					<?php } ?>
					<tr>
						<td><?php echo $entry_status_pedido_pendente; ?></td>
						<td>
							<select name="cielo_config[status_pedido][pendente]">
								<?php foreach ($order_statuses as $order_status) { ?>
									<?php if ($order_status['order_status_id'] == $cielo_config['status_pedido']['pendente']) { ?>
										<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_status_pedido_erro_sem_retry; ?></td>
						<td>
							<select name="cielo_config[status_pedido][erro_sem_retry]">
							<?php foreach ($order_statuses as $order_status) { ?>
								<?php if ($order_status['order_status_id'] == $cielo_config['status_pedido']['erro_sem_retry']) { ?>
									<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
								<?php } ?>
							<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_status_pedido_erro_com_retry; ?></td>
						<td>
							<select name="cielo_config[status_pedido][erro_com_retry]">
								<?php foreach ($order_statuses as $order_status) { ?>
									<?php if ($order_status['order_status_id'] == $cielo_config['status_pedido']['erro_com_retry']) { ?>
										<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_status_pedido_sucesso_sem_captura; ?></td>
						<td>
							<select name="cielo_config[status_pedido][sucesso_sem_captura]">
								<?php foreach ($order_statuses as $order_status) { ?>
									<?php if ($order_status['order_status_id'] == $cielo_config['status_pedido']['sucesso_sem_captura']) { ?>
										<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_status_pedido_sucesso_com_captura; ?></td>
						<td>
							<select name="cielo_config[status_pedido][sucesso_com_captura]">
								<?php foreach ($order_statuses as $order_status) { ?>
									<?php if ($order_status['order_status_id'] == $cielo_config['status_pedido']['sucesso_com_captura']) { ?>
										<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_geo_zone; ?></td>
						<td>
							<select name="cielo_config[geo_zone_id]">
								<?php if ($cielo_config['geo_zone_id'] == '0') { ?>
									<option value="0" selected="selected"><?php echo $text_all_zones; ?></option>
								<?php } else { ?>
									<option value="0"><?php echo $text_all_zones; ?></option>
								<?php } ?>
								<?php foreach ($geo_zones as $geo_zone) { ?>
									<?php if ($geo_zone['geo_zone_id'] == $cielo_config['geo_zone_id']) { ?>
										<option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_status; ?></td>
						<td>
							<select name="cielo_status">
								<?php if ($cielo_status) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
								<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_sort_order; ?></td>
						<td><input type="text" name="cielo_sort_order" value="<?php echo $cielo_sort_order; ?>" size="1" /></td>
					</tr>
				</table>
			</form>
			<div style="float:right;"><?php echo $text_author; ?></div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
	$(document).ready(function() {
		
		$('img.tip[title]').cluetip({
			splitTitle: '|',
			arrows: true,
			showTitle: false
		});
		
		$('#aut-option-2-visa_electron, #aut-option-3-visa_electron, #aut-option-4-visa_electron, ' +
		  '#aut-option-2-redeshop, #aut-option-3-redeshop, #aut-option-4-redeshop, ' +
		  '#aut-option-0-diners, #aut-option-1-diners, #aut-option-2-diners, ' +
		  '#aut-option-0-amex, #aut-option-1-amex, #aut-option-2-amex, ' +
		  '#aut-option-0-elo, #aut-option-1-elo, #aut-option-2-elo, ' +
		  '#aut-option-0-discover, #aut-option-1-discover, #aut-option-2-discover').remove();

		$('.soft_descriptor')
			.on('keyup focusout', function(event) {
				var $elem = $(this);
				$elem.val($elem.val().replace(/[^\d\w ]/g, ''));
				if ($elem.val().length > 13) {
					$elem.val($elem.val().substr(0,13));
					$('<p><?php echo $text_script_erro_soft_descriptor; ?></p>')
					.dialog({height: 200, width: 300, modal: true,  buttons:{
						'<?php echo $text_script_botao_retornar; ?>': function(){
							$elem.focus();
							$(this).dialog('destroy');}
						}, title: '<?php echo $text_script_title_alerta; ?>'});
					$('.ui-icon-closethick').parent().css({'display':'none'});
				}
				$('#soft_descriptor_text').val($elem.val());
				if ($elem.val().length > 0) $('#soft_descriptor_text').attr('checked', 'checked');
			});
			
		$('.parc-min input').on('focusout', function(event) {
			var $elem = $(this);
			if ($elem.val() < 5) {
				$elem.val('5');
				$('<p><?php echo $text_script_erro_valor_minimo; ?>')
					.dialog({height: 200, width: 300, modal: true,  buttons:{
						'<?php echo $text_script_botao_retornar; ?>': function(){
							$elem.focus();
							$(this).dialog('destroy');}
						}, title: '<?php echo $text_script_title_alerta; ?>'});
				$('.ui-icon-closethick').parent().css({'display':'none'});
			} else if (isNaN($elem.val())) {
				$elem.val('5');
				$('<p><?php echo $text_script_erro_NAN; ?></p>')
					.dialog({height: 200, width: 300, modal: true,  buttons:{
						'<?php echo $text_script_botao_retornar; ?>': function(){
							$elem.focus();
						$(this).dialog('destroy');}
					}, title: '<?php echo $text_script_title_alerta; ?>'});
				$('.ui-icon-closethick').parent().css({'display':'none'});
			}
		});
		
		$('.inteiro input, .desconto input, .valor-min input, .juros-loja input').on('focusout', function(event) {
			var $elem = $(this);
			if ($elem.val() < 0) {
				$elem.val('0');
				$('<p><?php echo $text_script_erro_negativo; ?></p>')
					.dialog({height: 200, width: 300, modal: true,  buttons:{
						'<?php echo $text_script_botao_retornar; ?>': function(){
							$elem.focus();
						$(this).dialog('destroy');}
					}, title: '<?php echo $text_script_title_alerta; ?>'});
				$('.ui-icon-closethick').parent().css({'display':'none'});
			} else if (isNaN($elem.val())) {
				$elem.val('0');
				$('<p><?php echo $text_script_erro_NAN; ?></p>')
					.dialog({height: 200, width: 300, modal: true,  buttons:{
						'<?php echo $text_script_botao_retornar; ?>': function(){
							$elem.focus();
						$(this).dialog('destroy');}
					}, title: '<?php echo $text_script_title_alerta; ?>'});
				$('.ui-icon-closethick').parent().css({'display':'none'});
			} else if ($elem.val() == '') {
				$elem.val('0');
			}
		});

		$('.valor input').on('keyup', function(event) {
			var $elem = $(this);
			$elem.val($elem.val().replace(/[^\d\.]/g, ''));
		});

		$('.inteiro input').on('keyup', function(event) {
			var $elem = $(this);
			$elem.val($elem.val().replace(/[^\d]/g, ''));
		});
		
		$('.max-parc input').on('focusout', function(event) {
			var $mx = $(this);
			var $sj = $mx.parents('.labels').find('.max-parc-sj input');
			var $jl = $mx.parents('.labels').find('.max-parc-jl input');
			var sj = parseInt($sj.val());
			var jl = parseInt($jl.val());
			var mx = parseInt($mx.val());
			mx = Math.max(sj, jl, mx) <= 1 ? 1 : Math.max(sj, jl, mx);
			$mx.val(mx);
			sj = (sj < 2) ? 1 : sj;
			jl = (jl < sj) ? sj : jl;
			$sj.siblings('.help').html(sj-1 == 0 ? '<?php echo $text_script_parc_sj_desativado; ?>' : '<?php echo $text_script_parc_sj_ativo; ?>'.sprintf(sj));
			$jl.siblings('.help').html(jl-sj == 0 ? '<?php echo $text_script_parc_loja_desativado; ?>' : '<?php echo $text_script_parc_loja_ativo; ?>'.sprintf((sj+1), jl));
			$mx.siblings('.help').html(mx-jl == 0 ? '<?php echo $text_script_parc_admin_desativado; ?>' : '<?php echo $text_script_parc_admin_ativo; ?>'.sprintf((jl+1), mx));
		});
		
		$('.max-parc-jl input').on('focusout', function(event) {
			var $jl = $(this);
			var jl = parseInt($jl.val());
			if (jl == 0) {
				$jl.parents('.labels').find('.max-parc input').trigger('focusout');
				return false;
			}
			var $sj = $jl.parents('.labels').find('.max-parc-sj input');
			var sj = parseInt($sj.val());
			$jl.val(Math.max(sj, jl));
			$jl.parents('.labels').find('.max-parc input').trigger('focusout');
		});
		
		$('.max-parc-sj input').on('focusout', function(event) {
			$(this).parents('.labels').find('.max-parc-jl input').trigger('focusout');
		});
		
		$('.max-parc-sj input').trigger('focusout');
		
	});

	String.prototype.sprintf = function() {
		var s = this;
		var a = arguments;
		for (var i = 0; i < a.length; i++) {
			var r = new RegExp('\\{' + i + '\\}', 'gi');
			s = s.replace(r, a[i]);
		}
		return s;
	};

//--></script>
<style type="text/css">
	img.tip {position:relative;top:3px;}
	table.form > tbody > tr > td:first-child {width: 350px;}
	tr.max-parc .help, tr.max-parc-sj .help, tr.max-parc-jl .help {display:inline;}	
	#visa_electron > tbody > tr.parc-min,
	#visa_electron > tbody > tr.max-parc,
	#visa_electron > tbody > tr.max-parc-sj,
	#visa_electron > tbody > tr.max-parc-jl,
	#visa_electron > tbody > tr.juros-loja,
	#redeshop > tbody > tr.parc-min,
	#redeshop > tbody > tr.max-parc,
	#redeshop > tbody > tr.max-parc-sj,
	#redeshop > tbody > tr.max-parc-jl,
	#redeshop > tbody > tr.juros-loja,
	#discover > tbody > tr.parc-min,
	#discover > tbody > tr.max-parc,
	#discover > tbody > tr.max-parc-sj,
	#discover > tbody > tr.max-parc-jl,
	#discover > tbody > tr.juros-loja
		{display:none;}

	table.active {display:block;}
	table.inactive {display:none;}
	img.expand.active {display:none;}
	img.expand.inactive {display:inline-block;}
	img.collapse.active {display:inline-block;}
	img.collapse.inactive {display:none;}
	
</style>
<?php echo $footer; ?> 