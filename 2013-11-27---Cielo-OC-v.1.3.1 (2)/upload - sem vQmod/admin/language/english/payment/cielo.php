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

// Heading
$_['heading_title'] = 'Cielo (by Victor Schröder)';

// Text Success and Error
$_['text_success'] = 'Cielo module was successful modified.';
$_['install_success'] = 'The payment module Cielo was successful installed and the necessary tables has been created in you database.';
$_['error_permission'] = 'You don\'t have permission to edit the Cielo payment module.';
$_['uninstall_success'] = 'Sad to see you go... The Cielo payment module was uninstalled, the module\'s tables has been dropped from your database and a backup was written in OpenCart\'s log folder.';

// Payments => Cielo
$_['text_description'] = 'The Cielo payment module has been created to allow the direct comunication between your store and the Cielo\'s servers, without any intermediates, lowering your expenses with payment gateways. Some requirementes are needed to use this module. To know more, <a href="http://developers.egeeks.com.br/modulo-cielo-opencart.html" target="_blank">click here</a><br /><br />This module is a independent solution, making use of the Cielo\'s comunication API, not being endorsed nor having any official connection with Cielo.';
$_['entry_sandbox_mode'] = 'Run in sandbox mode?&nbsp;&nbsp;<img src="view/image/cielo_help.png" class="tip" title="With sandbox mode on, you can run tests with arbitrary credit card numbers. In this case, there is no need to fill your affiliation number and secure key." />';
$_['entry_estabelecimento'] = 'Cielo Affiliation Number&nbsp;&nbsp;<img src="view/image/cielo_help.png" class="tip" title="Fill with your store\'s affiliation number, provided by Cielo." />';
$_['entry_chave_seguranca'] = 'Chave de Segurança&nbsp;&nbsp;<img src="view/image/cielo_help.png" class="tip" title="Fill with your secure key, provided by Cielo. The secure key must be keep secret and shouldn\'t be shared with others." />';
$_['entry_buy_page'] = '<i>Buy Page</i> implementation<br /><span class="help">Two options: "Cielo" <img src="view/image/cielo_help.png" class="tip" title="By using &quot;Cielo&quot; buy page, the credit card information will be fill by your customer on a secure page provided by Cielo through a redirection, then returning back to the store after processing." /> or "Store" <img src="view/image/cielo_help.png" class="tip" title="By using &quot;Store&quot; buy page, all credit card data will be filled directly in the checkout page, without redirections. This can be positive to low the cart abandonment, but the store\'s security requirements and responsability are greater."  />';
$_['text_buy_page_loja'] = 'Store';
$_['entry_exibicao_checkout'] = 'Checkout display&nbsp;&nbsp;<img src="view/image/cielo_help.png" class="tip" title="Choose to display in checkout page: credit card logos or only their names." />';
$_['text_exibicao_checkout_img'] = 'Credit card\'s logos';
$_['text_exibicao_checkout_text'] = 'Credit card\'s names';
$_['entry_soft_descriptor'] = '<i>Soft Descriptor</i>&nbsp;&nbsp;<img src="view/image/cielo_help.png" class="tip" title="The total character length of your store name (in Cielo files) plus soft descriptor can\'t exceed 19 characters. Selecting &quot;order n°&quot;, the system will generate a unique identification with seven characters in this format: &quot;P000123&quot;" /><br /><span class="help">Personalized text that will appear in your customer\'s credit card bill, after the store\'s name (as done by PayPal, Facebook, Google, etc.).</span>';
$_['text_usar_nenhum'] = 'None';
$_['text_usar_num_pedido'] = 'Order N°';
$_['text_usar_outro'] = 'Other text (max. 13 characters):';
$_['entry_habilitar_operacao'] = 'Enable this operation?';
$_['entry_operacao_nome'] = 'Exibition label:';
$_['entry_operacao_valor_minimo'] = 'Minimum value:';
$_['entry_operacao_parc_minima'] = 'Minimum installment:';
$_['entry_operacao_desconto'] = 'Discount:<br /><span class="help">For one installment</span>';
$_['entry_operacao_max_parc'] = 'Maximum installments quantity:';
$_['entry_operacao_max_parc_sj'] = 'Maximum installments quantity<br />without interest:';
$_['entry_operacao_max_parc_jl'] = 'Maximum installments quantity<br />with store interest:';
$_['entry_operacao_juros_loja'] = 'Store interest rate';
$_['entry_operacao_auto_capturar'] = 'Automatic capture?&nbsp;&nbsp;<img src="view/image/cielo_help.png" class="tip" title="Transactions without automatic capture must be captured until five days or will be canceled!" />';
$_['entry_operacao_autorizacao'] = 'Authorization type';
$_['text_autorizacao_0'] = '0-Don\'t authorize, only authenticate';
$_['text_autorizacao_1'] = '1-Authorize only if authenticated';
$_['text_autorizacao_2'] = '2-Authorize authenticated or not';
$_['text_autorizacao_3'] = '3-Direct authorization (without authentication)';
$_['text_autorizacao_4'] = '4-Recurring authorization';
$_['entry_status_pedido_pendente'] = 'Pending payment order status';
$_['entry_status_pedido_erro_sem_retry'] = 'Error with retry order status';
$_['entry_status_pedido_erro_com_retry'] = 'Error without retry order status';
$_['entry_status_pedido_sucesso_sem_captura'] = 'Authorized and not yet captured order status';
$_['entry_status_pedido_sucesso_com_captura'] = 'Authorized and captured order status';
$_['entry_geo_zone'] = 'Regions enabled for this method';
$_['entry_status'] = 'Status';
$_['entry_sort_order'] = 'Sort order';
$_['text_author'] = 'Cielo payment OpenCart module created by <a href="http://developers.egeeks.com.br/">Victor Schröder</a>.<br />All rights reserved. To use this payment module you must buy a commercial license per domain.<br />If you didn\'t bought this module <a href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=8855" target="_blank">click here</a> to purchase a license.<br /><br />The clueTip jQuery plugin is free to use (MIT/GPL licences) and might be found <a href="http://plugins.learningjquery.com/cluetip/" target="_blank">here</a>.';
$_['text_payment'] = 'Payments';

// Operações
$_['entry_operacao_visa_electron'] = 'Visa Electron (debit) settings';
$_['entry_operacao_redeshop'] = 'Redeshop/Maestro (debit) settings';
$_['entry_operacao_visa'] = 'Visa (credit) settings';
$_['entry_operacao_mastercard'] = 'Mastercard (credit) settings';
$_['entry_operacao_diners'] = 'Diners Club (credit) settings';
$_['entry_operacao_amex'] = 'American Express (credit) settings';
$_['entry_operacao_elo'] = 'Elo (credit) settings';
$_['entry_operacao_discover'] = 'Discover (credit) settings';
$_['entry_operacao_jcb'] = 'JCB (credit) settings';
$_['entry_operacao_aura'] = 'Aura (credit) settings';


//Sale => Order => getCielo
$_['tab_cielo'] = 'Cielo History';
$_['table_resumo_title'] = 'Resume TID';
$_['table_resumo_sem_consultas'] = 'This TID doesn\'t have any consult yet.<br />Please run a consult to refresh the status.';
$_['table_resumo_transacao'] = 'Transaction:';
$_['table_resumo_status'] = 'Status:';
$_['table_resumo_bandeira'] = 'Label:';
$_['table_resumo_operacao'] = 'Operation:';
$_['table_resumo_n_parcelas'] = 'Installments:';
$_['table_resumo_autenticacao'] = 'Authentication (ECI):';
$_['table_resumo_autorizacao'] = 'Authorization:';
$_['table_resumo_codigo_lr'] = 'LR code:';
$_['table_resumo_mensagem_cielo'] = 'Cielo message (pt-BR):';
$_['table_resumo_data'] = 'Date:';
$_['table_resumo_valor'] = 'Value:';
$_['table_resumo_captura'] = 'Capture:';
$_['table_resumo_cancelamentos'] = 'Cancellations:';
$_['table_resumo_cancel_valor_data'] = '%1$s on %2$s';
$_['table_resumo_cancel_total'] = 'Cancellation total:';
$_['cielo_text_table_title'] = 'Cielo transactions history';
$_['cielo_text_tab_transacao'] = 'Type';
$_['cielo_text_tab_tid'] = 'TID';
$_['cielo_text_tab_buy_page'] = 'Buy Page';
$_['cielo_text_tab_teste'] = 'Test?';
$_['cielo_text_tab_operacao'] = 'Operation';
$_['cielo_text_tab_status'] = 'Status';
$_['cielo_text_tab_valor'] = 'Value';
$_['cielo_text_tab_parcelas'] = 'Installments';
$_['cielo_text_selecione_tid'] = 'TID to operate';
$_['cielo_text_selecione_acao'] = 'Action to perform';
$_['cielo_text_selecione_valor'] = 'Value&nbsp;&nbsp;<img src="view/image/cielo_help.png" class="tip" title="Value in Reais (R$ BRL). Only to partial capture and cancellations. If empty, will assume the total order value." />';
$_['cielo_text_proxima_acao'] = 'Send administrative operation?';
$_['cielo_text_option_tid'] = '----- Select TID -----';
$_['cielo_text_option_acao'] = '----- Select action -----';
$_['cielo_text_capturar'] = 'Capture';
$_['cielo_text_cancelar'] = 'Cancel';
$_['cielo_text_consultar'] = 'Consult';
$_['cielo_text_autorizar'] = 'Authorize';
$_['cielo_text_executar'] = 'Send to Cielo';
$_['transacao_transacao'] = 'Transaction';
$_['transacao_capturar'] = 'Capture';
$_['transacao_capturar_parcial'] = 'Partial Capture';
$_['transacao_cancelar'] = 'Cancellation';
$_['transacao_cancelar_parcial'] = 'Partial Cancellation';
$_['transacao_consultar'] = 'Consult';
$_['transacao_autorizar_tid'] = 'Authorization';
$_['buy_page_loja'] = 'Store';
$_['buy_page_cielo'] = 'Cielo';
$_['buy_page_admin'] = 'Admin';

$_['traduz_status_'] = 'Not defined';
$_['traduz_status_0'] = '0-Created';
$_['traduz_status_1'] = '1-Processing';
$_['traduz_status_10'] = '10-In athentication';
$_['traduz_status_2'] = '2-Authenticated';
$_['traduz_status_3'] = '3-Not authenticated';
$_['traduz_status_5'] = '5-Not authorized';
$_['traduz_status_4'] = '4-Authorized';
$_['traduz_status_12'] = '12-Canceling';
$_['traduz_status_9'] = '9-Canceled';
$_['traduz_status_6'] = '6-Captured';

$_['traduz_bandeira_visa'] = 'Visa';
$_['traduz_bandeira_mastercard'] = 'Mastercard';
$_['traduz_bandeira_amex'] = 'American Express';
$_['traduz_bandeira_diners'] = 'Diners Club';
$_['traduz_bandeira_elo'] = 'Elo';
$_['traduz_bandeira_discover'] = 'Discover';
$_['traduz_bandeira_jcb'] = 'JCB';
$_['traduz_bandeira_aura'] = 'Aura';

$_['traduz_produto_A'] = 'Debit';
$_['traduz_produto_1'] = 'Credit';
$_['traduz_produto_2'] = 'Parceled by store';
$_['traduz_produto_3'] = 'Parceled by administrator';

$_['traduz_eci_0'] = '0-Without authentication';
$_['traduz_eci_1'] = '1-Without authentication ways in issuer bank';
$_['traduz_eci_2'] = '2-Successfuly authenticated';
$_['traduz_eci_5'] = '5-Successfuly authenticated';
$_['traduz_eci_6'] = '6-Without authentication ways in issuer bank';
$_['traduz_eci_7'] = '7-Without authentication';
$_['traduz_eci_NNN'] = 'There is no authentication status registred<br />It is recommended to make a consult<br />to check the current status.';

$_['traduz_lr_00'] = '00-Successfuly authorized.';
$_['traduz_lr_01'] = '01-Referred by issuer. Verify with Cielo.';
$_['traduz_lr_04'] = '04-Card with restrictions.';
$_['traduz_lr_05'] = '05-Not authorized.';
$_['traduz_lr_06'] = '06-Communication error.';
$_['traduz_lr_07'] = '07-Card with restrictions.';
$_['traduz_lr_12'] = '12-Invalid transaction.';
$_['traduz_lr_13'] = '13-Invalid value.';
$_['traduz_lr_14'] = '14-Invalid card.';
$_['traduz_lr_15'] = '15-Invalid issuer.';
$_['traduz_lr_41'] = '41-Card with restrictions.';
$_['traduz_lr_51'] = '51-Insufficient funds.';
$_['traduz_lr_54'] = '54-Card expired.';
$_['traduz_lr_57'] = '57-Not allowed.';
$_['traduz_lr_58'] = '58-Not allowed.';
$_['traduz_lr_62'] = '62-Card with restrictions.';
$_['traduz_lr_63'] = '63-Card with restrictions.';
$_['traduz_lr_76'] = '76-Communication error.';
$_['traduz_lr_78'] = '78-Card not unlocked.';
$_['traduz_lr_82'] = '82-Invalid transaction.';
$_['traduz_lr_91'] = '91-Bank unavailable.';
$_['traduz_lr_96'] = '96-Communication error.';
$_['traduz_lr_AA'] = 'AA-Communication error.';
$_['traduz_lr_AC'] = 'AC-Credit not allowed to debit card.';
$_['traduz_lr_GA'] = 'GA-Referred by Cielo. Verify with Cielo.';
$_['traduz_lr_N7'] = 'N7-Invalid security code.';
$_['traduz_lr_NNN'] = 'Unregistered code.';

// Text script
$_['text_script_title'] = 'Processing operation';
$_['text_script_title_alerta'] = 'Alert';
$_['text_script_nao_feche'] = 'Dont close this window. Waiting Cielo response. This proccess can take until 40 seconds, please wait.';
$_['text_script_ocorreu_um_erro'] = 'An error occurred.<br /><br />Error information:<br />Code:';
$_['text_script_captura_processada'] = 'Capture operation processed, this is the result:<br /><br />Code:';
$_['text_script_cancelamento_processado'] = 'Cancellation operation processed, this is the result:<br /><br />Code:';
$_['text_script_consulta_processada'] = 'Consult operation processed, this is the result:<br /><br />XML:';
$_['text_script_autorizacao_processada'] = 'Authorization operation processed, this is the result:<br /><br />Code:';
$_['text_script_erro_inesperado'] = 'An unexpected error occurred.';
$_['text_script_erro_timeout'] = 'Operation timeout.<br /><br />Error information:';
$_['text_script_erro_comunicacao'] = 'A technical communication error occurred between the servers.<br /><br />Error information:';
$_['text_script_erro_negativo'] = 'This field doesnt accept negative values.';
$_['text_script_erro_NAN'] = 'The value is not a number or is bad formated.';
$_['text_script_erro_soft_descriptor'] = 'Cielo doesnt accept <i>soft descriptor</i> with more than 13 characters.';
$_['text_script_erro_valor_minimo'] = 'Cielo doesnt accept installment values under R$ 5.00.';
$_['text_script_botao_retornar'] = 'Return';
$_['text_script_botao_fechar'] = 'Close';
$_['text_script_mensagem'] = 'Message';
$_['text_script_valor'] = 'Value';
$_['text_script_parc_sj_desativado'] = 'Interest-free installments payment deactivated.';
$_['text_script_parc_loja_desativado'] = 'Store interest installments payment deactivated.';
$_['text_script_parc_admin_desativado'] = 'Administrator interest installments payment deactivated.';
$_['text_script_parc_sj_ativo'] = 'from 2 to {0} interest-free installments.';
$_['text_script_parc_loja_ativo'] = 'from {0} to {1} installments with store interest.';
$_['text_script_parc_admin_ativo'] = 'from {0} to {1} installments with administrator interest.';

//Sale => Order => ajaxcielo
$_['cielo_erro_inesperado'] = 'An unexpected error occurred!';
 ?>