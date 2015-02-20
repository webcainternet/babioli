<?php
//Payment page links
$_['text_amazon_checkout'] = '<a onclick="window.open(\'http://go.amazonservices.com/UKCBASPOpenCart.html\');"><img src="view/image/payment/amazon.png" alt="Amazon Payments" title="Amazon Payments" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_amazon_join'] = '<a href="http://go.amazonservices.com/UKCBASPOpenCart.html" title="Click here to join Amazon Payments">Clique aqui para criar sua conta de pagamentos Amazon</a>';

//Headings
$_['heading_title'] = 'Pagamentos Amazon';
$_['text_home'] = 'Home';
$_['text_payment'] = 'Pagamento';

//Text
$_['text_cron_job_url'] = "Cron Job's URL:";
$_['help_cron_job_url'] = "Defina um cron job para chamar esta URL";
$_['text_cron_job_token'] = "Token secreto";
$_['help_cron_job_token'] = "Crie uma longa e difícil de adivinhar";
$_['text_access_key'] = 'Chave de acesso:';
$_['text_access_secret'] = 'Chave secreta:';
$_['text_merchant_id'] = 'ID de mercado:';
$_['text_marketplace'] = 'Mercado:';
$_['text_germany'] = 'Germânia';
$_['text_uk'] = 'Reino Unido';
$_['text_checkout_mode'] = 'Modo de Checkout:';
$_['text_geo_zone'] = 'Zona geográfica:';
$_['text_status'] = 'Status:';
$_['text_live'] = 'Live';
$_['text_sandbox'] = 'Sandbox';
$_['text_sort_order'] = 'Ordenar pedido:';
$_['text_minimum_total'] = 'Pedido mínimo total:';
$_['text_all_geo_zones'] = 'Todas as zonas geográficas';
$_['text_status_enabled'] = 'Habilitado';
$_['text_status_disabled'] = 'Desabilitado';
$_['text_default_order_status'] = 'Pendente:';
$_['text_ready_order_status'] = 'Status "Pronto para envio":';
$_['text_canceled_order_status'] = 'Status "Pedido Cancelado":';
$_['text_shipped_order_status'] = 'Status "Pedido enviado":';
$_['text_last_cron_job_run'] = "Ultimo funcionamento do cron job:";
$_['text_allowed_ips'] = "IPs permitidos";
$_['text_add'] = "Adicionar";
$_['text_upload_success'] = 'Arquivo enviado com sucesso';
$_['help_adjustment'] = 'Os campos em negrito, e ao menos um campo "-adj" são necessários';
$_['help_allowed_ips'] = "Deixe vazio se você quer que todos vejam o botão de checkout";

// Buttons
$_['button_cancel'] = 'Cancelar';
$_['button_save'] = 'Salvar';

// Errors
$_['error_permissions'] = 'Você não tem permissão para modificar este módulo';
$_['error_empty_access_secret'] = 'A chave secreta é necessária';
$_['error_empty_access_key'] = 'A chave de acesso é necessária';
$_['error_empty_merchant_id'] = 'ID de mercado é necessário';
$_['error_curreny'] = 'Sua loja deve ter %s moedas instaladas e habilitadas';
$_['error_upload'] = 'Falha de envio';

// Checkout button settings
$_['text_button_settings'] = 'Edições de botão de Checkout';
$_['text_colour'] = 'Cor:';
$_['text_orange'] = 'Laranja';
$_['text_tan'] = 'Castanho';
$_['text_white'] = 'Branco';
$_['text_light'] = 'Claro';
$_['text_dark'] = 'Escuro';
$_['text_size'] = 'Tamanho:';
$_['text_medium'] = 'Médio';
$_['text_large'] = 'Grande';
$_['text_x_large'] = 'Extra grande';
$_['text_background'] = 'Fundo:';
$_['text_download'] = '<a href="%s">Baixar</a> arquivo de template';

// Messages
$_['text_success'] = 'O módulo de pagamentos da Amazon foi atualizado';

// Order Info
$_['text_amazon_details'] = 'Detalhes Amazon';
$_['text_amazon_order_id'] = 'ID de pedido Amazon:';
$_['text_upload'] = 'Carregar';
$_['text_upload_template'] = 'Envie o preenchido no template clicando no botão abaixo. Certifique-se de que está salvo como arquivo delimitado por tabulação.';
$_['tab_order_adjustment'] = 'Ajuste de pedido';

//Table columns
$_['column_submission_id'] = 'Submissão de ID';
$_['column_status'] = 'Status';
$_['column_text'] = 'Resposta';
$_['column_amazon_order_item_code'] = 'Código de pedido de produto Amazon';
?>