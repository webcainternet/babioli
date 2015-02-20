<?php
//Headings
$_['heading_title'] = 'PayPal Payflow Pro iFrame';
$_['heading_refund'] = 'Reembolso';

//Table columns
$_['column_transaction_id'] = 'ID de transação';
$_['column_transaction_type'] = 'Tipo de trasação';
$_['column_amount'] = 'Quantidade';
$_['column_time'] = 'Tempo';
$_['column_actions'] = 'Ações';

//Text
$_['text_payment'] = 'Pgamento';
$_['text_success'] = 'Você modificou os detalhe da conta PayPal Payflow Pro iFrame com sucesso!';
$_['text_pp_payflow_iframe'] = '<a onclick="window.open(\'\');"><img src="view/image/payment/paypal.png" alt="PayPal Payflow Pro" title="PayPal Payflow Pro iFrame" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_authorization'] = 'Autorização';
$_['text_sale'] = 'Venda';
$_['text_authorise'] = 'Autorizar';
$_['text_capture'] = 'Captura adiada';
$_['text_void'] = 'Anulado';
$_['text_payment_info'] = 'Informação de pagamento';
$_['text_complete'] = 'Completo';
$_['text_incomplete'] = 'Incompleto';
$_['text_transaction'] = 'Transação';
$_['text_confirm_void'] = 'Se você anular não poderá capturar nenhum outro fundo';
$_['text_refund'] = 'Reembolsar';
$_['text_refund_issued'] = 'O reembolso foi emitido com sucesso';
$_['text_redirect'] = 'Redirecionar';
$_['text_iframe'] = 'Iframe';
$_['help_vendor'] = 'Seu ID de mercador de quando você registrou para a conta do Website Payments Pro.';
$_['help_user'] = 'Se você configurar um ou mais usuários adicionais na conta, este valor é o ID do usuário autorizado para processar as transações. Se, entretanto, você não tiver configurado usuários adicionais na conta, USUÁRIO terá o mesmo valor que VENDEDOR.';
$_['help_password'] = 'A senha de 6 a 32 caracteres que você definiu enquanto registrava a conta.';
$_['help_partner'] = 'O ID provido para você pelo PayPal Reseller autorizado que o registrou para o Payflow SDK. Se você comprou sua conta diretamente do PauPal, use PayPal';
$_['help_checkout_method'] = "Por favor, use o método de recirecionamento caso você não tenha instalado o SSL ou caso você não tenha feito o pagamento com a opção do PayPal desabilitada em sua página de pagamento hospedada.";
$_['help_debug'] = "Informações adicionais de logs.";

//Buttons
$_['button_refund'] = 'Reembolso';
$_['button_void'] = 'Anular';
$_['button_capture'] = 'Capturar';

//Tabs
$_['tab_settings'] = 'Configurações';
$_['tab_order_status'] = 'Status de pedido';
$_['tab_checkout_customisation'] = 'Personalização de Checkout';

//Form entry
$_['entry_vendor'] = 'Vendedor:';
$_['entry_user'] = 'Usuário:';
$_['entry_password'] = 'Senha:';
$_['entry_partner'] = 'Parceiro:';
$_['entry_test'] = 'Modo de teste:<br /><span class="help">Usar o serviço live de gateway ou de testes (sandbox) para processar transações? O teste pode falhar se você estiver usando o Internet Explorer</span>';
$_['entry_total'] = 'Total:<br /><span class="help">O total de checkouts de pedidos devem chegar antes que o método de pagamento se torne ativo.</span>';
$_['entry_order_status'] = 'Status de pedido:';
$_['entry_geo_zone'] = 'Zona geográfica:';
$_['entry_status'] = 'Status:';
$_['entry_sort_order'] = 'Ordenar pedidos:';
$_['entry_transaction_method'] = 'Método de transação:';
$_['entry_transaction_id'] = 'ID de transação';
$_['entry_full_refund'] = 'Reembolso total';
$_['entry_amount'] = 'Quantidade';
$_['entry_message'] = 'Mensagem';
$_['entry_ipn_url'] = 'URL do IPN:';
$_['entry_checkout_method'] = 'Método de Checkout:';
$_['entry_debug'] = 'Modo de depuração:';
$_['entry_transaction_reference'] = 'Referência de transaçao';
$_['entry_transaction_amount'] = 'Quantidade de transação';
$_['entry_refund_amount'] = 'Quantidade de reembolso';
$_['entry_capture_status'] = 'Status de captura';
$_['entry_void'] = 'Anular';
$_['entry_capture'] = 'Capturar';
$_['entry_transactions'] = 'Transações';
$_['entry_complete_capture'] = 'Captura completa';
$_['entry_canceled_reversal_status'] = 'Status reverso cancelado:';
$_['entry_completed_status'] = 'Status completo:';
$_['entry_denied_status'] = 'Status negado:';
$_['entry_expired_status'] = 'Status expirado:';
$_['entry_failed_status'] = 'Status falho:';
$_['entry_pending_status'] = 'Status pendente:';
$_['entry_processed_status'] = 'Status processado:';
$_['entry_refunded_status'] = 'Status reembolsado:';
$_['entry_reversed_status'] = 'Status reverso:';
$_['entry_voided_status'] = 'Status anulado:';
$_['entry_cancel_url'] = 'Cancelar URL:';
$_['entry_error_url'] = 'URL com erro:';
$_['entry_return_url'] = 'URL de retorno:';
$_['entry_post_url'] = 'Silent POST URL:';

//Errors
$_['error_permission'] = 'Aviso: você não tem permissão para modificar o pagamento PayPal Website Payment Pro iFrame (UK)!';
$_['error_vendor'] = 'O vendedor é requerido!';
$_['error_user'] = 'Usuário requerido!';
$_['error_password'] = 'A senha é requerida!';
$_['error_partner'] = 'O parceiro é requerido!';
$_['error_missing_data'] = 'Dados em falta';
$_['error_missing_order'] = 'Não foi possível encontrar o pedido';
$_['error_general'] = 'Houve um erro';
$_['error_capture_amt'] = 'Insita uma quantidade para capturar';
?>