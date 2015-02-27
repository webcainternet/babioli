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
echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $retorno_heading_title; ?></h1>
  <br /><br />
	<p><?php echo $retorno_compra_nao_confirmada; ?></p>
	<p style="padding-left:30px;"><?php echo $retorno_codigo_evento; ?>&nbsp;<b><?php echo $cielo_json['error']['code']; ?></b></p>
	<p style="padding-left:30px;"><?php echo $retorno_descricao_evento; ?>&nbsp;<?php echo $cielo_json['error']['message']; ?></p>
	<?php if ($cielo_json['error']['retry'] == 'yes') { ?>
		<p><?php echo $retorno_erro_nao_definitivo; ?></p>
	<?php } else { ?>
		<p><?php echo $retorno_escolher_outra_forma; ?></p>
	<?php } ?>
	<p><a href="<?php echo $continue; ?>"><?php echo $retorno_voltar_ao_checkout; ?></a></p>
	<br /><br />
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>