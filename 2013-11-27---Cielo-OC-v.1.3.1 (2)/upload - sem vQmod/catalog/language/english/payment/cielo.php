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

// Model
$_['text_title'] = 'Credit/debit cards';
$_['text_total_cielo_desc'] = 'Discount';
$_['text_total_cielo_juros'] = 'Interest';

// View
$_['warning_sandbox_mode'] = 'The credit card system is in test mode. Please choose another payment method.';
$_['cielo_buy_page_info'] = 'Please select below the desired payment method and click confirm. You\'ll fill your credit card data on the next page, in a secure page.';
$_['loja_buy_page_info'] = 'Please enter your credit card information below and select the desired payment method';
$_['erro_sem_operacoes'] = 'Ops, it seems that we are not able to accept credit cards in this purchase. Maybe your order value is too low. Please choose another payment method or add more itens to your cart.';
$_['entry_nome_portador'] = 'Cardholder name:';
$_['entry_numero_cartao'] = 'Card number:';
$_['entry_validade_cartao'] = 'Expiration date (MM/YYYY):';
$_['entry_codigo_seguranca'] = 'Security code:';
$_['text_codigo_inexistente'] = 'nonexistent';
$_['text_codigo_ilegivel'] = 'unreadable';
$_['text_envia_erro'] = 'I was trying to make a purchase in your store when I received this error message:\\n\\n';
$_['cielo_instrucoes_cvv'] = '<b>How to find the security code:</b><br /><br />To Visa, Mastercard, Diners Club, Elo and Discover cards: the last three numbers on the back of the card near the signature place.<br /><br />To American Express cards: four numbers in front of the card above the main numbering.<br /><br />If your card does not have this code or if it is unreadable, select the appropriate option. However, your card may be refused by the carrier for lack of security code.';
$_['form_1_parcela'] = '%1$02d installment of %2$s';
$_['form_1_parcela_desconto'] = ' with %01.2f%% off.';
$_['form_parcelas_sem_juros'] = '%1$02d installments of %2$s interest-free.';
$_['form_parcelas_com_juros'] = '%1$02d installments of %2$s with %3$01.2f%% p.m. interest';
$_['form_parcelas_juros_adm'] = '%02d installments with your administrator\'s interest.';
$_['text_script_nao_feche'] = 'Dont close this window. We are processing your credit card information. This process can take up to 40 seconds, please wait.';
$_['text_script_title'] = 'Processing credit card';
$_['text_script_erro_preenchimento'] = 'There was a filling error. Please return to the previous page and make sure all your card information is correct or choose another payment method.<br /><br />Error information:<br />Code:';
$_['text_script_falha_comunicacao'] = 'A communication error occurred. You can try again, or go back and choose another payment method.<br /><br />Error information:<br />Code:';
$_['text_script_ocorreu_um_erro'] = 'An error occurred. Please make sure all your card information is correct or choose another payment method.<br /><br />Error information:<br />Code:';
$_['text_script_redirecionando'] = 'You will be redirected to the Cielos secure payment plage. If you are not redirected, click the button below.';
$_['text_script_pedido_aprovado'] = 'Your order has been successfully approved! Click the button below to see the details of your order.';
$_['text_script_erro_inesperado'] = 'An unexpected error occurred. Do not try the request again because duplication may occur. Please contact us.';
$_['text_script_erro_timeout'] = 'Operation timeout. Do not try the request again because duplication may occur. Please contact us.<br /><br />Error information:';
$_['text_script_erro_tecnico'] = 'Technical error on the servers. Do not try the request again because duplication may occur. Please contact us.<br /><br />Error information:';


$_['text_script_botao_retornar'] = 'Return';
$_['text_script_botao_retry'] = 'Try again';
$_['text_script_botao_redirecionar'] = 'Go to payment page';
$_['text_script_botao_finalizar'] = 'Continue';
$_['text_script_botao_contato'] = 'Go to contact page';


// Cielo => Confirm
$_['erro_preenchimento'] = 'Card information filling error';
$_['erro_bandeira_nao_selecionada'] = 'Carrier not selected';
$_['erro_bandeira_invalida'] = 'Invalid or not activated carrier';
$_['erro_numero_parcelas_nao_selecionado'] = 'Installments quantity not selected';
$_['erro_numero_parcelas_invalido'] ='Invalid installments quantity';
$_['erro_numero_cartao_nao_preenchido'] = 'Card number not filled';
$_['erro_numero_cartao_invalido'] = 'Invalid card number';
$_['erro_validade_nao_preenchida'] = 'Expiration date not filled';
$_['erro_validade_inferior_atual'] = 'Expiration date cannot be lower then present date';

// Error codes
$_['erro_code_server'] = 'Internal error, communication failure (cURL)';

// XML error codes
$_['XML_error_code_001'] = 'Configuration error (XML). Please contact us.';
$_['XML_error_code_002'] = 'Configuration error (credentials). Please contact us.';
$_['XML_error_code_003'] = 'Invalid or nonexistent payment form.';
$_['XML_error_code_010'] = 'Configuration error (buy page). Please contact us.';
$_['XML_error_code_011'] = 'Payment form not enabled in this store. Please contact us.';
$_['XML_error_code_012'] = 'Installment quantity higher than allowed.';
$_['XML_error_code_013'] = 'Configuration error (authorization flag). Please contact us.';
$_['XML_error_code_014'] = 'Configuration error (authorization 3). Please contact us.';
$_['XML_error_code_015'] = 'There is no card data to authorization. Please contact us.';
$_['XML_error_code_016'] = 'Configuration error (TID). Please contact us.';
$_['XML_error_code_017'] = 'Security code absent. If using American Express this information is mandatory.';
$_['XML_error_code_018'] = 'Problems with the security code identifier. Please contact us.';
$_['XML_error_code_019'] = 'Configuration error (URL de retorno). Please contact us.';
$_['XML_error_code_020'] = 'This transaction has been already authorized or does not allow authorization. Please contact us.';
$_['XML_error_code_021'] = 'Authorization deadline expired.';
$_['XML_error_code_025'] = 'Problems in authorization process. Please contact us.';
$_['XML_error_code_030'] = 'This transaction has been already captured or does not allow capture. Please contact us.';
$_['XML_error_code_031'] = 'Capture deadline expired.';
$_['XML_error_code_032'] = 'Invalid capture value. Please contact us.';
$_['XML_error_code_033'] = 'Capture failure. Tente novamente.';
$_['XML_error_code_040'] = 'Cancellation deadline expired.';
$_['XML_error_code_041'] = 'This transaction has been already canceled or does not allow cancellation.';
$_['XML_error_code_042'] = 'Cancellation failure. Try again.';
$_['XML_error_code_043'] = 'Cancellation value cannot be higher than captured value.';
$_['XML_error_code_053'] = 'Recurring authorization not enabled for this store. Please contact us.';
$_['XML_error_code_097'] = 'System temporarily unavailable. Try again in a few minutes.';
$_['XML_error_code_098'] = 'Operation timeout. Try again.';
$_['XML_error_code_099'] = 'Administrator system error. Please contact us.';
$_['XML_error_code_NNN'] = 'Unregistered error code. Please contact us.';

// XML lr codes
$_['XML_lr_code_00'] = 'Transaction successfuly authorized.';
$_['XML_lr_code_01'] = 'Transaction referred by issuer. Please contact your card issuer.';
$_['XML_lr_code_04'] = 'Your card is with some restriction. Please contact your card issuer.';
$_['XML_lr_code_05'] = 'Not authorized.';
$_['XML_lr_code_06'] = 'Communication error. Please try again.';
$_['XML_lr_code_07'] = 'Your card is with some restriction. Please contact your card issuer.';
$_['XML_lr_code_12'] = 'Invalid transaction type for your card.';
$_['XML_lr_code_13'] = 'Invalid authorization value. Did you reach the minimum value of R$ 5,00?';
$_['XML_lr_code_14'] = 'Invalid card.';
$_['XML_lr_code_15'] = 'Your card issuer is not valid for this type of transaction.';
$_['XML_lr_code_41'] = 'Your card is with some restriction. Please contact your card issuer.';
$_['XML_lr_code_51'] = 'Insufficient funds. Please verify your balance and try again.';
$_['XML_lr_code_54'] = 'Your card is expired.';
$_['XML_lr_code_57'] = 'Transaction type not allowed for your card.';
$_['XML_lr_code_58'] = 'Transaction type not allowed for your card';
$_['XML_lr_code_62'] = 'Your card is with some restriction. Please contact your card issuer.';
$_['XML_lr_code_63'] = 'Your card is with some restriction. Please contact your card issuer.';
$_['XML_lr_code_76'] = 'Communication error. Please try again.';
$_['XML_lr_code_78'] = 'Your card has not been unlocked. Please contact your card issuer to unlock it and try again.';
$_['XML_lr_code_82'] = 'Invalid transaction type for your card.';
$_['XML_lr_code_91'] = 'The bank system is unavailable. Please try again in a few minutes.';
$_['XML_lr_code_96'] = 'Communication error. Please try again.';
$_['XML_lr_code_AA'] = 'Communication error. Please try again.';
$_['XML_lr_code_AC'] = 'Credit operations are not allowed to debit card.';
$_['XML_lr_code_GA'] = 'Transaction referred by Cielo. Please contact us.';
$_['XML_lr_code_N7'] = 'Invalid security code (Visa).';
$_['XML_lr_code_NNN'] = 'Unregistered error code. Please contact us.';

// XML status codes
$_['XML_status_code_4'] = 'Transaction successfuly authorized.';
$_['XML_status_code_6'] = 'Transaction successfuly authorized.';

$_['XML_status_code_0'] = 'Transaction created but not yet processed.';
$_['XML_status_code_1'] = 'Processing transaction.';
$_['XML_status_code_3'] = 'Transaction not authenticated.';
$_['XML_status_code_10'] = 'Authenticating transaction.';

$_['XML_status_code_5'] = 'Transaction not authorized.';
$_['XML_status_code_9'] = 'Transaction canceled.';
$_['XML_status_code_12'] = 'Canceling transaction.';

$_['XML_status_code_2'] = 'Transaction authenticated but not yet processed.';
$_['XML_status_code_8'] = 'Transaction processed but not yet charged.';

$_['XML_status_code_NA'] = 'Unregistered status code. Please contact us.';

// Cielo => retorno
$_['retorno_heading_title'] = 'Card return page';
$_['text_checkout'] = 'Checkout';
$_['retorno_compra_nao_confirmada'] = 'Your order has not been confirmed yet. Check the reason below:';
$_['retorno_codigo_evento'] = 'Event or error code:';
$_['retorno_descricao_evento'] = 'Description:';
$_['retorno_erro_nao_definitivo'] = 'This is not a ultimate error, you still can go back and try to use the same card or choose another payment method.';
$_['retorno_escolher_outra_forma'] = 'Don\'t leave your cart behind! You still can go back and choose another payment method.';
$_['retorno_voltar_ao_checkout'] = 'Click here to return to checkout page.';
?>